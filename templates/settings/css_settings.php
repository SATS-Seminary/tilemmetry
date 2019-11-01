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
 * MySats Tilemmetry
 * @package    theme_tilemmetry
 * @copyright  (c) 2018 South African Theological Seminary (https://sats.edu.za/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


// Customisation Settings Page
    $page = new admin_settingpage('theme_tilemmetry_css', get_string('csssettings', 'theme_tilemmetry'));

    $page->add(new admin_setting_heading(
        'theme_tilemmetry_css',
        get_string('csssettings', 'theme_tilemmetry'),
        format_text('', FORMAT_MARKDOWN)
    ));

 
     // Custom CSS file.
    $name = 'theme_tilemmetry/customcss';
    $title = get_string('customcss', 'theme_tilemmetry');
    $description = get_string('customcssdesc', 'theme_tilemmetry');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // H5P Custom CSS.
    $name = 'theme_tilemmetry/hvpcustomcss';
    $title = get_string('hvpcustomcss', 'theme_tilemmetry');
    $description = get_string('hvpcustomcssdesc', 'theme_tilemmetry');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Must add the page after definiting all the settings!
    $settings->add($page);