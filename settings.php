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

if ($ADMIN->fulltree) {
    global $CFG;
    $settings = new theme_tilemmetry_admin_settingspage_tabs('themesettingtilemmetry', get_string('configtitle', 'theme_tilemmetry'));

    if (file_exists("{$CFG->dirroot}/theme/tilemmetry/settings.php")) {
        //General Settings
        require_once($CFG->dirroot . "/theme/tilemmetry/settings/general_settings.php");
        
        //Dasboard Settings
            $pluginman = core_plugin_manager::instance();
            if (array_key_exists("tilemmetryblck", $pluginman->get_installed_plugins('block'))) {
                if (class_exists('block_tilemmetryblck_settings')) {
                    \block_tilemmetryblck_settings::add_settings($settings);
                } else {
                    // Dashboard settings
                    $page = new admin_settingpage('theme_tilemmetry_dashboard', get_string('dashboardsetting', 'theme_tilemmetry'));
                    $page->add(new admin_setting_description('theme_tilemmetry_olddashboard', '', get_string('olddashboard', 'theme_tilemmetry')));
                    $settings->add($page);
                }
            }
        
        // Homepage settings
        require_once($CFG->dirroot . "/theme/tilemmetry/settings/homepage_settings.php");

        // Footer settings
        require_once($CFG->dirroot . "/theme/tilemmetry/settings/footer_settings.php");

        // Login settings page code begin
        require_once($CFG->dirroot . "/theme/tilemmetry/settings/login_settings.php");

        // Custom CSS file.
        require_once($CFG->dirroot . "/theme/tilemmetry/settings/css_settings.php");
        
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/tilemmetry/settings.php")) {
        //General Settings
        require_once($CFG->themedir . "/tilemmetry/settings/general_settings.php");
        
        //Dasboard Settings
            $pluginman = core_plugin_manager::instance();
            if (array_key_exists("tilemmetryblck", $pluginman->get_installed_plugins('block'))) {
                if (class_exists('block_tilemmetryblck_settings')) {
                    \block_tilemmetryblck_settings::add_settings($settings);
                } else {
                    // Dashboard settings
                    $page = new admin_settingpage('theme_tilemmetry_dashboard', get_string('dashboardsetting', 'theme_tilemmetry'));
                    $page->add(new admin_setting_description('theme_tilemmetry_olddashboard', '', get_string('olddashboard', 'theme_tilemmetry')));
                    $settings->add($page);
                }
            }
        
        // Homepage settings
        require_once($CFG->themedir . "/tilemmetry/settings/homepage_settings.php");

        // Footer settings
        require_once($CFG->themedir . "/tilemmetry/settings/footer_settings.php");

        // Login settings page code begin
        require_once($CFG->themedir . "/tilemmetry/settings/login_settings.php");

        // Custom CSS file.
        require_once($CFG->themedir . "/tilemmetry/settings/css_settings.php");
    }

}
