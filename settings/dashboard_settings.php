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

    // Dashboard Settings Page
    $page = new admin_settingpage('theme_tilemmetry_dashboard', get_string('dashboardsetting', 'theme_tilemmetry'));

    $page->add(new admin_setting_heading(
        'theme_tilemmetry_upsection',
        get_string('dashboardsetting', 'theme_tilemmetry'),
        format_text(get_string('dashboardsettingdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
    ));

    // Course Progress Block Setting
    $name = 'theme_tilemmetry/enablecourseprogressblock';
    $title = get_string('courseprogressblock', 'theme_tilemmetry');
    $description = get_string('courseprogressblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enableenrolledusersblock';
    $title = get_string('enrolledusersblock', 'theme_tilemmetry');
    $description = get_string('enrolledusersblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enablequizattemptsblock';
    $title = get_string('quizattemptsblock', 'theme_tilemmetry');
    $description = get_string('quizattemptsblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enablecourseanlyticsblock';
    $title = get_string('courseanlyticsblock', 'theme_tilemmetry');
    $description = get_string('courseanlyticsblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enablelatestmembersblock';
    $title = get_string('latestmembersblock', 'theme_tilemmetry');
    $description = get_string('latestmembersblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enableaddnotesblock';
    $title = get_string('addnotesblock', 'theme_tilemmetry');
    $description = get_string('addnotesblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enablerecentfeedbackblock';
    $title = get_string('recentfeedbackblock', 'theme_tilemmetry');
    $description = get_string('recentfeedbackblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_tilemmetry/enablerecentforumsblock';
    $title = get_string('recentforumsblock', 'theme_tilemmetry');
    $description = get_string('recentforumsblockdesc', 'theme_tilemmetry');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Must add the page after definiting all the settings!
    $settings->add($page);


