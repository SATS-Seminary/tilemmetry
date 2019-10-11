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
 * SATS Tilemmetry Announcements
 * @package    theme_tilemmetry
 * @copyright  (c) 2018 South African Theological Seminary (https://sats.edu.za/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
// include Moodle config
if (!@include_once(__DIR__.'/../../config.php')) {
    include_once('/var/www/html/moodle/v35/config.php');
}

global $DB, $OUTPUT, $CFG, $USER;

$response = \theme_tilemmetry\utility::get_tilemmetry_announcemnets();

// get update info
$updateinfo = array();
if (isset($response['updateinfo']) && !empty($response['updateinfo'])) {
    $updateinfo = $response['updateinfo'];
}

// get tilemmetry installed status
$pm = \core_plugin_manager::instance();
$currenttilemmetry = $pm->get_plugin_info('theme_tilemmetry')->release;
$currentmoodle = substr($CFG->release, 0, 3);
?>
<style>
  input.star { display: none; }
  label.star {
    float: right;
    padding: 0 10px;
    margin: 0;
    font-size: 22px;
    color: #999;
    transition: all .2s;
  }

  input.star:checked ~ label.star:before {
    content: '\f005';
    color: #Fb4;
    /* transition: all .2s; */
  }
  input.star-1:checked ~ label.star:before { color: #F62; }
  input.star-2:checked ~ label.star:before { color: #F92; }
  /* label.star:hover { transform: scale(1.1); } */
  label.star:before {
    content: '\f006';
    font-family: Font Awesome;
  }
</style>

<!-- announcements section -->
<?php
echo "<div>";
echo "<div class='col-12'>";

if (isset($response['announcements']) && !empty($response['announcements'])) {
    echo "<h2 class='h3 mb-25 row'>".get_string('recentnews', 'theme_tilemmetry')."</h2>";

    echo '<div class="row">';
    foreach ($response['announcements'] as $anc) {
        if (!empty($anc['image'])) {
            echo "<div class='card' style='background: #f1f4f5;'>
                <img class='card-img-top w-full' src='{$anc['image']}'>
                    <div class='card-block'>";
            if (!empty($anc['link'])) {
                echo "<h4 class='card-title'><a href='{$anc['link']}' target='_blank' class='grey-800'>{$anc['title']}</a></h4>";
            } else {
                echo "<h4 class='card-title grey-800'>{$anc['title']}</h4>";
            }
            if (!empty($anc['excerpt'])) {
                echo "<p class='card-text'>{$anc['excerpt']}</p>";
            }
            echo "</div>
                  </div>";
        } else {
            echo "<div class='card card-block card-inverse card-{$anc['type']} text-center p-15'>
                  <blockquote class='blockquote cover-quote card-blockquote'>";
            if (!empty($anc['excerpt'])) {
                echo "<p>{$anc['excerpt']}</p>";
            }

            if (!empty($anc['link'])) {
                echo "<footer>
                        <small>
                          Read more
                          <cite title='Here'><a href='{$anc['link']}' target='_blank' class='text-white font-size-16 font-weight-600'>Here</a></cite>
                        </small>
                      </footer>";
            }
            echo "</blockquote>
                  </div>";
        }
    }
    echo '</div>';
}

echo "</div>
</div>";
?>
<!-- if close -->
<?php }?>
