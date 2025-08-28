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
 * CareerLearning theme config.
 *
 * @package    theme_careerlearning
 * @copyright  2024 CareerLearning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Theme name
$THEME->name = 'careerlearning';

// Theme parents (we'll inherit from Boost for modern Bootstrap base)
$THEME->parents = ['boost'];

// Theme sheets
$THEME->sheets = ['custom'];

// Theme editor sheets
$THEME->editor_sheets = [];

// Theme SCSS
$THEME->scss = function($theme) {
    return theme_careerlearning_get_main_scss_content($theme);
};

// Theme layouts
$THEME->layouts = [
    // Most backwards compatible layout without the blocks
    'base' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Standard layout with blocks
    'standard' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Main course page
    'course' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        'options' => ['langmenu' => true],
    ],
    // Course category
    'coursecategory' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Part of course, typical for modules - default page layout if $cm specified in require_login()
    'incourse' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // The site home page
    'frontpage' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        'options' => ['nonavbar' => true],
    ],
    // Server administration scripts
    'admin' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // My dashboard page
    'mydashboard' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        'options' => ['nonavbar' => true, 'langmenu' => true],
    ],
    // My public page
    'mypublic' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Login page
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['langmenu' => true],
    ],
    // Pages that appear in pop-up windows - no navigation, no blocks, no header
    'popup' => [
        'file' => 'columns1.php',
        'regions' => [],
        'options' => ['nofooter' => true, 'nonavbar' => true],
    ],
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => [
        'file' => 'columns1.php',
        'regions' => [],
        'options' => ['nofooter' => true, 'nocoursefooter' => true],
    ],
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible
    'embedded' => [
        'file' => 'embedded.php',
        'regions' => [],
    ],
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message
    'maintenance' => [
        'file' => 'maintenance.php',
        'regions' => [],
    ],
    // Should display the content and basic headers only
    'print' => [
        'file' => 'columns1.php',
        'regions' => [],
        'options' => ['nofooter' => true, 'nonavbar' => false],
    ],
    // The pagelayout used when a redirection is occuring
    'redirect' => [
        'file' => 'embedded.php',
        'regions' => [],
    ],
    // The pagelayout used for reports
    'report' => [
        'file' => 'columns2.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // The pagelayout used for safebrowser and securewindow
    'secure' => [
        'file' => 'secure.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
];

// Theme enable dock
$THEME->enable_dock = false;

// Theme prescsss callback
$THEME->prescsscallback = 'theme_careerlearning_get_pre_scss';

// Theme extra scss callback
$THEME->extrascsscallback = 'theme_careerlearning_get_extra_scss';

// Theme render factory
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Theme uses CSS post process
$THEME->csstreepostprocessor = 'theme_careerlearning_css_tree_post_processor';

// Load the theme javascripts
$THEME->javascripts = [];
$THEME->javascripts_footer = [];

// Remove blocks from right region
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

// Hide dock
$THEME->haseditswitch = true;