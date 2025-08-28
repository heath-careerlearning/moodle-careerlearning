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
 * Main JavaScript module for CareerLearning theme.
 *
 * @module     theme_careerlearning/main
 * @copyright  2024 CareerLearning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/log'], function($, log) {
    'use strict';

    /**
     * Initialize the theme JavaScript.
     */
    var init = function() {
        log.debug('CareerLearning theme JavaScript initialized');
        
        // Add smooth scrolling to all links
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });

        // Add fade-in animation to cards
        $('.card').each(function(index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(20px)'
            }).delay(index * 100).animate({
                opacity: 1
            }, {
                duration: 500,
                step: function(now) {
                    $(this).css('transform', 'translateY(' + (20 * (1 - now)) + 'px)');
                }
            });
        });

        // Initialize tooltips if Bootstrap is available
        if (typeof $.fn.tooltip !== 'undefined') {
            $('[data-toggle="tooltip"]').tooltip();
        }

        // Add active class to current navigation item
        var currentPath = window.location.pathname;
        $('.navbar-nav .nav-link').each(function() {
            if ($(this).attr('href') === currentPath) {
                $(this).addClass('active');
            }
        });
    };

    /**
     * Handle responsive navigation
     */
    var handleResponsiveNav = function() {
        var $navToggle = $('.navbar-toggler');
        var $navMenu = $('.navbar-collapse');

        $navToggle.on('click', function() {
            $navMenu.toggleClass('show');
        });

        // Close menu when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.navbar').length) {
                $navMenu.removeClass('show');
            }
        });
    };

    return {
        init: function() {
            init();
            handleResponsiveNav();
        }
    };
});