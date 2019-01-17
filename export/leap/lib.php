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

class LeapExportElementCPD extends LeapExportElement {

    public function get_leap_type() {
        return 'cpd';
    }

    public function get_template_path() {
        return 'export:leap/cpds:cpd.tpl';
    }
}

class LeapExportElementActivity extends LeapExportElementCPD {

    public function assign_smarty_vars() {
        parent::assign_smarty_vars();
        $this->smarty->assign('hours', $this->artefact->get('hours'));
        $this->smarty->assign('location', $this->artefact->get('location'));
    }

    public function get_dates() {
        $dates     = array();
        $startdate = $this->artefact->get('startdate');
        $enddate   = $this->artefact->get('enddate');

        if (isset($startdate)) {
            $dates[] = array(
                'point' => 'start',
                'date'  => format_date($this->artefact->get('startdate'), 'strftimew3cdate'),
            );
        }

        if (isset($enddate)) {
            $dates[] = array(
                'point' => 'end',
                'date'  => format_date($this->artefact->get('enddate'), 'strftimew3cdate'),
            );
        }

        return $dates;
    }
}
