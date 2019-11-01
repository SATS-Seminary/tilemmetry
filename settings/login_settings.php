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
 
  // Login Settings Page
        $page = new admin_settingpage('theme_tilemmetry_login', get_string('loginsettings', 'theme_tilemmetry'));
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_login',
            get_string('loginsettings', 'theme_tilemmetry'),
            format_text('', FORMAT_MARKDOWN)
        ));

        $name = 'theme_tilemmetry/navlogin_popup';
        $title = get_string('navlogin_popup', 'theme_tilemmetry');
        $description = get_string('navlogin_popupdesc', 'theme_tilemmetry');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/loginsettingpic';
        $title = get_string('loginsettingpic', 'theme_tilemmetry');
        $description = get_string('loginsettingpicdesc', 'theme_tilemmetry');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginsettingpic', 0, array(
            'subdirs' => 0, 'accepted_types' => 'web_image'
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/signuptextcolor';
        $title = get_string('signuptextcolor', 'theme_tilemmetry');
        $description = get_string('signuptextcolordesc', 'theme_tilemmetry');
        $default = '#FFFFFF';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Brand Logo Position Setting
        $name = 'theme_tilemmetry/brandlogopos';
        $title = get_string('brandlogopos', 'theme_tilemmetry');
        $description = get_string('brandlogoposdesc', 'theme_tilemmetry');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Text with Brand Logo
        $name = 'theme_tilemmetry/brandlogotext';
        $title = get_string('brandlogotext', 'theme_tilemmetry');
        $description = get_string('brandlogotextdesc', 'theme_tilemmetry');
        $default = ""; // Default string will be blank
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    $settings->add($page);