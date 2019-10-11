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
require_once($CFG->libdir . '/behat/lib.php');

user_preference_allow_ajax_update('menubar_state', PARAM_ALPHA);
user_preference_allow_ajax_update('pin_aside', PARAM_ALPHA);
user_preference_allow_ajax_update('course_view_state', PARAM_ALPHA);

user_preference_allow_ajax_update("tilemmetry_layout_top", PARAM_TEXT);
user_preference_allow_ajax_update("tilemmetry_layout_left", PARAM_TEXT);
user_preference_allow_ajax_update("tilemmetry_layout_right", PARAM_TEXT);

global $USER;
$isfolded = 0;
$blockshtml = $OUTPUT->blocks('side-pre', array(), 'aside');
$hasblocks  = strpos($blockshtml, 'data-block=') !== false;
$usercanmanage = \theme_tilemmetry\utility::check_user_admin_cap();
$init_rightsidebar = false; // true only conditionally

// check if sidebar is fold or unfold & aside right state
if (isloggedin()) {
    $menubar_state = get_user_preferences('menubar_state', 'unfold');
    if ($menubar_state == 'fold') {
        $isfolded = 1;
    }
    $pin_aside = get_user_preferences('pin_aside', '');
    
    // always pinned for quiz and book activity
    $activities = array("book", "quiz");
    if (isset($PAGE->cm->id) && in_array($PAGE->cm->modname, $activities) || $PAGE->user_is_editing()) {
        $pin_aside = 'pinaside';
    }
} else {
    $menubar_state = 'fold';
    $isfolded = 1;
    $pin_aside = '';
}

// if no blocks in sidebar, it will always be overlay (no pin option)
if(!$hasblocks) {
    $pin_aside = '';
}

$extraclasses = [];
$extraclasses [] = 'site-menubar-'.$menubar_state.' site-menubar-fold-alt site-menubar-keep '. $pin_aside;

// classes to show right sidebar only if one of the below is true
if ($hasblocks || $usercanmanage) {
    $extraclasses [] = 'page-aside-fixed page-aside-right';
    $init_rightsidebar = true;
}

if ($PAGE->pagelayout == 'mypublic') {
    $extraclasses [] = ' page-profile ';
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'pin_aside' => $pin_aside,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'usercanmanage' => $usercanmanage,
    'init_rightsidebar' => $init_rightsidebar,
    'bodyattributes' => $bodyattributes,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'cansignup' => (!empty($CFG->registerauth) && (!isloggedin() || isguestuser())),
    'signupurl' => new moodle_url('/login/signup.php'),
    'footerdata' => \theme_tilemmetry\utility::get_footer_data(),
    'isfolded'    => $isfolded,
    'sesskey'       => $USER->sesskey,
    'navbarinverse' => \theme_tilemmetry\toolbox::get_setting('navbarinverse'),
    'sidebarcolor' => \theme_tilemmetry\toolbox::get_setting('sidebarcolor'),
    \theme_tilemmetry\toolbox::get_setting('sitecolor', 'primary') => 'true',
];

// for all partials
$templatecontext['navbarinverse'] = \theme_tilemmetry\toolbox::get_setting('navbarinverse');
$templatecontext['sitecolor']  = \theme_tilemmetry\toolbox::get_setting('sitecolor');
$templatecontext['sidebarcolor'] = \theme_tilemmetry\toolbox::get_setting('sidebarcolor');

$templatecontext['is_siteadmin'] = is_siteadmin();
$templatecontext['user_is_editing'] = $this->page->user_is_editing();
$templatecontext['usercanmanage'] = \theme_tilemmetry\utility::check_user_admin_cap();

$templatecontext['flatnavigation'] = flatnav_icon_support($PAGE->flatnav);
$templatecontext['coursecreationlink'] = \theme_tilemmetry\utility::getCreateCourseLink();
if ($hasblocks) {
    $templatecontext['hasblock'] = true;
}

if (isloggedin() && \theme_tilemmetry\toolbox::get_setting('enablerecentcourses')) {
    $courses = \theme_tilemmetry\utility::get_recent_accessed_courses(5);
    $finalarr = array();
    foreach ($courses as $key => $course) {
        $templatecontext['hasrecent'] = true;
        $finalarr[] = array('id'=>$course->courseid, 'fullname'=>format_text($course->fullname));
    }
    $templatecontext['recentcourses'] = $finalarr;
}

$templatecontext['enabledictionary'] = \theme_tilemmetry\toolbox::get_setting('enabledictionary');
if (strpos($bodyattributes, 'editing') !== false) {
    $templatecontext['editingenabled'] = true;
}
