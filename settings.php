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

defined('MOODLE_INTERNAL') || die();
    global $CFG;

if ($ADMIN->fulltree) {
    $settings = new theme_tilemmetry_admin_settingspage_tabs('themesettingtilemmetry', get_string('configtitle', 'theme_tilemmetry'));

    // General settings
    require_once($CFG->dirroot . "/theme/tilemmetry/settings/general_settings.php");

    //Dashboard
    require_once($CFG->dirroot . "/theme/tilemmetry/settings/dashboard_settings.php");

    // Homepage settings
    require_once($CFG->dirroot . "/theme/tilemmetry/settings/homepage_settings.php");

    // Footer settings
    require_once($CFG->dirroot . "/theme/tilemmetry/settings/footer_settings.php");

    // Login settings page code begin
    require_once($CFG->dirroot . "/theme/tilemmetry/settings/login_settings.php");

    // Css Customisation
    require_once($CFG->dirroot . "/theme/tilemmetry/settings/css_settings.php");
}
