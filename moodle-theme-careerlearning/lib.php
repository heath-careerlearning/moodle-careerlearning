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
 * CareerLearning theme library functions.
 *
 * @package    theme_careerlearning
 * @copyright  2024 CareerLearning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content for the theme.
 *
 * @param theme_config $theme The theme config object.
 * @return string The SCSS content.
 */
function theme_careerlearning_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    
    // Pre CSS - this is loaded BEFORE any other CSS.
    $scss .= file_get_contents($CFG->dirroot . '/theme/careerlearning/scss/pre.scss');

    // Main CSS - Get CSS from parent themes.
    $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');

    // Post CSS - this is loaded AFTER the main CSS.
    $scss .= file_get_contents($CFG->dirroot . '/theme/careerlearning/scss/post.scss');

    return $scss;
}

/**
 * Get pre SCSS code.
 *
 * @param theme_config $theme The theme config object.
 * @return string The pre SCSS code.
 */
function theme_careerlearning_get_pre_scss($theme) {
    $scss = '';
    
    // Define custom SCSS variables here.
    $scss .= '$primary: #4A90E2;' . "\n";
    $scss .= '$secondary: #6C757D;' . "\n";
    $scss .= '$success: #28A745;' . "\n";
    $scss .= '$info: #17A2B8;' . "\n";
    $scss .= '$warning: #FFC107;' . "\n";
    $scss .= '$danger: #DC3545;' . "\n";
    $scss .= '$light: #F8F9FA;' . "\n";
    $scss .= '$dark: #343A40;' . "\n";
    
    // Custom theme colors
    $scss .= '$theme-primary: #4A90E2;' . "\n";
    $scss .= '$theme-secondary: #F5F5F5;' . "\n";
    $scss .= '$theme-accent: #FF6B6B;' . "\n";
    
    return $scss;
}

/**
 * Get extra SCSS code.
 *
 * @param theme_config $theme The theme config object.
 * @return string The extra SCSS code.
 */
function theme_careerlearning_get_extra_scss($theme) {
    $scss = '';
    
    // Add any extra SCSS that should be included after all other styles.
    
    return $scss;
}

/**
 * CSS tree post processor.
 *
 * @param string $tree The CSS tree.
 * @param theme_config $theme The theme config object.
 * @return string The processed CSS tree.
 */
function theme_careerlearning_css_tree_post_processor($tree, $theme) {
    // Process the CSS tree if needed.
    return $tree;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course The course object.
 * @param stdClass $cm The course module object.
 * @param context $context The context.
 * @param string $filearea The file area.
 * @param array $args The arguments.
 * @param bool $forcedownload Whether to force download.
 * @param array $options Additional options.
 * @return bool False if file not found, does not return if found.
 */
function theme_careerlearning_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $theme = theme_config::load('careerlearning');
        
        // Handle theme file areas like logos, background images, etc.
        if ($filearea === 'logo' || $filearea === 'backgroundimage') {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        }
    }
    
    send_file_not_found();
}