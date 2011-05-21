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


define('INTERNAL', 1);
//require(get_config('docroot') . 'lib/version.php');
//$release = $config->release;
//if ($release < 1.4) {
// define('MENUITEM', 'myportfolio/cpds');
//} else {
      define('MENUITEM', 'content/cpds');
//}
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'cpds');
define('SECTION_PAGE', 'index');

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'cpds');

define('TITLE', get_string('mycpds','artefact.cpds'));

// offset and limit for pagination
$offset = param_integer('offset', 0);
$limit  = param_integer('limit', 20);

$cpds = ArtefactTypeCpd::get_cpds($offset, $limit);
ArtefactTypeCpd::build_cpds_list_html($cpds);

$js = <<< EOF
addLoadEvent(function () {
    {$cpds['pagination_js']}
});
EOF;

$smarty = smarty(array('paginator'));
$smarty->assign_by_ref('cpds', $cpds);
$smarty->assign('strnocpdsaddone',
    get_string('nocpdsaddone', 'artefact.cpds',
    '<a href="' . get_config('wwwroot') . 'artefact/cpds/new.php">', '</a>'));
$smarty->assign('PAGEHEADING', hsc(get_string("mycpds", "artefact.cpds")));
$smarty->assign('INLINEJAVASCRIPT', $js);
$smarty->display('artefact:cpds:index.tpl');

?>
