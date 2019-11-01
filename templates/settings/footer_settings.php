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

   // Footer settings
        $page = new admin_settingpage('theme_tilemmetry_footersetting', get_string('footersetting', 'theme_tilemmetry'));

    // Social media settings
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_socialmedia',
            get_string('socialmedia', 'theme_tilemmetry'),
            format_text(get_string('socialmediadesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));

    // Facebook
        $name = 'theme_tilemmetry/facebooksetting';
        $title = get_string('facebooksetting', 'theme_tilemmetry');
        $description = get_string('facebooksettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // Twitter
        $name = 'theme_tilemmetry/twittersetting';
        $title = get_string('twittersetting', 'theme_tilemmetry');
        $description = get_string('twittersettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // Linkedin
        $name = 'theme_tilemmetry/linkedinsetting';
        $title = get_string('linkedinsetting', 'theme_tilemmetry');
        $description = get_string('linkedinsettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // Gplus
        $name = 'theme_tilemmetry/gplussetting';
        $title = get_string('gplussetting', 'theme_tilemmetry');
        $description = get_string('gplussettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // youtube
        $name = 'theme_tilemmetry/youtubesetting';
        $title = get_string('youtubesetting', 'theme_tilemmetry');
        $description = get_string('youtubesettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // Instagram
        $name = 'theme_tilemmetry/instagramsetting';
        $title = get_string('instagramsetting', 'theme_tilemmetry');
        $description = get_string('instagramsettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // Pinterest
        $name = 'theme_tilemmetry/pinterestsetting';
        $title = get_string('pinterestsetting', 'theme_tilemmetry');
        $description = get_string('pinterestsettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // quora
        $name = 'theme_tilemmetry/quorasetting';
        $title = get_string('quorasetting', 'theme_tilemmetry');
        $description = get_string('quorasettingdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

    // Footer Settings

    // Footer Column 1
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_footercolumn1',
            get_string('footercolumn1heading', 'theme_tilemmetry'),
            format_text(get_string('footercolumn1headingdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));

        $name = 'theme_tilemmetry/footercolumn1title';
        $title = get_string('footercolumn1title', 'theme_tilemmetry');
        $description = get_string('footercolumn1titledesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, null);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/footercolumn1customhtml';
        $title = get_string('footercolumn1customhtml', 'theme_tilemmetry');
        $description = get_string('footercolumn1customhtmldesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);


    // Footer Column 2
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_footercolumn2',
            get_string('footercolumn2heading', 'theme_tilemmetry'),
            format_text(get_string('footercolumn2headingdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));

        $name = 'theme_tilemmetry/footercolumn2title';
        $title = get_string('footercolumn2title', 'theme_tilemmetry');
        $description = get_string('footercolumn2titledesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, null);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/footercolumn2customhtml';
        $title = get_string('footercolumn2customhtml', 'theme_tilemmetry');
        $description = get_string('footercolumn2customhtmldesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    // Footer Column 3
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_footercolumn3',
            get_string('footercolumn3heading', 'theme_tilemmetry'),
            format_text(get_string('footercolumn3headingdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));

        $name = 'theme_tilemmetry/footercolumn3title';
        $title = get_string('footercolumn3title', 'theme_tilemmetry');
        $description = get_string('footercolumn3titledesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, null);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/footercolumn3customhtml';
        $title = get_string('footercolumn3customhtml', 'theme_tilemmetry');
        $description = get_string('footercolumn3customhtmldesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);


    // Footer Bottom-Right Section
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_footerbottom',
            get_string('footerbottomheading', 'theme_tilemmetry'),
            format_text(get_string('footerbottomdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));

        $name = 'theme_tilemmetry/footerbottomtext';
        $title = get_string('footerbottomtext', 'theme_tilemmetry');
        $description = get_string('footerbottomtextdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/footerbottomlink';
        $title = get_string('footerbottomlink', 'theme_tilemmetry');
        $description = get_string('footerbottomlinkdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/poweredbymysats';
        $title = get_string('poweredbymysats', 'theme_tilemmetry');
        $description = get_string('poweredbymysatsdesc', 'theme_tilemmetry');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    // Must add the page after definiting all the settings!
        $settings->add($page);