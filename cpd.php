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


define('INTERNAL', 1);
define('MENUITEM', 'content/cpds');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'cpds');
define('SECTION_PAGE', 'cpds');

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'cpds');

define('TITLE', get_string('activities', 'artefact.cpds'));

$id = param_integer('id');

// offset and limit for pagination
$offset = param_integer('offset', 0);
$limit  = param_integer('limit', 10);

$cpd = new ArtefactTypeCPD($id);
if (!$USER->can_edit_artefact($cpd)) {
    throw new AccessDeniedException(get_string('accessdenied', 'error'));
}

$activities = ArtefactTypeActivity::get_activities($cpd->get('id'), $offset, $limit);
ArtefactTypeActivity::build_activities_list_html($activities);

$js = <<<EOF
jQuery(function () {
    {$activities['pagination_js']}
});
EOF;

$smarty = smarty(array('paginator'));
$smarty->assign('activities', $activities);
$smarty->assign('cpd', $id);
$smarty->assign('tags', $cpd->get('tags'));
$smarty->assign('owner', $cpd->get('owner'));
$smarty->assign('strnoactivitiesaddone',
    get_string('noactivitiesaddone', 'artefact.cpds',
    '<a href="' . get_config('wwwroot') . 'artefact/cpds/new.php?id=' . $cpd->get('id') . '">', '</a>'));
$smarty->assign('PAGEHEADING', get_string("cpdsactivities", "artefact.cpds", $cpd->get('title')));
$smarty->assign('INLINEJAVASCRIPT', $js);
$smarty->display('artefact:cpds:cpd.tpl');
