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

namespace theme_tilemmetry\output;

// use coding_exception;
// use html_writer;
// use tabobject;
// use tabtree;
// use custom_menu_item;
// use custom_menu;
// use block_contents;
// use navigation_node;
// use action_link;
// use moodle_url;
// use preferences_groups;
// use action_menu;
// use help_icon;
// use single_button;
// use paging_bar;
// use context_course;
// use pix_icon;
// use action_menu_filler;
use stdClass;
use theme_tilemmetry\renderables\tilemmetry_sidebar;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_tilemmetry
 * @copyright  2012 Bas Brands, www.basbrands.nl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class tilemmetry_renderer extends \core_renderer {

    /**
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_tilemmetry_sidebar(tilemmetry_sidebar $tilemmetry_sidebar) {
        return $this->render_from_template('theme_tilemmetry/tilemmetry_sidebar', $tilemmetry_sidebar->export_for_template($this));
    }
}
