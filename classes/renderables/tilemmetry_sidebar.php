<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * SATS Tilemmetry 
 * @package    theme_tilemmetry
 * @copyright  (c) 2018 South African Theological Seminary (https://sats.edu.za/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_tilemmetry\renderables;

use moodle_url;
use renderable;
use renderer_base;
use templatable;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/message/externallib.php');
require_once($CFG->dirroot.'/lib/enrollib.php');

class tilemmetry_sidebar implements renderable, templatable {
 
    /**
     * @var $contacts to store contacts list
     */
    public $contacts;
    public $upevents;
    
    /**
     * tilemmetry_sidebar constructor.
     */
    function __construct() {
        $this->get_contacts();
        $this->get_upevents();
    }

    /**
     * gets the contacts list of current user (online & offline contacts)
     */
   protected function get_contacts() {
       global $USER, $CFG;
       if($CFG->messaging) {
           $cme = new \core_message_external();
           $this->contacts = $cme->get_contacts();
           foreach ($this->contacts as $key => $contact) {
               $this->contacts[$key] = array_values($contact);
           }
       } else {
           $this->contacts = false;
       }
    }

    /**
     * gets the upcoming events
     */
    protected function get_upevents() {
        $this->upevents = \theme_tilemmetry\utility::get_events();
    }
    
     /**
     * @param \renderer_base $output
     * @return object
     */
    public function export_for_template(renderer_base $output) {
        global $USER, $CFG;

        return [
            'contacts' => $this->contacts,
            'messaging_on' => $CFG->messaging,
            'usercanmanage' => \theme_tilemmetry\utility::check_user_admin_cap(),
            'sesskey'       => $USER->sesskey,
            'navbarinverse' => \theme_tilemmetry\toolbox::get_setting('navbarinverse'),
            'sidebarcolor' => \theme_tilemmetry\toolbox::get_setting('sidebarcolor'),
            \theme_tilemmetry\toolbox::get_setting('sitecolor', 'primary') => 'true',
            'upevents' => $this->upevents
        ];
    }
}
