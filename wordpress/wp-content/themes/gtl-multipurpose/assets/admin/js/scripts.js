jQuery(document).ready(function( $ ) {

        if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $(document).on('click', '.set_custom_images', function(e) {
                e.preventDefault();
                var button = $(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function(props, attachment) { 
                    id.val(attachment.id);
                    $('.preview img').src( attachment.sizes.thumbnail);
                };
                wp.media.editor.open(button);
                return false;
            });
        }
 

  $('.color-field').wpColorPicker();

  $( document ).ajaxComplete(function() {

        $('.color-field').wpColorPicker();

   });
  
});