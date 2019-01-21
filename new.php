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

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'cpds');

$id = param_integer('id', 0);
if ($id) {
    $cpd = new ArtefactTypeCPD($id);
    if (!$USER->can_edit_artefact($cpd)) {
        throw new AccessDeniedException(get_string('accessdenied', 'error'));
    }
    define('TITLE', get_string('newactivity', 'artefact.cpds'));
    $form = ArtefactTypeActivity::get_form($id);
}
else {
    define('TITLE', get_string('newcpd', 'artefact.cpds'));
    $form = ArtefactTypeCPD::get_form();
}

$smarty = smarty();
$smarty->assign('form', $form);
$smarty->assign('PAGEHEADING', hsc(TITLE));
$smarty->display('artefact:cpds:new.tpl');
