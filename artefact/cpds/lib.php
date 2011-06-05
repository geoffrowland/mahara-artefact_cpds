<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2008 Catalyst IT Ltd (http://www.catalyst.net.nz)
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

class PluginArtefactcpds extends PluginArtefact {

    public static function get_artefact_types() {
        return array(
            'activity',
            'cpd',
        );
    }

    public static function get_block_types() {
        return array();
    }

    public static function get_plugin_name() {
        return 'cpds';
    }

    public static function menu_items() {
          return array(
            array(       	
                    'path' => 'content/cpds',
                    'title' => get_string('cpds', 'artefact.cpds'),
                    'url'  => 'artefact/cpds/',
                    'weight' => 40,
            ),
          );
    }

}

class ArtefactTypecpd extends ArtefactType {

    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);
        if (empty($this->id)) {
            $this->container = 1;
        }
    }

    public static function get_links($id) {
        return array();
    }

    public function delete() {
        if (empty($this->id)) {
            return;
        }

        db_begin();
        parent::delete();
        db_commit();
    }

    public static function get_icon($options=null) {
    }

    public static function is_singular() {
        return false;
    }


    /**
     * This function returns a list of the given user's cpds.
     *
     * @param limit how many cpds to display per page
     * @param offset current page to display
     * @return array (count: integer, data: array)
     */
    public static function get_cpds($offset=0, $limit=10) {
        global $USER;

        ($cpds = get_records_sql_array("SELECT * FROM {artefact}
                                        WHERE owner = ? AND artefacttype = 'cpd'
                                        ORDER BY id", array($USER->get('id')), $offset, $limit))
                                        || ($cpds = array());
        $result = array(
            'count'  => count_records('artefact', 'owner', $USER->get('id'), 'artefacttype', 'cpd'),
            'data'   => $cpds,
            'offset' => $offset,
            'limit'  => $limit,
        );

        return $result;
    }

    /**
     * Builds the cpds list table
     *
     * @param cpds (reference)
     */
    public static function build_cpds_list_html(&$cpds) {
        $smarty = smarty_core();
        $smarty->assign_by_ref('cpds', $cpds);
        $cpds['tablerows'] = $smarty->fetch('artefact:cpds:cpdslist.tpl');
        $pagination = build_pagination(array(
            'id' => 'cpdlist_pagination',
            'class' => 'center',
            'url' => get_config('wwwroot') . 'artefact/cpds/index.php',
            'jsonscript' => 'artefact/cpds/cpds.json.php',
            'datatable' => 'cpdslist',
            'count' => $cpds['count'],
            'limit' => $cpds['limit'],
            'offset' => $cpds['offset'],
            'firsttext' => '',
            'previoustext' => '',
            'nexttext' => '',
            'lasttext' => '',
            'numbersincludefirstlast' => false,
            'resultcounttextsingular' => get_string('cpd', 'artefact.cpds'),
            'resultcounttextplural' => get_string('cpds', 'artefact.cpds'),
        ));
        $cpds['pagination'] = $pagination['html'];
        $cpds['pagination_js'] = $pagination['javascript'];
    }

    public static function validate(Pieform $form, $values) {
        global $USER;
        if (!empty($values['cpd'])) {
            $id = (int) $values['cpd'];
            $artefact = new ArtefactTypecpd($id);
            if (!$USER->can_edit_artefact($artefact)) {
                $form->set_error('submit', get_string('canteditdontown'));
            }
        }
    }

    public static function submit(Pieform $form, $values) {
        global $USER, $SESSION;

        $new = false;

        if (!empty($values['cpd'])) {
            $id = (int) $values['cpd'];
            $artefact = new ArtefactTypecpd($id);
        }
        else {
            $artefact = new ArtefactTypecpd();
            $artefact->set('owner', $USER->get('id'));
            $new = true;
        }

        $artefact->set('title', $values['title']);
        $artefact->set('description', $values['description']);
        $artefact->commit();

        $SESSION->add_ok_msg(get_string('cpdsavedsuccessfully', 'artefact.cpds'));

        if ($new) {
            redirect('/artefact/cpds/cpd.php?id='.$artefact->get('id'));
        }
        else {
            redirect('/artefact/cpds/');
        }
    }

    /**
    * Gets the new/edit cpds pieform
    *
    */
    public static function get_form($cpd=null) {
        require_once(get_config('libroot') . 'pieforms/pieform.php');
        $elements = call_static_method(generate_artefact_class_name('cpd'), 'get_cpdform_elements', $cpd);
        $elements['submit'] = array(
            'type' => 'submitcancel',
            'value' => array(get_string('savecpd','artefact.cpds'), get_string('cancel')),
            'goto' => get_config('wwwroot') . 'artefact/cpds/',
        );
        $cpdform = array(
            'name' => empty($cpd) ? 'addcpd' : 'editcpd',
            'plugintype' => 'artefact',
            'pluginname' => 'activity',
            'validatecallback' => array(generate_artefact_class_name('cpd'),'validate'),
            'successcallback' => array(generate_artefact_class_name('cpd'),'submit'),
            'elements' => $elements,
        );

        return pieform($cpdform);
    }

    /**
    * Gets the new/edit fields for the cpd pieform
    *
    */
    public static function get_cpdform_elements($cpd) {
        $elements = array(
            'title' => array(
                'type' => 'text',
                'defaultvalue' => null,
                'title' => get_string('title', 'artefact.cpds'),
                'size' => 30,
                'rules' => array(
                    'required' => true,
                ),
            ),
            'description' => array(
                'type'  => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'defaultvalue' => null,
                'title' => get_string('description', 'artefact.cpds'),
            ),
        );

        if (!empty($cpd)) {
            foreach ($elements as $k => $element) {
                $elements[$k]['defaultvalue'] = $cpd->get($k);
            }
            $elements['cpd'] = array(
                'type' => 'hidden',
                'value' => $cpd->id,
            );
        }

        return $elements;
    }

    public function render_self($options) {
        $this->add_to_render_path($options);

        $limit = !isset($options['limit']) ? 20 : (int) $options['limit'];
        $offset = isset($options['offset']) ? intval($options['offset']) : 0;

        $activities = ArtefactTypeActivity::get_activities($this->id, $offset, $limit);

        $template = 'artefact:cpds:activityrows.tpl';

        $baseurl = get_config('wwwroot') . 'view/artefact.php?artefact=' . $this->id;
        if (!empty($options['viewid'])) {
            $baseurl .= '&view=' . $options['viewid'];
        }

        $pagination = array(
            'baseurl' => $baseurl,
            'id' => 'activity_pagination',
            'datatable' => 'activitylist',
            'jsonscript' => 'artefact/cpds/viewactivities.json.php',
        );

        ArtefactTypeActivity::render_activities($activities, $template, $options, $pagination);

        $smarty = smarty_core();
        $smarty->assign_by_ref('activities', $activities);
        if (isset($options['viewid'])) {
            $smarty->assign('artefacttitle', '<a href="' . $baseurl . '">' . hsc($this->get('title')) . '</a>');
        }
        else {
            $smarty->assign('artefacttitle', hsc($this->get('title')));
        }
        $smarty->assign('cpd', $this);

        return array('html' => $smarty->fetch('artefact:cpds:viewcpd.tpl'), 'javascript' => '');
    }
}

class ArtefactTypeActivity extends ArtefactType {

    protected $hours;
    protected $location;
    protected $startdate;
    protected $enddate;

    /**
     * We override the constructor to fetch the extra data.
     *
     * @param integer
     * @param object
     */
    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);

        if ($this->id) {
            if ($pdata = get_record('artefact_cpds_activity', 'artefact', $this->id, null, null, null, null, '*, ' . db_format_tsfield('startdate') . ', ' . db_format_tsfield('enddate'))) {
                foreach($pdata as $name => $value) {
                    if (property_exists($this, $name)) {
                        $this->$name = $value;
                    }
                }
            }
            else {
                // This should never happen unless the user is playing around with activity IDs in the location bar or similar
                throw new ArtefactNotFoundException(get_string('activitydoesnotexist', 'artefact.cpds'));
            }
        }
    }

    public static function get_links($id) {
        return array();
    }

    public static function get_icon($options=null) {
    }

    public static function is_singular() {
        return false;
    }

    /**
     * This method extends ArtefactType::commit() by adding additional data
     * into the artefact_cpds_activity table.
     *
     */
    public function commit() {
        if (empty($this->dirty)) {
            return;
        }

        // Return whether or not the commit worked
        $success = false;

        db_begin();
        $new = empty($this->id);

        parent::commit();

        $this->dirty = true;

        $startdate = $this->get('startdate');
        if (!empty($startdate)) {
            $date = db_format_timestamp($startdate);
        }
            $data = (object)array(
            'artefact'  => $this->get('id'),
            'hours' => $this->get('hours'),
            'location' => $this->get('location'),
            'startdate' => $date,
            'enddate' => db_format_timestamp($this->get('enddate')),
        );

        if ($new) {
            $success = insert_record('artefact_cpds_activity', $data);
        }
        else {
            $success = update_record('artefact_cpds_activity', $data, 'artefact');
        }

        db_commit();

        $this->dirty = $success ? false : true;

        return $success;
    }

    /**
     * This function extends ArtefactType::delete() by also deleting anything
     * that's in activity.
     */
    public function delete() {
        if (empty($this->id)) {
            return;
        }

        db_begin();
        delete_records('artefact_cpds_activity', 'artefact', $this->id);

        parent::delete();
        db_commit();
    }

    public static function bulk_delete($artefactids) {
        if (empty($artefactids)) {
            return;
        }

        $idstr = join(',', array_map('intval', $artefactids));

        db_begin();
        delete_records_select('artefact_cpds_activity', 'artefact IN (' . $idstr . ')');
        parent::bulk_delete($artefactids);
        db_commit();
    }


    /**
    * Gets the new/edit activities pieform
    *
    */
    public static function get_form($parent, $activity=null) {
        require_once(get_config('libroot') . 'pieforms/pieform.php');
        $elements = call_static_method(generate_artefact_class_name('activity'), 'get_activityform_elements', $parent, $activity);
        $elements['submit'] = array(
            'type' => 'submitcancel',
            'value' => array(get_string('saveactivity','artefact.cpds'), get_string('cancel')),
            'goto' => get_config('wwwroot') . 'artefact/cpds/cpd.php?id=' . $parent,
        );
        $activityform = array(
            'name' => empty($activity) ? 'addactivities' : 'editactivity',
            'plugintype' => 'artefact',
            'pluginname' => 'activity',
            'validatecallback' => array(generate_artefact_class_name('activity'),'validate'),
            'successcallback' => array(generate_artefact_class_name('activity'),'submit'),
            'elements' => $elements,
        );

        return pieform($activityform);
    }

    /**
    * Gets the new/edit fields for the activities pieform
    *
    */
    public static function get_activityform_elements($parent, $activity=null) {
        $elements = array(
            'title' => array(
                'type' => 'text',
                'defaultvalue' => null,
                'title' => get_string('activity', 'artefact.cpds'),
                'description' => get_string('titledesc','artefact.cpds'),
                'size' => 30,
                'rules' => array(
                    'required' => true,
                ),
            ),
            'location' => array(
                'type'  => 'text',
                'size' => 30,
                'defaultvalue' => null,
                'title' => get_string('location', 'artefact.cpds'),
                'description' => get_string('locationdesc','artefact.cpds'),
                'rules' => array(
                    'required' => true,
                ),
            ),
            'startdate' => array(
                'type'       => 'calendar',
                'caloptions' => array(
                    'showsTime'      => false,
                    'ifFormat'       => '%Y/%m/%d'
                    ),
                'defaultvalue' => null,
                'title' => get_string('startdate', 'artefact.cpds'),
                'description' => get_string('dateformatguide'),
                'rules' => array(
                    'required' => true,
                ),
            ),
            'enddate' => array(
                'type'       => 'calendar',
                'caloptions' => array(
                    'showsTime'      => false,
                    'ifFormat'       => '%Y/%m/%d'
                    ),
                'defaultvalue' => null,
                'title' => get_string('enddate', 'artefact.cpds'),
                'description' => get_string('dateformatguide'),
                'rules' => array(
                    'required' => false,
                ),
            ),

            'description' => array(
                'type'  => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'defaultvalue' => null,
                'title' => get_string('description', 'artefact.cpds'),
            ),
            'hours' => array(
                'type' => 'text',
                'size' => '7',
                'defaultvalue' => '0.0',
                'title' => get_string('hours', 'artefact.cpds'),
                'description' => get_string('hoursdesc', 'artefact.cpds'),
            ),
        );

        if (!empty($activity)) {
            foreach ($elements as $k => $element) {
                $elements[$k]['defaultvalue'] = $activity->get($k);
            }
            $elements['activity'] = array(
                'type' => 'hidden',
                'value' => $activity->id,
            );
        }

        $elements['parent'] = array(
            'type' => 'hidden',
            'value' => $parent,
        );

        return $elements;
    }

    public static function validate(Pieform $form, $values) {
        global $USER;
        if (!empty($values['activity'])) {
            $id = (int) $values['activity'];
            $artefact = new ArtefactTypeActivity($id);
            if (!$USER->can_edit_artefact($artefact)) {
                $form->set_error('submit', get_string('canteditdontown'));
            }
        }
    }

    public static function submit(Pieform $form, $values) {
        global $USER, $SESSION;

        if (!empty($values['activity'])) {
            $id = (int) $values['activity'];
            $artefact = new ArtefactTypeActivity($id);
        }
        else {
            $artefact = new ArtefactTypeactivity();
            $artefact->set('owner', $USER->get('id'));
            $artefact->set('parent', $values['parent']);
        }

        $artefact->set('title', $values['title']);
        $artefact->set('location', $values['location']);
        $artefact->set('description', $values['description']);
        $artefact->set('hours', $values['hours']);
        $artefact->set('startdate', $values['startdate']);
        $artefact->set('enddate', $values['enddate']);
        $artefact->commit();

        $SESSION->add_ok_msg(get_string('cpdsavedsuccessfully', 'artefact.cpds'));

        redirect('/artefact/cpds/cpd.php?id='.$values['parent']);
    }

    /**
     * This function returns a list of the current cpds activities.
     *
     * @param limit how many activities to display per page
     * @param offset current page to display
     * @return array (grandtotalhours: number, count: integer, data: array)
     * 
     */
    public static function get_activities($cpd, $offset=0, $limit=20) {
       
        ($results = get_records_sql_array("
            SELECT a.id, at.artefact AS activity, at.location, at.hours, ".db_format_tsfield('startdate').", ".db_format_tsfield('enddate').",
                a.title, a.description, a.parent
                FROM {artefact} a
            JOIN {artefact_cpds_activity} at ON at.artefact = a.id
            WHERE a.artefacttype = 'activity' AND a.parent = ?
            ORDER BY at.startdate DESC", array($cpd), $offset, $limit))
            || ($results = array());

        // format the date and calculate grand total of hours spent
        $grandtotalhours = 0;
        if (!empty($results)) {
            foreach ($results as $result) {
            	 $grandtotalhours = $grandtotalhours + $result->hours;
                if (!empty($result->startdate)) {
                    $result->startdate = strftime(get_string('strftimedate'), $result->startdate);
                    if (!empty($result->enddate)) {
                        $result->enddate = strftime(get_string('strftimedate'), $result->enddate);
                    }
                }
            }
        }

        $result = array(
            'grandtotalhours' => $grandtotalhours,
            'count'  => count_records('artefact', 'artefacttype', 'activity', 'parent', $cpd),
            'data'   => $results,
            'offset' => $offset,
            'limit'  => $limit,
            'id'     => $cpd,
        );

        return $result;
    }

    /**
     * Builds the activities list table for current cpd
     *
     * @param activities (reference)
     */
    public function build_activities_list_html(&$activities) {
        $smarty = smarty_core();
        $smarty->assign_by_ref('activities', $activities);
        $activities['tablerows'] = $smarty->fetch('artefact:cpds:activitieslist.tpl');
        $pagination = build_pagination(array(
            'id' => 'activitylist_pagination',
            'class' => 'center',
            'url' => get_config('wwwroot') . 'artefact/cpds/cpd.php?id='.$activities['id'],
            'jsonscript' => 'artefact/cpds/activities.json.php',
            'datatable' => 'activitieslist',
            'count' => $activities['count'],
            'limit' => $activities['limit'],
            'offset' => $activities['offset'],
            'firsttext' => '',
            'previoustext' => '',
            'nexttext' => '',
            'lasttext' => '',
            'numbersincludefirstlast' => false,
            'resultcounttextsingular' => get_string('activity', 'artefact.cpds'),
            'resultcounttextplural' => get_string('activities', 'artefact.cpds'),
        ));
        $activities['pagination'] = $pagination['html'];
        $activities['pagination_js'] = $pagination['javascript'];
    }

    // @TODO: make blocktype use this too
    public function render_activities(&$activities, $template, $options, $pagination) {
        $smarty = smarty_core();
        $smarty->assign_by_ref('activities', $activities);
        $smarty->assign_by_ref('options', $options);
        $activities['tablerows'] = $smarty->fetch($template);

        if ($activities['limit'] && $pagination) {
            $pagination = build_pagination(array(
                'id' => $pagination['id'],
                'class' => 'center',
                'datatable' => $pagination['datatable'],
                'url' => $pagination['baseurl'],
                'jsonscript' => $pagination['jsonscript'],
                'count' => $activities['count'],
                'limit' => $activities['limit'],
                'offset' => $activities['offset'],
                'numbersincludefirstlast' => false,
                'resultcounttextsingular' => get_string('activity', 'artefact.cpds'),
                'resultcounttextplural' => get_string('activities', 'artefact.cpds'),
            ));
            $activities['pagination'] = $pagination['html'];
            $activities['pagination_js'] = $pagination['javascript'];
        }
    }
}

?>