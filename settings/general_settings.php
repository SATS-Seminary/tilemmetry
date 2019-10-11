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

// General Settings Page
    $page = new admin_settingpage('theme_tilemmetry_general', get_string('generalsettings', 'theme_tilemmetry'));

    $page->add(new admin_setting_heading(
        'theme_tilemmetry_general',
        get_string('generalsettings', 'theme_tilemmetry'),
        format_text('', FORMAT_MARKDOWN)
    ));

    $name = 'theme_tilemmetry/enableannouncement';
    $title = get_string('enableannouncement', 'theme_tilemmetry');
    $description = get_string('enableannouncementdesc', 'theme_tilemmetry');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    if (\theme_tilemmetry\toolbox::get_setting('enableannouncement')) {
        // announcment text
        $name = 'theme_tilemmetry/announcementtext';
        $title = get_string('announcementtext', 'theme_tilemmetry');
        $description = get_string('announcementtextdesc', 'theme_tilemmetry');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // testimonials data for about us section
        $name = 'theme_tilemmetry/announcementtype';
        $title = get_string('announcementtype', 'theme_tilemmetry');
        $description = get_string('announcementtypedesc', 'theme_tilemmetry');
        $setting = new admin_setting_configselect(
            $name,
            $title,
            $description,
            1,
            array(
            'info'    => get_string('typeinfo', 'theme_tilemmetry'),
            'success' => get_string('typesuccess', 'theme_tilemmetry'),
            'warning' => get_string('typewarning', 'theme_tilemmetry'),
            'danger'  => get_string('typedanger', 'theme_tilemmetry')
            )
        );
        $page->add($setting);
    }

    // Setting to activate the Recent Courses Block
    $name = 'theme_tilemmetry/enablerecentcourses';
    $title = get_string('enablerecentcourses', 'theme_tilemmetry');
    $description = get_string('enablerecentcoursesdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Setting to activate the header buttons in overlay minimal view
    $name = 'theme_tilemmetry/enableheaderbuttons';
    $title = get_string('enableheaderbuttons', 'theme_tilemmetry');
    $description = get_string('enableheaderbuttonsdesc', 'theme_tilemmetry');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Course per page to shown
    $name = 'theme_tilemmetry/courseperpage';
    $title = get_string('courseperpage', 'theme_tilemmetry');
    $description = get_string('courseperpagedesc', 'theme_tilemmetry');
    $setting = new admin_setting_configselect(
        $name,
        $title,
        $description,
        1,
        array(
            12 => get_string('twelve', 'theme_tilemmetry'),
            8 => get_string('eight', 'theme_tilemmetry'),
            4 => get_string('four', 'theme_tilemmetry')
        )
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/logoorsitename';
    $title = get_string('logoorsitename', 'theme_tilemmetry');
    $description = get_string('logoorsitenamedesc', 'theme_tilemmetry');
    $default = 'iconsitename';
    $setting = new admin_setting_configselect($name, $title, $description, $default, array(
        'iconsitename' => get_string('iconsitename', 'theme_tilemmetry'),
        'logo' => get_string('onlylogo', 'theme_tilemmetry')
    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/activitynextpreviousbutton';
    $title = get_string('activitynextpreviousbutton', 'theme_tilemmetry');
    $description = get_string('activitynextpreviousbuttondesc', 'theme_tilemmetry');
    $setting = new admin_setting_configselect(
        $name,
        $title,
        $description,
        1,
        array(
            0 => get_string('disablenextprevious', 'theme_tilemmetry'),
            1 => get_string('enablenextprevious', 'theme_tilemmetry'),
            2 => get_string('enablenextpreviouswithname', 'theme_tilemmetry')
        )
    );
    $page->add($setting);

    if (\theme_tilemmetry\toolbox::get_setting('logoorsitename') === "logo") {
        // Logo file setting.
        $name = 'theme_tilemmetry/logo';
        $title = get_string('logo', 'theme_tilemmetry');
        $description = get_string('logodesc', 'theme_tilemmetry');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // LogoMini file setting.
        $name = 'theme_tilemmetry/logomini';
        $title = get_string('logomini', 'theme_tilemmetry');
        $description = get_string('logominidesc', 'theme_tilemmetry');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'logomini');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
    } elseif (\theme_tilemmetry\toolbox::get_setting('logoorsitename') === "iconsitename") {
        // Site icon setting.
        $name = 'theme_tilemmetry/siteicon';
        $title = get_string('siteicon', 'theme_tilemmetry');
        $description = get_string('siteicondesc', 'theme_tilemmetry');
        $default = 'graduation-cap';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);
    }

    // custom favicon temp
    $name = 'theme_tilemmetry/faviconurl';
    $title = get_string('favicon', 'theme_tilemmetry');
    $description = get_string('favicondesc', 'theme_tilemmetry');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'faviconurl');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Font Selector.
    $name = 'theme_tilemmetry/fontselect';
    $title = get_string('fontselect', 'theme_tilemmetry');
    $description = get_string('fontselectdesc', 'theme_tilemmetry');
    $default = 1;
    $choices = array(
        1 => get_string('fonttypestandard', 'theme_tilemmetry'),
        2 => get_string('fonttypegoogle', 'theme_tilemmetry'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    if (\theme_tilemmetry\toolbox::get_setting('fontselect') == "2") {
        // Heading font name.
        $name = 'theme_tilemmetry/fontname';
        $title = get_string('fontname', 'theme_tilemmetry');
        $description = get_string('fontnamedesc', 'theme_tilemmetry');
        $default = 'Roboto';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
    }

    // google analytics block
    $name = 'theme_tilemmetry/googleanalytics';
    $title = get_string('googleanalytics', 'theme_tilemmetry');
    $description = get_string('googleanalyticsdesc', 'theme_tilemmetry');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // google analytics block
    $name = 'theme_tilemmetry/enabledictionary';
    $title = get_string('enabledictionary', 'theme_tilemmetry');
    $description = get_string('enabledictionarydesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enablecoursestats';
    $title = get_string('enablecoursestats', 'theme_tilemmetry');
    $description = get_string('enablecoursestatsdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
   
    // Must add the page after defining all the settings!
    $settings->add($page);