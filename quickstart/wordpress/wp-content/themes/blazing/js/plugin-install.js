jQuery(document).ready(function($) {
    'use strict';
    var this_obj = blazing_companion_install;

    $(document).on('click', '.blazing-plugin-install', function(event) {
        event.preventDefault();
        var button = $(this);

        var slug = button.data('slug');
        button.text(this_obj.installing + '...').addClass('updating-message');
        wp.updates.installPlugin({
            slug: slug,
            success: function(data) {
                button.attr('href', data.activateUrl);
                button.text(this_obj.activating + '...');
                button.removeClass('button-secondary updating-message');
                button.addClass('button-primary blazing-plugin-activate');
                button.trigger('click');
            },
            error: function(data) {
                console.log('error', data);
                button.removeClass('updating-message');
                button.text(this_obj.error);
            },
        });
    });

    $(document).on('click', '.blazing-plugin-activate', function(event) {
        event.preventDefault();
        var button = $(this);
        var url = button.attr('href');
        if (typeof url !== 'undefined') {
            // Request plugin activation.
            jQuery.ajax({
                async: true,
                type: 'GET',
                url: url,
                beforeSend: function() {
                    button.text(this_obj.activating + '...');
                    button.removeClass('button-secondary');
                    button.addClass('button-primary activate-now updating-message');
                },
                success: function(data) {
                    location.reload();
                }
            });
        }
    });
});