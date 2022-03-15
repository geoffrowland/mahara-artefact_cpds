<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2011 James Kerrigan and Geoffrey Rowland geoff.rowland@yeovil.ac.uk
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
 *
 */

defined('INTERNAL') || die();

class PluginBlocktypeCpds extends PluginBlocktype {

    public static function get_title() {
        return get_string('title', 'blocktype.cpds/cpds');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.cpds/cpds');
    }

    public static function get_categories() {
        return array('general');
    }

    public static function get_css_icon($blocktypename) {
        return 'plans';
    }

    public static function get_instance_title(BlockInstance $bi) {
        $configdata = $bi->get('configdata');

        if (!empty($configdata['artefactid'])) {
            safe_require('artefact', 'cpds');
            $cpd   = new ArtefactTypeCPD($configdata['artefactid']);
            $title = $cpd->get('title');
            return $title;
        }
        return '';
    }

    public static function render_instance(BlockInstance $instance, $editing=false, $versioning=false) {
        global $exporter;

        require_once(get_config('docroot') . 'artefact/lib.php');
        safe_require('artefact', 'cpds');

        $configdata = $instance->get('configdata');

        $smarty = smarty_core();
        if (isset($configdata['artefactid'])) {
            $cpd = artefact_instance_from_id($configdata['artefactid']);
            $activities = ArtefactTypeActivity::get_activities($configdata['artefactid']);
            $template = 'artefact:cpds:activityrows.tpl';
            $blockid = $instance->get('id');
            if ($exporter) {
                $pagination = false;
            }
            else {
                $baseurl = $instance->get_view()->get_url();
                $baseurl .= ((false === strpos($baseurl, '?')) ? '?' : '&') . 'block=' . $blockid;
                $pagination = array(
                    'baseurl'    => $baseurl,
                    'id'         => 'block' . $blockid . '_pagination',
                    'datatable'  => 'activitytable_' . $blockid,
                    'jsonscript' => 'artefact/cpds/viewactivities.json.php',
                );
            }
            $configdata['block'] = $blockid;
            ArtefactTypeActivity::render_activities($activities, $template, $configdata, $pagination, $editing, $versioning);

            if ($exporter && $activities['count'] > $activities['limit']) {
                $artefacturl = get_config('wwwroot') . 'artefact/artefact.php?artefact=' . $configdata['artefactid']
                    . '&amp;view=' . $instance->get('view');
                $activities['pagination'] = '<a href="' . $artefacturl . '">' . get_string('allactivities', 'artefact.cpds') . '</a>';
            }
            $smarty->assign('description', $cpd->get('description'));
            $smarty->assign('activities', $activities);
            $smarty->assign('owner', $cpd->get('owner'));
            $smarty->assign('tags', $cpd->get('tags'));
        }
        else {
            $smarty->assign('editing', $editing);
            $smarty->assign('nocpds', get_string('nocpdsselectone', 'artefact.cpds'));
        }
        $smarty->assign('blockid', $instance->get('id'));
        return $smarty->fetch('blocktype:cpds:content.tpl');
    }

    // My cpds blocktype only has 'title' option so next two functions return as normal
    public static function has_instance_config(BlockInstance $instance) {
        return true;
    }

    public static function instance_config_form(BlockInstance $instance) {
        $configdata = $instance->get('configdata');
        $owner = $instance->get_view()->get('owner');
        if ($owner) {
            $form = array(
                self::artefactchooser_element((isset($configdata['artefactid'])) ? $configdata['artefactid'] : null)
            );
        }
        else {
            $form['blocktemplatehtml'] = array(
                'type' => 'html',
                'value' => get_string('blockinstanceconfigownerchange', 'mahara'),
            );
            $form['blocktemplate'] = array(
                'type'    => 'hidden',
                'value'   => 1,
            );
        }
        return $form;
    }

    public static function artefactchooser_element($default=null) {
        safe_require('artefact', 'cpds');
        return array(
            'name'          => 'artefactid',
            'type'          => 'artefactchooser',
            'title'         => get_string('cpdstoshow', 'blocktype.cpds/cpds'),
            'defaultvalue'  => $default,
            'blocktype'     => 'cpds',
            'selectone'     => true,
            'search'        => false,
            'artefacttypes' => array('cpd'),
            'template'      => 'artefact:cpds:artefactchooser-element.tpl',
        );
    }

    public static function allowed_in_view(View $view) {
        return true;
    }

    public static function rewrite_blockinstance_config(View $view, $configdata) {
        safe_require('artefact', 'cpds');
        if ($view->get('owner') !== null && !empty($configdata['blocktemplate'])) {
            if ($artefactid = get_column_sql('
                SELECT a.id FROM {artefact} a
                WHERE a.owner = ? AND a.artefacttype = ? LIMIT 1', array($view->get('owner'), 'cpd'))) {
                $configdata['artefactid'] = $artefactid[0];
            }
            else {
                $configdata['artefactid'] = null;
            }
            unset($configdata['blocktemplatehtml']);
            unset($configdata['blocktemplate']);
        }
        return $configdata;
    }
}
