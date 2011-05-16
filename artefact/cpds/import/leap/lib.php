<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage artefact-cpds
 * @author     James Kerrigan
 * @author     Geoffrey Rowland 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 James Kerrigan and Geoffrey Rowland geoff.rowland@yeovil.ac.uk
 *
 */

defined('INTERNAL') || die();

/**
 * Implements LEAP2A import of cpd/activity entries into Mahara
 *
 * Mahara currently only has two levels of cpd, but the exporting
 * system may have more, so the strategy will be to find all the cpds
 * that are not part of another cpd, use those for the top level, with
 * everything else crammed in at the second level.
 */

class LeapImportcpds extends LeapImportArtefactPlugin {

    const STRATEGY_IMPORT_AS_cpd = 1;

    // Keep track of cpd ancestors which will become activity parents
    private static $ancestors = array();
    private static $parents = array();

    public static function get_import_strategies_for_entry(SimpleXMLElement $entry, PluginImportLeap $importer) {
        $strategies = array();

        // Mahara can't handle html cpds yet, so don't claim to be able to import them.
        if (PluginImportLeap::is_rdf_type($entry, $importer, 'cpd')
            && (empty($entry->content['type']) || (string)$entry->content['type'] == 'text')) {
            $strategies[] = array(
                'strategy' => self::STRATEGY_IMPORT_AS_cpd,
                'score'    => 90,
                'other_required_entries' => array(),
            );
        }

        return $strategies;
    }

    public static function import_using_strategy(SimpleXMLElement $entry, PluginImportLeap $importer, $strategy, array $otherentries) {

        if ($strategy != self::STRATEGY_IMPORT_AS_cpd) {
            throw new ImportException($importer, 'TODO: get_string: unknown strategy chosen for importing entry');
        }

        $artefactmapping = array();
        $artefactmapping[(string)$entry->id] = self::create_cpd($entry, $importer);
        return $artefactmapping;
    }

    /**
     * Get the id of the cpd entry which ultimately contains this entry
     */
    public static function get_ancestor_entryid(SimpleXMLElement $entry, PluginImportLeap $importer) {
        $entryid = (string)$entry->id;

        if (!isset(self::$ancestors[$entryid])) {
            self::$ancestors[$entryid] = null;
            $child = $entry;

            while ($child) {
                $childid = (string)$child->id;

                if (!isset(self::$parents[$childid])) {
                    self::$parents[$childid] = null;

                    foreach ($child->link as $link) {
                        $href = (string)$link['href'];
                        if ($href != $entryid
                            && $importer->curie_equals($link['rel'], PluginImportLeap::NS_LEAP, 'is_part_of')
                            && $importer->entry_has_strategy($href, self::STRATEGY_IMPORT_AS_cpd, 'cpds')) {
                            self::$parents[$childid] = $href;
                            break;
                        }
                    }
                }

                if (!self::$parents[$childid]) {
                    break;
                }
                if ($child = $importer->get_entry_by_id(self::$parents[$childid])) {
                    self::$ancestors[$entryid] = self::$parents[$childid];
                }
            }
        }

        return self::$ancestors[$entryid];
    }


    /**
     * Creates a cpd or activity from the given entry
     *
     * @param SimpleXMLElement $entry    The entry to create the cpd or activity from
     * @param PluginImportLeap $importer The importer
     * @return array A list of artefact IDs created, to be used with the artefact mapping.
     */
    private static function create_cpd(SimpleXMLElement $entry, PluginImportLeap $importer) {

        // First decide if it's going to be a cpd or a activity depending
        // on whether it has any ancestral cpds.

        if (self::get_ancestor_entryid($entry, $importer)) {
            $artefact = new ArtefactTypeactivity();
        }
        else {
            $artefact = new ArtefactTypecpd();
        }

        $artefact->set('title', (string)$entry->title);
        $artefact->set('description', PluginImportLeap::get_entry_content($entry, $importer));
        $artefact->set('owner', $importer->get('usr'));
        if (isset($entry->author->name) && strlen($entry->author->name)) {
            $artefact->set('authorname', $entry->author->name);
        }
        else {
            $artefact->set('author', $importer->get('usr'));
        }
        if ($published = strtotime((string)$entry->published)) {
            $artefact->set('ctime', $published);
        }
        if ($updated = strtotime((string)$entry->updated)) {
            $artefact->set('mtime', $updated);
        }

        $artefact->set('tags', PluginImportLeap::get_entry_tags($entry));

        // Set startdate and hours status if we can find them
        if ($artefact instanceof ArtefactTypeactivity) {

            $namespaces = $importer->get_namespaces();
            $ns = $importer->get_leap2a_namespace();

            $dates = PluginImportLeap::get_leap_dates($entry, $namespaces, $ns);
            if (!empty($dates['target']['value'])) {
                $startdate = strtotime($dates['target']['value']);
            }
            $artefact->set('startdate', empty($startdate) ? $artefact->get('mtime') : $startdate);

            if ($entry->xpath($namespaces[$ns] . ':status[@' . $namespaces[$ns] . ':stage="hours"]')) {
                $artefact->set('hours', 1);
            }
        }

        $artefact->commit();

        return array($artefact->get('id'));
    }

    /**
     * Set activity parents
     */
    public static function setup_relationships(SimpleXMLElement $entry, PluginImportLeap $importer) {
        if ($ancestorid = self::get_ancestor_entryid($entry, $importer)) {
            $ancestorids = $importer->get_artefactids_imported_by_entryid($ancestorid);
            $artefactids = $importer->get_artefactids_imported_by_entryid((string)$entry->id);
            if (empty($artefactids[0])) {
                throw new ImportException($importer, 'activity artefact not found: ' . (string)$entry->id);
            }
            if (empty($ancestorids[0])) {
                throw new ImportException($importer, 'cpd artefact not found: ' . $ancestorid);
            }
            $artefact = new ArtefactTypeactivity($artefactids[0]);
            $artefact->set('parent', $ancestorids[0]);
            $artefact->commit();
        }
    }

}

?>
