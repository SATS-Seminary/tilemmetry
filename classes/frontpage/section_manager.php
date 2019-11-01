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

namespace theme_tilemmetry\frontpage;
defined('MOODLE_INTERNAL') || die;
define('SECTIONTABLE', 'theme_tilemmetry_sect_inst');

use context_user;
use theme_tilemmetry\frontpage\sections\main_form as main_form;
use stdClass;
use cache;

class section_manager {

    // Section related Members
    private $name = null;
    private $instanceid = null;
    private $config = null;

    private $option = array();
    // Extra Members
    private $isexist = false;
    private $sectiontable = 'theme_tilemmetry_sect_inst';

    use sections\courses_data;
    use sections\html_data;
    use sections\separator_data;

    /**
     * Set name of section
     * @param string $name Name of section
     */
    public function set_name($name) {
        global $PAGE;
        $PAGE->set_context(\context_system::instance());
        $this->name = $name;
        $this->set_config($name, null);
    }

    /**
     * Set config of section by name or instanceid
     * @param string $name       Name of section
     * @param int    $instanceid Instance id of section
     */
    public function set_config($name = null, $instanceid = null) {
        if ($instanceid != null) {
            $this->isexist = true;
            $this->config = $this->get_config_by_instanceid($instanceid);
        } else {
            $this->config = $this->get_config_by_name($name);
        }
    }

    /**
     * Get section table name
     * @return string Name of section table
     */
    protected function get_sectiontable() {
        return $this->sectiontable;
    }

    /**
     * Set instance id in object instanceid property
     * @param int $id Instance id of section
     */
    public function set_instanceid($id) {
        $this->instanceid = $id;
    }

    /**
     *  Get instance id set in instanceid property
     * @return int Instance id set in the object
     */
    public function get_instanceid() {
        return $this->instanceid;
    }

    /**
     * Mark instance as deleted or cancel deletion
     * @param  bool $action true if wanna delete instance
     * @return bool         true
     */
    public function mark_instance_deleted($action) {
        global $DB;
        $dataobject = new \stdClass;
        $dataobject->id = $this->instanceid;
        $dataobject->deleted = $action;
        return $DB->update_record($this->sectiontable, $dataobject);
    }

    /**
     * Delete all files from configdata and draftconfig then delete instance.
     * @param  object     $section  Section instance object
     * @param  moodleform $mainform Main section form object
     * @return bool                 true if deleted
     */
    protected function delete_section($section, $mainform) {
        global $DB;
        $methodname = "update_{$section->name}_file_area";
        if (method_exists($mainform, $methodname)) {
            if ($section->configdata != null) {
                $mainform->$methodname(json_decode($section->configdata, true));
            }
            if ($section->draftconfig != null) {
                $mainform->$methodname(json_decode($section->draftconfig, true));
            }
        }
        return $DB->delete_records($this->sectiontable, array('id' => $section->id));
    }

    /**
     * Update section instance
     * @param  array $formdata submitted form data
     * @return bool            true
     */
    public function update_section_instance($formdata) {
        global $DB;
        $mainform = new main_form(null, (object)['instanceid' => $this->instanceid, 'formdata' => $formdata, 'dontinitialize' => true]);
        $formdata = $mainform->process_form_submission();

        $formdata = json_encode($formdata);

        $dataobject = new \stdClass;
        $dataobject->id = $this->instanceid;
        $dataobject->draftconfig = $formdata;
        return $DB->update_record($this->sectiontable, $dataobject);

    }

    /**
     * Create section instance from section name set in private section name varible
     * @return array section data
     */
    public function create_instance() {
        global $DB;
        $dataobject = $this->generate_dataobject();
        $instanceid = $DB->insert_record($this->sectiontable, $dataobject, true, false);
        $dataobject->id = $instanceid;
        $mainform = new main_form(null, (object)['dontinitialize' => true, 'instanceid' => $instanceid, 'formdata' => json_decode($dataobject->draftconfig, true)]);
        // Do some operation on config data before saving it
        $mainform->process_section_creation();
        $dataobject->draftconfig = json_encode($mainform->process_form_submission(false));
        $DB->update_record($this->sectiontable, $dataobject);
        return $this->sectiondata($dataobject, true);
    }

    /**
     * Get config set in the object
     * @return object config data
     */
    public function get_config() {
        return $this->config;
    }

    /**
     * Generate data object of config
     * @return object data object
     */
    public function generate_dataobject() {
        $obj = new \stdClass();

        $obj->sectid = $this->config['sectid'];
        $obj->name   = $this->config['name'];
        $obj->visible = 1;
        $obj->deleted = 0;

        // Get current epoch time
        $date = new \DateTime("now", \core_date::get_user_timezone_object());
        $currtime = $date->getTimestamp();

        $obj->timecreated = $currtime;
        $obj->timemodified = $currtime;

        $obj->configdata = null;
        $obj->draftconfig = json_encode($this->config['configdata']);
        return $obj;
    }

    /**
     * Get all ordered instances
     * @return array Instances array
     */
    public function get_all_instances() {
        global $DB;
        $records = $DB->get_records($this->sectiontable);
        if (count($records) == 0) {
            return [];
        }
        return $records;
    }

    /**
     * Get section config by section instance id
     * @param  int    $instanceid Instance id of section
     * @return object             Section record
     */
    public function get_config_by_instanceid($instanceid) {
        global $DB;
        $record = $DB->get_record($this->sectiontable, array('id' => $instanceid));
        return $record;
    }

    /**
     * Get section config by section name. This section config is defined in section_configuration
     * @param  string $name name of section
     * @return array        Section configuration array
     */
    public function get_config_by_name($name) {
        return $this->section_configuration($name);
    }


    /**
     * Convert form data to array. In form we receive array level data using _.
     * For ex: if we need slider name in slider array then it is slider_0_slidername
     * @param  array $formdata Submitted form data
     * @return array           Converted form data
     */
    public function convert_to_array($formdata) {
        $str = ['instanceid', 'sesskey', '_qf__theme_tilemmetry_frontpage_sections_main_form', 'mform_isexpanded_id_moodle'];

        $newarray = array();
        $wrkarray = &$newarray;
        foreach ($formdata as $key => $value) {
            if (in_array($key, $str)) {
                continue;
            }

            $this->setoption($key, $value);
        }
        return $this->option;
    }

    /**
     * Set option in array using key value using pointer
     * @param  pointer &$arrayptr Array pointer
     * @param  mixed  $key       Array key index
     * @param  mixed  $value     Value at index
     */
    public function _setoption(&$arrayptr, $key, $value) {

        $keys = explode('_', $key);
        $lastkey = array_pop($keys);

        foreach ($keys as $arrkey) {
            if (!is_array($arrayptr)) {
                $arrayptr = array();
            }
            if (!array_key_exists($arrkey, $arrayptr)) {
                $arrayptr[$arrkey] = array();
            }
            $arrayptr = &$arrayptr[$arrkey];
        }

        $arrayptr[$lastkey] = $value;
    }

    /**
     * Set value at key location in option array
     * @param  mixed   $key   Array key index
     * @param  mixed   $value Value at index
     * @return boolean        True
     */
    public function setoption($key, $value) {

        if (!isset($this->option)) {
            $this->option = array();
        }
        $this->_setoption($this->option, $key, $value);
        return true;
    }

    /**
     * Attach extra data to section data
     * @param  stdClass $record      Section config data
     * @param  bool     $userediting Return draftdata if user is editing
     * @return array                 section data
     */
    public function sectiondata($record, $userediting = false) {
        $configdata = !$userediting ? $record->configdata : $record->draftconfig;
        if ($configdata == null) {
            return null;
        }
        $configdata = json_decode($configdata, true);
        $configdata['id'] = $record->id;
        $configdata['sectionname'] = $record->name;
        $configdata['deleted'] = $record->deleted == 1;
        $configdata['visible'] = $record->visible == 1;
        $methodname = $record->name.'data';
        if (method_exists($this, $methodname)) {
            $configdata = $this->$methodname($configdata);
        }
        return $configdata;
    }

    /**
     * Save section order in plugin config
     * @param  array  $order sections instance id order
     */
    public function get_sections_order() {
        global $USER, $PAGE;
        $userisediting = false;
        if (isloggedin()) {
            $usercontext = context_user::instance($USER->id);
            $userisediting = has_capability('theme/tilemmetry:editfrontpage', $usercontext) && $PAGE->user_is_editing();
        }
        if ($userisediting) {
            $order = get_config('theme_tilemmetry', 'draft_sections_order');
        } else {
            $order = get_config('theme_tilemmetry', 'sections_order');
        }
        if ($order != '') {
            return $order;
        }
        return '[]';
    }

    /**
     * Save section order in plugin config
     * @param  array  $order sections instance id order
     */
    public function save_sections_order(array $order = []) {
        set_config('draft_sections_order', json_encode($order), 'theme_tilemmetry');
    }

    /**
     * Update user visibility of section based on section id
     * @param  int  $id      Section instance id
     * @param  bool $visible Visibility of section eigther true or false
     * @return bool          Record updation status
     */
    public function update_section_visibility($id, $visible) {
        global $DB;
        $section = new stdClass;
        $section->id = $id;
        $section->visible = $visible;
        return $DB->update_record($this->sectiontable, $section);
    }

    /**
     * Create draft config data of every section for editing
     */
    public function create_draft_configs() {
        global $DB;
        if (!get_config('theme_tilemmetry', 'draft_sections_order')) {
            set_config('draft_sections_order', get_config('theme_tilemmetry', 'sections_order'), 'theme_tilemmetry');
        }
        if ($sections = $this->get_all_instances()) {
            foreach ($sections as $id => $section) {
                $mainform = new main_form(null, (object)['instanceid' => $id, 'section' => $section, 'dontinitialize' => true]);
                $mainform->create_draft_configs($this->sectiontable);
            }
        }
    }

    /**
     * Publish the sections updated by admin
     */
    public function publish_sections() {
        global $DB;
        set_config('sections_order', get_config('theme_tilemmetry', 'draft_sections_order'), 'theme_tilemmetry');
        if ($sections = $this->get_all_instances()) {
            foreach ($sections as $id => $section) {
                $mainform = new main_form(null, (object)['instanceid' => $id, 'section' => $section, 'dontinitialize' => true]);
                if ($section->deleted == true) {
                    $this->delete_section($section, $mainform);
                }
                $mainform->publish_draft_configs($this->sectiontable);
            }
        }
    }

    /**
     * Returns the text property with default text
     * @param  string $text text for text property
     * @return array        text property array
     */
    private function get_textproperty($text = 'LOREM IPSUM', $onlycolor = false, $subtitle=false, $random = false) {

        $arr = array(
            'text' => $text,
            'color' => (isset($subtitle) && $subtitle == true) ? '#908b8b' : '#555555'
        );

        if (!$onlycolor) {
            $arr['bold'] = false;
            $arr['italic'] = false;
            $arr['underline'] = false;
            $arr['fontsize'] = (isset($subtitle) && $subtitle == true) ? '16' : '30';
        }

        $arr['color'] = (isset($random) && $random == false) ? $arr['color'] : $this->rand_color();
        // $arr['color'] = (isset($random) && $random == false) ? $arr['color'] : '#a7aec5';

        return $arr;
    }

    /**
     * Get random color
     * @return string Random hex color
     */
    public function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get default configuration for about us block
     * @param  string $icon        font awesome icon
     * @param  string $description description
     * @return array               block configuration array
     */
    private function get_default_aboutus_block($icon, $description) {
        return [
            'title' => $this->get_textproperty('LOREM IPSUM', true),
            'description' => $this->get_textproperty($description, true, true),
            'icon' => $icon,
            'border' => 1,
            'blockbackground' => 1,
            'bgopacity' => '0',
            'image' => 0,
            'imageurl' => '',
            'btnlink' => '',
            'btnlabel' => get_string('clickhere', 'theme_tilemmetry'),
            'color' => $this->rand_color(),
        ];
    }

    /**
     * Get default team member configuration
     * @param  string $icon        font awesome icon
     * @param  string $description description
     * @return array               array configuration array
     */
    private function get_default_team_member($icon, $description) {
        return [
            'name' => $this->get_textproperty('John Doe', true),
            'itemid' => '',
            'imgurl' => 'imgs/'.$icon,
            'quote' => $this->get_textproperty($description, true)
        ];
    }

    /**
     * Get default feature block
     * @param  string $icon        font awesome icon
     * @param  string $description description
     * @return array               block configuration array
     */
    private function get_default_feature_block($icon, $description) {
        return [
            'name' => $this->get_textproperty('Nam eget', true),
            'icon' => $this->get_textproperty($icon, true, false, true),
            'description' => $this->get_textproperty($description, true, true)
        ];
    }

    /**
     * Reset cache of frontpage sections
     */
    public function reset_cache() {
        $cache = cache::make('theme_tilemmetry', 'frontpage');

        // Reset sections list
        $records = $this->get_all_instances();
        $sections = $this->process_all_sections($records);
        $cache->set('sections', $sections);
    }

    /**
     * Process all sections data and generate sections array for js
     * @param  array   $records         Sections configuration array
     * @param  boolean $sectionnamelist Return section name list if this true
     * @return array                    Section configuration json array
     */
    public function process_all_sections($records, $sectionnamelist = false) {
        global $PAGE, $USER;
        $order = json_decode($this->get_sections_order(), true);
        $sections = [];
        $sectionnames = [];
        $userisediting = false;
        $loaderimage = false;
        if (isloggedin()) {
            $usercontext = context_user::instance($USER->id);
            $userisediting = has_capability('theme/tilemmetry:editfrontpage', $usercontext) && $PAGE->user_is_editing();
        }
        if (get_config('theme_tilemmetry', 'frontpageloader')) {
            $loaderimage = \theme_tilemmetry\toolbox::setting_file_url('frontpageloader', 'frontpageloader');
        }
        if (!empty($order)) {
            foreach ($order as $key) {
                if (isset($records[$key]) && $records[$key]->deleted == false) {
                    $data = $this->sectiondata($records[$key], $userisediting);
                    if ($data == null || (!$userisediting && !$records[$key]->visible)) {
                        continue;
                    }
                    $data['userisediting'] = $userisediting;
                    if ($loaderimage != false) {
                        $data['loader'] = $loaderimage;
                    }
                    $sections[] = json_encode($data);
                    $sectionnames[] = $records[$key]->name;
                }
            }
            $diff = array_diff(array_keys($records), $order);
        } else {
            $diff = array_keys($records);
        }
        if (count($diff) != 0) {
            foreach ($diff as $key) {
                if (isset($records[$key]) && $records[$key]->deleted == false) {
                    $data = $this->sectiondata($records[$key], $userisediting);
                    if ($data == null || (!$userisediting && !$records[$key]->visible)) {
                        continue;
                    }
                    $data['userisediting'] = $userisediting;
                    if ($loaderimage != false) {
                        $data['loader'] = $loaderimage;
                    }
                    $sections[] = json_encode($data);
                    $sectionnames[] = $records[$key]->name;
                }
            }
        }
        if ($sectionnamelist) {
            return array($sections, $sectionnames);
        }
        return $sections;
    }

    /**
     * Defines default configuration of sections
     * @param  string $sectionname Name of the section
     * @return array  Section configuration
     */
    public function section_configuration($sectionname) {
        global $OUTPUT;
        $commondescription = 'Holisticly harness just in timetechnologies are viarsus nunc, quis gravida magna mi a libero.';
        $sectionproperties = array(
            'itemid' => '',
            'imageurl' => '',
            'bgopacity' => '0',
            'bgcolor' => '#ffffff',
            'bgfixed' => 0,
            'ptop' => '25',
            'pright' => '25',
            'pleft' => '25',
            'pbottom' => '25',
            'container' => true,
            'shadowless' => true,
            'shadowcolor' => '#cccccc',
        );
        $defaulthtml = [
            "html" => [
                "text" => "<div class=\"h-300 text-center\">\r\n<p>" . get_string('htmldefaultcontent', 'theme_tilemmetry') . "</p>\r\n</div>",
                "format" => "1",
                "itemid" => 893377907
            ],
            "style" => "div {\r\nborder: 2px dashed #ccc;\r\n}"
        ];
        $sections = [
                'slider' => [
                    'sectid' => 1,
                    'name' => 'slider',
                    'configdata' => [
                        'enablenav' => 'navarrows',
                        'slides' => 1,
                        'slide' => [
                            [
                                'index' => '0',
                                'image' => false,
                                'video' => false,
                                'fileitemid' => '',
                                'fileurl' => 'slider-default.jpg',
                                'textalign' => 'center',
                                'heading' => 'LOREM IPSUM',
                                'headingcolor' => '#000000',
                                'description' => $commondescription,
                                'desccolor' => '#ffffff',
                                'btnlabel' => '',
                                'btnlink' => '',
                                'status' => true
                            ]
                        ]
                    ]
                ],
                'aboutus' => [
                    'sectid' => 2,
                    'name' => 'aboutus',
                    'configdata' => [
                        'sectionproperties' => $sectionproperties,
                        'title' => $this->get_textproperty(get_string('aboutus', 'theme_tilemmetry')),
                        'description' => $this->get_textproperty($commondescription, false, true),
                        'btnlink' => '',
                        'btnlabel' => get_string('clickhere', 'theme_tilemmetry'),
                        'image' => 0,
                        'imageurl' => 'imgs/bg4.png',
                        'bgopacity' => '0',
                        'view' => 1,
                        'block' => [
                            $this->get_default_aboutus_block('fa fa-paint-brush', $commondescription),
                            $this->get_default_aboutus_block('fa fa-umbrella', $commondescription),
                            $this->get_default_aboutus_block('fa fa-envira', $commondescription),
                            $this->get_default_aboutus_block('fa fa-magic', $commondescription)
                        ]
                    ]
                ],
                'contact' => [
                    'sectid' => 3,
                    'name' => 'contact',
                    'configdata' => [
                        'sectionproperties' => $sectionproperties,
                        'title' => $this->get_textproperty(get_string('contactus', 'theme_tilemmetry')),
                        'description' => $this->get_textproperty($commondescription, false, true),
                        'phone' => $this->get_textproperty('91+ 98475 485793', false, true),
                        'email' => $this->get_textproperty('support@support.com', false, true),
                        'socialview' => 'square',
                        'quora'   => 'https://www.quora.com/name',
                        'google'  => 'https://plus.google.com/pagename',
                        'twitter' => 'https://www.twitter.com/pagename',
                        'youtube' => 'https://www.youtube.com/channel/UCU1u6QtAAPJrV0v0_c2EISA',
                        'facebook'  => 'https://www.facebook.com/pagename',
                        'linkedin'  => 'https://www.linkedin.com/in/pagename',
                        'pinterest' => 'https://www.pinterest.com/name',
                        'instagram' => 'https://www.instagram.com/name',
                    ]
                ],
                'feature' => [
                    'sectid' => 4,
                    'name' => 'feature',
                    'configdata' => [
                        'sectionproperties' => $sectionproperties,
                        'title' => $this->get_textproperty(get_string('feature', 'theme_tilemmetry')),
                        'description' => $this->get_textproperty($commondescription, false, true),
                        'rows' => 2,
                        'row' => [
                            [
                                'features' => 4,
                                'feature' => [
                                    $this->get_default_feature_block('fa fa-cogs', $commondescription),
                                    $this->get_default_feature_block('fa fa-cube', $commondescription),
                                    $this->get_default_feature_block('fa fa-anchor', $commondescription),
                                    $this->get_default_feature_block('fa fa-leaf', $commondescription)
                                ]
                            ],
                            [
                                'features' => 4,
                                'feature' => [
                                    $this->get_default_feature_block('fa fa-university', $commondescription ),
                                    $this->get_default_feature_block('fa fa-magic', $commondescription),
                                    $this->get_default_feature_block('fa fa-snowflake-o', $commondescription),
                                    $this->get_default_feature_block('fa fa-street-view', $commondescription)
                                ]
                            ]
                        ]
                    ]
                ],
                'team' => [
                    'sectid' => 8,
                    'name' => 'team',
                    'configdata' => [
                        'sectionproperties' => $sectionproperties,
                        'title' => $this->get_textproperty(get_string('meetourteam', 'theme_tilemmetry')),
                        'description' => $this->get_textproperty($commondescription, false, true),
                        'rows' => 2,
                        'row' => [
                            [
                                'members' => 4,
                                'member' => [
                                    $this->get_default_team_member('fi1.png', $commondescription),
                                    $this->get_default_team_member('fi2.png', $commondescription),
                                    $this->get_default_team_member('fi3.png', $commondescription),
                                    $this->get_default_team_member('fi4.png', $commondescription)
                                ]
                            ],
                            [
                                'members' => 4,
                                'member' => [
                                    $this->get_default_team_member('fi5.png', $commondescription),
                                    $this->get_default_team_member('fi1.png', $commondescription),
                                    $this->get_default_team_member('fi2.png', $commondescription),
                                    $this->get_default_team_member('fi3.png', $commondescription)
                                ]
                            ]
                        ]
                    ]
                ],
                'courses' => [
                    'sectid' => 7,
                    'name' => 'courses',
                    'configdata' => [
                        'sectionproperties' => $sectionproperties,
                        'title' => $this->get_textproperty(get_string('allcourses', 'theme_tilemmetry')),
                        'description' => $this->get_textproperty($commondescription, false, true),
                        'show' => 'courses',
                        'categories' => [],
                        'date' => 'all'
                    ]
                ],
                'testimonial' => [
                    'sectid' => 9,
                    'name' => 'testimonial',
                    'configdata' => [
                        'sectionproperties' => $sectionproperties,
                        'title' => $this->get_textproperty(get_string('testimonial', 'theme_tilemmetry')),
                        'description' => $this->get_textproperty($commondescription, false, true),
                        'borderradius' => '0',
                        'view' => 1,
                        'namecolor' => '#555555',
                        'designationcolor' => '#555555',
                        'testimonialproperties' => $this->get_textproperty('', false , true),
                        'testimonials' => 1,
                        'testimonial' => [
                            [
                                'status' => 'active',
                                'name' => $this->get_textproperty('John Doe', true),
                                'designation' => $this->get_textproperty('Manager', true),
                                'testimonial' => $this->get_textproperty($commondescription),
                                'image' => 0,
                                'imageurl' => 'imgs/fi5.png',
                            ]
                        ]
                    ]
                ],
                'html' => [
                    'sectid' => 10,
                    'name' => 'html',
                    'configdata' => [
                        "applyfilter" => true,
                        "blocks" => "3",
                        "block" => [$defaulthtml, $defaulthtml, $defaulthtml]
                    ]
                ],
                'separator' => [
                    'sectid' => 11,
                    'name' => 'separator',
                    'configdata' => [
                        'sectionproperties' => $sectionproperties,
                        'style' => 'blurend',
                        'color' => '#e87171',
                        'width' => '40',
                        'color2' => '#858585',
                        'height' => 1,
                    ]
                ]
            ];

        return $sections[$sectionname];
    }

}