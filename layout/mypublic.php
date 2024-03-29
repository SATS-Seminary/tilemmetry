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
require_once('common.php');
require_once($CFG->libdir . "/badgeslib.php");

global $USER, $DB;

// Get user's object from page url
$uid = optional_param('id', $USER->id, PARAM_INT);
$userobject = $DB->get_record('user', array('id' => $uid));

$countries = get_string_manager()->get_list_of_countries();// get the list of all country
if (!empty($userobject->country)) { // country field in user object is empty
    $tempArray[] = array("keyName" => $userobject->country, "valName" => $countries[$userobject->country]);
    $tempArray[] = array("keyName" => '', "valName" => 'Select a country...');
} else {
    $tempArray[] = array("keyName" => '', "valName" => 'Select a country...');
}

foreach ($countries as $key => $value) {
    $tempArray[] = array("keyName" => $key, "valName" => $value);
}

$templatecontext['usercanmanage'] = \theme_tilemmetry\utility::check_user_admin_cap($userobject);
$templatecontext['notcurrentuser'] = ($userobject->id != $USER->id)?true:false;
$templatecontext['countries'] = $tempArray;

// prepare profile context

$hasinterests = false;
$hasbadges = false;
$onlypublic = true;
$aboutme = false;
$country = '';

$userauth = get_auth_plugin($userobject->auth);
$lockfields = array('field_lock_firstname', 'field_lock_lastname', 'field_lock_city', 'field_lock_country');
foreach ($userauth->config as $lockfield_key => $lockfield) {
    if ($lockfield == 'locked') {
        if (in_array($lockfield_key, $lockfields)) {
            $userobject->$lockfield_key = 'locked';
        }
    }
}

$templatecontext['user'] = $userobject;
$templatecontext['user']->profilepicture = \theme_tilemmetry\utility::get_user_picture($userobject, 200);
$templatecontext['user']->forumpostcount = \theme_tilemmetry\utility::get_user_forum_post_count($userobject);
$templatecontext['user']->blogpostcount  = \theme_tilemmetry\utility::get_user_blog_post_count($userobject);
$templatecontext['user']->contactscount  = \theme_tilemmetry\utility::get_user_contacts_count($userobject);
$templatecontext['user']->description  = strip_tags($userobject->description);

// about me tab data
$interests = \core_tag_tag::get_item_tags('core', 'user', $userobject->id);
foreach ($interests as $interest) {
    $hasinterests = true;
    $aboutme = true;
    $templatecontext['user']->interests[] = $interest;
}
$templatecontext['user']->hasinterests    = $hasinterests;

// badges
if ($CFG->enablebadges) {
    if ($templatecontext['usercanmanage'] || ($userobject->id == $USER->id)) {
        $onlypublic = false;
    }
    $badges = badges_get_user_badges($userobject->id, 0, null, null, null, $onlypublic);
    if ($badges) {
        $hasbadges = true;
        $count = 0;
        foreach ($badges as $key => $badge) {
            $context = ($badge->type == BADGE_TYPE_SITE) ? context_system::instance() : context_course::instance($badge->courseid);
            $templatecontext['user']->badges[$count]['imageurl'] = moodle_url::make_pluginfile_url($context->id, 'badges', 'badgeimage', $badge->id, '/', 'f1', false);
            $templatecontext['user']->badges[$count]['name'] = $badge->name;
            $templatecontext['user']->badges[$count]['link'] = new moodle_url('/badges/badge.php?hash=' . $badge->uniquehash);
            $templatecontext['user']->badges[$count]['desc'] = $badge->description;
            $count++;
        }
    }
}
$templatecontext['user']->hasbadges = $hasbadges;


if (!empty($userobject->country)) {
    $country = get_string($userobject->country, 'countries');
}
$templatecontext['user']->location  = $userobject->address.$userobject->city.$country;
$templatecontext['user']->instidept = $userobject->department.$userobject->institution;
if (!empty($templatecontext['user']->location) || !empty($templatecontext['user']->instidept)) {
    $aboutme = true;
}
$templatecontext['user']->aboutme = $aboutme;

// courses tab data
$usercourses = array_values(\theme_tilemmetry\utility::get_users_courses_with_progress($userobject));
$templatecontext['user']->hascourses = (count($usercourses))?true:false;
$templatecontext['user']->courses = $usercourses;

echo $OUTPUT->render_from_template('theme_tilemmetry/mypublic', $templatecontext);

$PAGE->requires->strings_for_js(array('enterfirstname', 'enterlastname', 'enteremailid', 'enterproperemailid', 'detailssavedsuccessfully', 'actioncouldnotbeperformed'), 'theme_tilemmetry');
