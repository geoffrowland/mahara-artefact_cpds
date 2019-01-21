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
safe_require('artefact', 'cpds');

define('TITLE', get_string('deleteactivity', 'artefact.cpds'));

$id = param_integer('id');
$todelete = new ArtefactTypeActivity($id);
if (!$USER->can_edit_artefact($todelete)) {
    throw new AccessDeniedException(get_string('accessdenied', 'error'));
}

$deleteform = array(
    'name'       => 'deleteactivityform',
    'plugintype' => 'artefact',
    'pluginname' => 'cpds',
    'renderer'   => 'div',
    'elements'   => array(
        'submit' => array(
            'type'  => 'submitcancel',
            'value' => array(get_string('deleteactivity', 'artefact.cpds'), get_string('cancel')),
            'goto'  => get_config('wwwroot') . '/artefact/cpds/cpd.php?id=' . $todelete->get('parent'),
        ),
    )
);
$form = pieform($deleteform);

$smarty = smarty();
$smarty->assign('form', $form);
$smarty->assign('PAGEHEADING', $todelete->get('title'));
$smarty->assign('subheading', get_string('deletethisactivity', 'artefact.cpds', $todelete->get('title')));
$smarty->assign('message', get_string('deleteactivityconfirm', 'artefact.cpds'));
$smarty->display('artefact:cpds:delete.tpl');

// calls this function first so that we can get the artefact and call delete on it
function deleteactivityform_submit(Pieform $form, $values) {
    global $SESSION, $todelete;

    $todelete->delete();
    $SESSION->add_ok_msg(get_string('activitydeletedsuccessfully', 'artefact.cpds'));

    redirect('/artefact/cpds/cpd.php?id=' . $todelete->get('parent'));
}
