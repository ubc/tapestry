/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {

    // Site title and description.
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Refresh a moved partial containing a Twitter timeline iframe, since it has to be re-built.
    /*wp.customize.selectiveRefresh.bind( 'partial-content-moved', function( placement ) {
        if ( placement.container && placement.container.find( 'iframe.twitter-timeline:not([src]):first' ).length ) {
            placement.partial.refresh();
        }
    } );*/

    // Header text color.
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'blazing'
                });
            } else {
                $('.site-title, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': to
                });
            }
        });
    });

})(jQuery);

jQuery(document).ready(function($) {
    'use strict';

    wp.customize.preview.bind('customizer-section-clicked', function(value) {
        var section = '.section-' + value;
        if ($(section).length > 0) {
            $('html, body').animate({
                scrollTop: $(section).offset().top - 50
            }, 1000);
        }
    });

});