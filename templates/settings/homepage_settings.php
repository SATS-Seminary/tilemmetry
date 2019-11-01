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


   // Homepage settings
    $page = new admin_settingpage('theme_tilemmetry_frontpage', get_string('homepagesettings', 'theme_tilemmetry'));

    $pluginman = core_plugin_manager::instance();
    if (array_key_exists("tilemmetryhomepage", $pluginman->get_installed_plugins('local')) && class_exists('local_tilemmetryhomepage_plugin')) {
        $homepage = new local_tilemmetryhomepage_plugin();
    } else {
        $homepage = false;
    }
    $activehomepage = get_config('theme_tilemmetry', 'frontpagechooser');
    if ($homepage) {
        $options = array(
            0 => get_string('frontpagedesignold', 'theme_tilemmetry'),
            1 => get_string('pluginname', $homepage->get_component())
        );
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_frontpagedesign',
            get_string('frontpagedesign', 'theme_tilemmetry'),
            format_text(get_string('frontpagedesigndesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));
        $name = 'theme_tilemmetry/frontpagechooser';
        $title = get_string('frontpagechooser', 'theme_tilemmetry');
        $description = get_string('frontpagechooserdesc', 'theme_tilemmetry');
        $setting = new admin_setting_configselect(
            $name,
            $title,
            $description,
            0,
            $options
        );
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
    } else {
        if ($activehomepage == 1) {
            set_config('frontpagechooser', 0, 'theme_tilemmetry');
        }
    }
    if ($homepage && $activehomepage == 1) {
        $homepage->admin_settings($page);
    } else {
        if (class_exists('admin_setting_heading')) {
            $page->add(new admin_setting_heading(
                'theme_tilemmetry_upsection',
                get_string('frontpageimagecontent', 'theme_tilemmetry'),
                format_text(get_string('frontpageimagecontentdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
            ));
        }
        $name = 'theme_tilemmetry/frontpageimagecontent';
        $title = get_string('frontpageimagecontentstyle', 'theme_tilemmetry');
        $description = get_string('frontpageimagecontentstyledesc', 'theme_tilemmetry');
        $setting = new admin_setting_configselect(
            $name,
            $title,
            $description,
            1,
            array(
                0 => get_string('staticcontent', 'theme_tilemmetry'),
                1 => get_string('slidercontent', 'theme_tilemmetry'),
            )
        );
        $page->add($setting);

        if (!\theme_tilemmetry\toolbox::get_setting('frontpageimagecontent')) {
            $name = 'theme_tilemmetry/contenttype';
            $title = get_string('contenttype', 'theme_tilemmetry');
            $description = get_string('contentdesc', 'theme_tilemmetry');
            $setting = new admin_setting_configselect(
                $name,
                $title,
                $description,
                0,
                array(
                0 => get_string('videourl', 'theme_tilemmetry'),
                1 => get_string('image', 'theme_tilemmetry'),
                )
            );
            $page->add($setting);
            if (!\theme_tilemmetry\toolbox::get_setting('contenttype')) {
                $name = 'theme_tilemmetry/video';
                $title = get_string('video', 'theme_tilemmetry');
                $description = get_string('videodesc', 'theme_tilemmetry');
                $default = 'https://www.youtube.com/embed/wop3FMhoLGs';
                $setting = new admin_setting_configtext($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);
            } else if (\theme_tilemmetry\toolbox::get_setting('contenttype')) {
                $name = 'theme_tilemmetry/addtext';
                $title = get_string('addtext', 'theme_tilemmetry');
                $description = get_string('addtextdesc', 'theme_tilemmetry');
                $default = get_string('defaultaddtext', 'theme_tilemmetry');
                $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);


                $name = 'theme_tilemmetry/staticimage';
                $title = get_string('uploadimage', 'theme_tilemmetry');
                $description = get_string('uploadimagedesc', 'theme_tilemmetry');
                $setting = new admin_setting_configstoredfile($name, $title, $description, 'staticimage', 0, array(
                    'subdirs' => 0, 'accepted_types' => 'web_image'
                ));
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);
            }
        } else if (\theme_tilemmetry\toolbox::get_setting('frontpageimagecontent')) {
            $name = 'theme_tilemmetry/slideinterval';
            $title = get_string('slideinterval', 'theme_tilemmetry');
            $description = get_string('slideintervaldesc', 'theme_tilemmetry');
            $default = 5000;
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'theme_tilemmetry/sliderautoplay';
            $title = get_string('sliderautoplay', 'theme_tilemmetry');
            $description = get_string('sliderautoplaydesc', 'theme_tilemmetry');
            $setting = new admin_setting_configselect(
                $name,
                $title,
                $description,
                1,
                array(
                    1 => get_string('true', 'theme_tilemmetry'),
                    2 => get_string('false', 'theme_tilemmetry'),
                )
            );
            $page->add($setting);

            $name = 'theme_tilemmetry/slidercount';
            $title = get_string('slidercount', 'theme_tilemmetry');
            $description = get_string('slidercountdesc', 'theme_tilemmetry');
            $setting = new admin_setting_configselect(
                $name,
                $title,
                $description,
                1,
                array(
                    1 => get_string('one', 'theme_tilemmetry'),
                    2 => get_string('two', 'theme_tilemmetry'),
                    3 => get_string('three', 'theme_tilemmetry'),
                    4 => get_string('four', 'theme_tilemmetry'),
                    5 => get_string('five', 'theme_tilemmetry'),
                )
            );
            $page->add($setting);

            for ($slidecounts = 1; $slidecounts <= \theme_tilemmetry\toolbox::get_setting('slidercount'); $slidecounts = $slidecounts + 1) {
                $name = 'theme_tilemmetry/slideimage'.$slidecounts;
                $title = get_string('slideimage', 'theme_tilemmetry');

                $description = get_string('slideimagedesc', 'theme_tilemmetry');
                $setting = new admin_setting_configstoredfile($name, $title, $description, 'slideimage'.$slidecounts, 0, array(
                    'subdirs' => 0, 'accepted_types' => 'web_image'
                ));
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);

                $name = 'theme_tilemmetry/slidertext'.$slidecounts;
                $title = get_string('slidertext', 'theme_tilemmetry');
                $description = get_string('slidertextdesc', 'theme_tilemmetry');
                $default = get_string('defaultslidertext', 'theme_tilemmetry');
                $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);

                $name = 'theme_tilemmetry/sliderbuttontext'.$slidecounts;
                $title = get_string('sliderbuttontext', 'theme_tilemmetry');
                $description = get_string('sliderbuttontextdesc', 'theme_tilemmetry');
                $default = '';
                $setting = new admin_setting_configtext($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);

                $name = 'theme_tilemmetry/sliderurl'.$slidecounts;
                $title = get_string('sliderurl', 'theme_tilemmetry');
                $description = get_string('sliderurldesc', 'theme_tilemmetry');
                $default = '';
                $setting = new admin_setting_configtext($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);
            }
        }
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Marketing blocks
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_blocksection',
            get_string('frontpageblocks', 'theme_tilemmetry'),
            format_text(get_string('frontpageblocksdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));

        // Show the About Us on Home Page Setting
        $name = 'theme_tilemmetry/frontpageblockdisplay';
        $title = get_string('frontpageblockdisplay', 'theme_tilemmetry');
        $description = get_string('frontpageblockdisplaydesc', 'theme_tilemmetry');
        $setting = new admin_setting_configselect(
            $name,
            $title,
            $description,
            1,
            array(
                    1 => get_string('donotshowaboutus', 'theme_tilemmetry'),
                    2 => get_string('showaboutusinrow', 'theme_tilemmetry'),
                    3 => get_string('showaboutusingridblock', 'theme_tilemmetry'),
            )
        );
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // marketing spot section heading
        $name = 'theme_tilemmetry/frontpageblockheading';
        $title = get_string('frontpageaboutus', 'theme_tilemmetry');
        $description = get_string('frontpageaboutustitledesc', 'theme_tilemmetry');
        $default = 'About Us';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // description for above
        $name = 'theme_tilemmetry/frontpageblockdesc';
        $title = get_string('frontpageaboutusbody', 'theme_tilemmetry');
        $description = get_string('frontpageaboutusbodydesc', 'theme_tilemmetry');
        $default = 'Holisticly harness just in time technologies via corporate scenarios.';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/enablesectionbutton';
        $title = get_string('enablesectionbutton', 'theme_tilemmetry');
        $description = get_string('enablesectionbuttondesc', 'theme_tilemmetry');
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        /*block section 1*/
        $name = 'theme_tilemmetry/frontpageblocksection1';
        $title = get_string('frontpageblocksection1', 'theme_tilemmetry');
        $description = get_string('frontpageblocksectiondesc', 'theme_tilemmetry');
        $default = 'LOREM IPSUM';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockdescriptionsection1';
        $title = get_string('frontpageblockdescriptionsection1', 'theme_tilemmetry');
        $description = get_string('frontpageblockdescriptionsectiondesc', 'theme_tilemmetry');
        $default = get_string('defaultdescriptionsection', 'theme_tilemmetry');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockiconsection1';
        $title = get_string('frontpageblockiconsection1', 'theme_tilemmetry');
        $description = get_string('frontpageblockiconsectiondesc', 'theme_tilemmetry');
        $default = 'flag';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        if (\theme_tilemmetry\toolbox::get_setting('enablesectionbutton')) {
            $name = 'theme_tilemmetry/sectionbuttontext1';
            $title = get_string('sectionbuttontext1', 'theme_tilemmetry');
            $description = get_string('sectionbuttontextdesc', 'theme_tilemmetry');
            $default = 'Read More';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'theme_tilemmetry/sectionbuttonlink1';
            $title = get_string('sectionbuttonlink1', 'theme_tilemmetry');
            $description = get_string('sectionbuttonlinkdesc', 'theme_tilemmetry');
            $default = '#';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);
        }
        $name = 'theme_tilemmetry/frontpageblockimage1';
        $title = get_string('frontpageblockimage', 'theme_tilemmetry');
        $description = get_string('frontpageblockimagedesc', 'theme_tilemmetry');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageblockimage1', 0, array(
            'subdirs' => 0, 'accepted_types' => 'web_image'
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        /*block section 2*/
        $name = 'theme_tilemmetry/frontpageblocksection2';
        $title = get_string('frontpageblocksection2', 'theme_tilemmetry');
        $description = get_string('frontpageblocksectiondesc', 'theme_tilemmetry');
        $default = 'LOREM IPSUM';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockdescriptionsection2';
        $title = get_string('frontpageblockdescriptionsection2', 'theme_tilemmetry');
        $description = get_string('frontpageblockdescriptionsectiondesc', 'theme_tilemmetry');
        $default = get_string('defaultdescriptionsection', 'theme_tilemmetry');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockiconsection2';
        $title = get_string('frontpageblockiconsection2', 'theme_tilemmetry');
        $description = get_string('frontpageblockiconsectiondesc', 'theme_tilemmetry');
        $default = 'globe';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        if (\theme_tilemmetry\toolbox::get_setting('enablesectionbutton')) {
            $name = 'theme_tilemmetry/sectionbuttontext2';
            $title = get_string('sectionbuttontext2', 'theme_tilemmetry');
            $description = get_string('sectionbuttontextdesc', 'theme_tilemmetry');
            $default = 'Read More';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'theme_tilemmetry/sectionbuttonlink2';
            $title = get_string('sectionbuttonlink2', 'theme_tilemmetry');
            $description = get_string('sectionbuttonlinkdesc', 'theme_tilemmetry');
            $default = '#';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);
        }
        $name = 'theme_tilemmetry/frontpageblockimage2';
        $title = get_string('frontpageblockimage', 'theme_tilemmetry');
        $description = get_string('frontpageblockimagedesc', 'theme_tilemmetry');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageblockimage2', 0, array(
            'subdirs' => 0, 'accepted_types' => 'web_image'
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        /* block section 3 */
        $name = 'theme_tilemmetry/frontpageblocksection3';
        $title = get_string('frontpageblocksection3', 'theme_tilemmetry');
        $description = get_string('frontpageblocksectiondesc', 'theme_tilemmetry');
        $default = 'LOREM IPSUM';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockdescriptionsection3';
        $title = get_string('frontpageblockdescriptionsection3', 'theme_tilemmetry');
        $description = get_string('frontpageblockdescriptionsectiondesc', 'theme_tilemmetry');
        $default = get_string('defaultdescriptionsection', 'theme_tilemmetry');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockiconsection3';
        $title = get_string('frontpageblockiconsection3', 'theme_tilemmetry');
        $description = get_string('frontpageblockiconsectiondesc', 'theme_tilemmetry');
        $default = 'cog';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        if (\theme_tilemmetry\toolbox::get_setting('enablesectionbutton')) {
            $name = 'theme_tilemmetry/sectionbuttontext3';
            $title = get_string('sectionbuttontext3', 'theme_tilemmetry');
            $description = get_string('sectionbuttontextdesc', 'theme_tilemmetry');
            $default = 'Read More';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'theme_tilemmetry/sectionbuttonlink3';
            $title = get_string('sectionbuttonlink3', 'theme_tilemmetry');
            $description = get_string('sectionbuttonlinkdesc', 'theme_tilemmetry');
            $default = '#';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);
        }
        $name = 'theme_tilemmetry/frontpageblockimage3';
        $title = get_string('frontpageblockimage', 'theme_tilemmetry');
        $description = get_string('frontpageblockimagedesc', 'theme_tilemmetry');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageblockimage3', 0, array(
            'subdirs' => 0, 'accepted_types' => 'web_image'
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        /* block section 4 */
        $name = 'theme_tilemmetry/frontpageblocksection4';
        $title = get_string('frontpageblocksection4', 'theme_tilemmetry');
        $description = get_string('frontpageblocksectiondesc', 'theme_tilemmetry');
        $default = 'LOREM IPSUM';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockdescriptionsection4';
        $title = get_string('frontpageblockdescriptionsection4', 'theme_tilemmetry');
        $description = get_string('frontpageblockdescriptionsectiondesc', 'theme_tilemmetry');
        $default = get_string('defaultdescriptionsection', 'theme_tilemmetry');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_tilemmetry/frontpageblockiconsection4';
        $title = get_string('frontpageblockiconsection4', 'theme_tilemmetry');
        $description = get_string('frontpageblockiconsectiondesc', 'theme_tilemmetry');
        $default = 'users';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        if (\theme_tilemmetry\toolbox::get_setting('enablesectionbutton')) {
            $name = 'theme_tilemmetry/sectionbuttontext4';
            $title = get_string('sectionbuttontext4', 'theme_tilemmetry');
            $description = get_string('sectionbuttontextdesc', 'theme_tilemmetry');
            $default = 'Read More';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'theme_tilemmetry/sectionbuttonlink4';
            $title = get_string('sectionbuttonlink4', 'theme_tilemmetry');
            $description = get_string('sectionbuttonlinkdesc', 'theme_tilemmetry');
            $default = '#';
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);
        }
        $name = 'theme_tilemmetry/frontpageblockimage4';
        $title = get_string('frontpageblockimage', 'theme_tilemmetry');
        $description = get_string('frontpageblockimagedesc', 'theme_tilemmetry');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageblockimage4', 0, array(
            'subdirs' => 0, 'accepted_types' => 'web_image'
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Frontpage Aboutus settings
        $page->add(new admin_setting_heading(
            'theme_tilemmetry_frontpage_aboutus',
            get_string('frontpageaboutus', 'theme_tilemmetry'),
            format_text(get_string('frontpageaboutusdesc', 'theme_tilemmetry'), FORMAT_MARKDOWN)
        ));


        $name = 'theme_tilemmetry/enablefrontpageaboutus';
        $title = get_string('enablefrontpageaboutus', 'theme_tilemmetry');
        $description = get_string('enablefrontpageaboutusdesc', 'theme_tilemmetry');
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        if (\theme_tilemmetry\toolbox::get_setting('enablefrontpageaboutus')) {
            // Heading text for about us
                $name = 'theme_tilemmetry/frontpageaboutusheading';
            $title = get_string('frontpageaboutusheading', 'theme_tilemmetry');
            $description = get_string('frontpageaboutusheadingdesc', 'theme_tilemmetry');
            $default = "About us";
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

                // Text for about us
                $name = 'theme_tilemmetry/frontpageaboutustext';
            $title = get_string('frontpageaboutustext', 'theme_tilemmetry');
            $description = get_string('frontpageaboutustextdesc', 'theme_tilemmetry');
            $default = get_string('frontpageaboutusdefault', 'theme_tilemmetry');
            ;
            $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

                // testimonials data for about us section
                $name = 'theme_tilemmetry/testimonialcount';
            $title = get_string('testimonialcount', 'theme_tilemmetry');
            $description = get_string('testimonialcountdesc', 'theme_tilemmetry');
            $setting = new admin_setting_configselect(
                $name,
                $title,
                $description,
                1,
                array(
                    0 => '0',
                    1 => get_string('one', 'theme_tilemmetry'),
                    2 => get_string('two', 'theme_tilemmetry'),
                    3 => get_string('three', 'theme_tilemmetry')
                    )
            );
            $page->add($setting);

            for ($testimonialcount = 1; $testimonialcount <= \theme_tilemmetry\toolbox::get_setting('testimonialcount'); $testimonialcount = $testimonialcount + 1) {
                // image
                    $name = 'theme_tilemmetry/testimonialimage'.$testimonialcount;
                $title = get_string('testimonialimage', 'theme_tilemmetry');
                $description = get_string('testimonialimagedesc', 'theme_tilemmetry');
                $setting = new admin_setting_configstoredfile($name, $title, $description, 'testimonialimage'.$testimonialcount, 0, array(
                    'subdirs' => 0, 'accepted_types' => 'web_image'
                ));
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);

                    // name
                    $name = 'theme_tilemmetry/testimonialname'.$testimonialcount;
                $title = get_string('testimonialname', 'theme_tilemmetry');
                $description = get_string('testimonialnamedesc', 'theme_tilemmetry');
                $default = '';
                $setting = new admin_setting_configtext($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);

                    // post
                    $name = 'theme_tilemmetry/testimonialdesignation'.$testimonialcount;
                $title = get_string('testimonialdesignation', 'theme_tilemmetry');
                $description = get_string('testimonialdesignationdesc', 'theme_tilemmetry');
                $default = '';
                $setting = new admin_setting_configtext($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);

                    // description
                    $name = 'theme_tilemmetry/testimonialtext'.$testimonialcount;
                $title = get_string('testimonialtext', 'theme_tilemmetry');
                $description = get_string('testimonialtextdesc', 'theme_tilemmetry');
                $default = '';
                $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);
            }
        }

        // Must add the page after definiting all the settings!
    }
    $settings->add($page);
