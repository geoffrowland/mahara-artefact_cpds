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

define('INTERNAL', true);
define('MENUITEM', 'content/cpds');

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
require_once('pieforms/pieform.php');
require_once('pieforms/pieform/elements/calendar.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'cpds');

define('TITLE', get_string('editcpd', 'artefact.cpds'));

$id = param_integer('id');

$artefact = new ArtefactTypeCPD($id);
if (!$USER->can_edit_artefact($artefact)) {
    throw new AccessDeniedException(get_string('accessdenied', 'error'));
}

$editform = ArtefactTypeCPD::get_form($artefact);

$smarty = smarty();
$smarty->assign('editform', $editform);
$smarty->assign('PAGEHEADING', hsc(get_string("editcpd", "artefact.cpds")));
$smarty->display('artefact:cpds:edit.tpl');
