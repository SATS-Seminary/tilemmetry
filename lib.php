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
 * SATS Tilemmetry Functions
 * @package    theme_tilemmetry
 * @copyright  (c) 2018 South African Theological Seminary (https://sats.edu.za/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();


if (isset($_POST['applysitewidecolor'])) {
    tilemmetry_clear_cache();
}


/**
 * CSS Processor
 *
 * @param string $css
 * @param theme_config $theme
 * @return string
 */
function theme_tilemmetry_process_css($css, $theme)
{
    global $PAGE, $OUTPUT;
    $outputus = $PAGE->get_renderer('theme_tilemmetry', 'core');
    \theme_tilemmetry\toolbox::set_core_renderer($outputus);

    // set login background
    $tag = '[[setting:login_bg]]';
    $loginbg = \theme_tilemmetry\toolbox::setting_file_url('loginsettingpic', 'loginsettingpic');
    if (empty($loginbg)) {
        $loginbg = \theme_tilemmetry\toolbox::image_url('login_bg', 'theme');
    }
    $css = str_replace($tag, $loginbg, $css);

    // Set the signup panel text color
    $signuptextcolor = \theme_tilemmetry\toolbox::get_setting('signuptextcolor');
    $css = \theme_tilemmetry\toolbox::set_color($css, $signuptextcolor, "'[[setting:signuptextcolor]]'", '#fff');

    // Get the theme font from setting and apply it in CSS
    if (\theme_tilemmetry\toolbox::get_setting('fontselect') === "2") {
        $fontname = ucwords(\theme_tilemmetry\toolbox::get_setting('fontname'));
    }
    if (empty($fontname)) {
        $fontname = 'Open Sans';
    }

    $css = \theme_tilemmetry\toolbox::set_font($css, $fontname);

    // Set custom CSS.
    $customcss = \theme_tilemmetry\toolbox::get_setting('customcss');
    $css = \theme_tilemmetry\toolbox::set_customcss($css, $customcss);

    // custom color sitewide
    $colorhex = \theme_tilemmetry\toolbox::get_setting('sitecolorhex');
    if (empty($colorhex)) {
        $colorhex = '#62a8ea';
    } else {
        $colorhex = '#'.$colorhex;
    }

    $colorobj = new \theme_tilemmetry\Color($colorhex);
    if ($colorhex !== '#62a8ea') {
        $css = str_replace('#62a8ea', $colorhex, $css);
        $css = str_replace('#89bceb', '#'.$colorobj->darken(3), $css);
        $css = str_replace('#4397e6', '#'.$colorobj->darken(5), $css);
        $css = str_replace('#e8f1f8', '#'.$colorobj->lighten(32), $css);
        $css = str_replace('rgba(53, 131, 202, .07)', '#'.$colorobj->lighten(32), $css);
        $css = str_replace('rgba(53, 131, 202, .04)', '#'.$colorobj->lighten(34), $css);
    }

    return $css;
}


/**
 * Serves the H5P Custom CSS.
 *
 * @param type $filename The filename.
 */

function theme_tilemmetry_serve_hvp_css($filename) {
    global $CFG;
    require_once($CFG->dirroot.'/lib/configonlylib.php'); // For min_enable_zlib_compression().

    $content = \theme_tilemmetry\toolbox::get_setting('hvpcustomcss');
    $md5content = md5($content);
    $md5stored = get_config('theme_tilemmetry', 'hvpccssmd5');
    if ((empty($md5stored)) || ($md5stored != $md5content)) {
        // Content changed, so the last modified time needs to change.
        set_config('hvpccssmd5', $md5content, 'theme_tilemmetry');
        $lastmodified = time();
        set_config('hvpccsslm', $lastmodified, 'theme_tilemmetry');
    } else {
        $lastmodified = get_config('theme_tilemmetry', 'hvpccsslm');
        if (empty($lastmodified)) {
            $lastmodified = time();
        }
    }

    // Sixty days only - the revision may get incremented quite often.
    $lifetime = 60 * 60 * 24 * 60;

    header('HTTP/1.1 200 OK');

    header('Etag: "'.$md5content.'"');
    header('Content-Disposition: inline; filename="'.$filename.'"');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastmodified).' GMT');
    header('Expires: '.gmdate('D, d M Y H:i:s', time() + $lifetime).' GMT');
    header('Pragma: ');
    header('Cache-Control: public, max-age='.$lifetime);
    header('Accept-Ranges: none');
    header('Content-Type: text/css; charset=utf-8');
    if (!min_enable_zlib_compression()) {
        header('Content-Length: '.strlen($content));
    }

    echo $content;

    die;
}


// clear theme cache on click 'apply sitewide color'
function tilemmetry_clear_cache()
{
    theme_reset_all_caches();
}

function flatnav_icon_support($flatnav)
{
    global $CFG, $USER, $PAGE;
    // Getting strings for privatefiles & competencies, because their keys are numeric in $PAGE-flatnav
    $pf   = get_string('privatefiles');
    $cmpt = get_string('competencies', 'core_competency');
    $flatnav_new = array();
    $home_count  = 0;
    $coursecount = 0;
    foreach ($flatnav as $key => $value) {
        $key = $coursecount++;
        $flatnav_new[$key] = $value;
        switch ($value->key) {
            case 'myhome':
                $flatnav_new[$key]->tilemmetryicon = 'fa-dashboard';
                break;
            case 'home':
                $flatnav_new[$key]->tilemmetryicon = 'fa-university';
                if ($home_count == 1) {
                    $flatnav_new[$key]->tilemmetryicon = 'fa-dashboard';
                }
                $home_count++;
                break;
            case 'calendar':
                $flatnav_new[$key]->tilemmetryicon = 'fa-calendar';
                break;
            case 'mycourses':
                $mycoursekey = $key;    // Store a key value to check if mycourses available
                $flatnav_new[$key]->tilemmetryicon = 'fa-graduation-cap';
                $flatnav_new[$key]->action    = $CFG->wwwroot . "/course/index.php?mycourses=1";
                if ($PAGE->pagelayout == 'coursecategory' && optional_param('mycourses', null, PARAM_TEXT)) {
                    $flatnav_new[$key]->isactive = true;
                }
                break;
            case 'sitesettings':
                $flatnav_new[$key]->tilemmetryicon = 'fa-cog';
                if ($PAGE->pagelayout == 'admin') {
                    $flatnav_new[$key]->isactive = true;
                }
                break;
            case 'addblock':
                $flatnav_new[$key]->tilemmetryicon = 'fa-plus-circle ';
                break;
            case 'badgesview':
                $flatnav_new[$key]->tilemmetryicon = 'fa-trophy';
                break;
            case 'participants':
                $flatnav_new[$key]->tilemmetryicon = 'fa-users';
                break;
            case 'grades':
                $flatnav_new[$key]->tilemmetryicon = 'fa-table';
                break;
            case 'coursehome':
                $flatnav_new[$key]->tilemmetryicon = 'fa-home';
                break;
            default:
                // Check Whether the link has course id number
                if (is_numeric($value->key)) {
                    // Check for course type i.e. is it 20?
                    if ($flatnav_new[$key]->type == 20) {
                        $mycourses[] = $value;
                        unset($flatnav_new[$key]);
                        $coursecount--;
                        break;
                    }
                }
                $flatnav_new[$key]->tilemmetryicon = 'fa-folder';
                if (!strpos($flatnav_new[$key]->action, 'section')) {
                    $flatnav_new[$key]->hidable = true;
                }
                
                break;
        }
        switch ($value->text) {
            case $pf:
                $flatnav_new[$key]->tilemmetryicon = 'fa-paste';
                break;
            case $cmpt:
                $flatnav_new[$key]->tilemmetryicon = 'fa-check-circle';
                break;
        }
    }
    if (!empty($mycourses)) {
        $flatnav_new[$mycoursekey]->ismycourses = true;
        $flatnav_new[$mycoursekey]->mycourses   = $mycourses;
        if (count($mycourses) == 10) {
            $flatnav_new[$mycoursekey]->hasmore = true;
        }
    }
    return $flatnav_new;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_tilemmetry_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    static $theme;
    $course = $course;
    $cm = $cm;
    if (empty($theme)) {
        $theme = theme_config::load('tilemmetry');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if ($filearea === 'frontpageaboutusimage') {
            return $theme->setting_file_serve('frontpageaboutusimage', $args, $forcedownload, $options);
        } elseif ($filearea === 'loginsettingpic') {
            return $theme->setting_file_serve('loginsettingpic', $args, $forcedownload, $options);
        } elseif ($filearea === 'logo') {
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } elseif ($filearea === 'logomini') {
            return $theme->setting_file_serve('logomini', $args, $forcedownload, $options);
        } elseif (preg_match("/^(slideimage|testimonialimage|frontpageblockimage)[1-5]/", $filearea)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } elseif ($filearea === 'faviconurl') {
            return $theme->setting_file_serve('faviconurl', $args, $forcedownload, $options);
        } elseif ($filearea === 'staticimage') {
            return $theme->setting_file_serve('staticimage', $args, $forcedownload, $options);
        } elseif ($filearea === 'layoutimage') {
            return $theme->setting_file_serve('layoutimage', $args, $forcedownload, $options);
        } else if ($filearea === 'hvp') {
            theme_tilemmetry_serve_hvp_css($args[1]);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}
