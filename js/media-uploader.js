jQuery(document).ready(function($){
  var mediaUploader;
  $('#upload_image_button').click(function(e) {
    e.preventDefault();
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });
    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      console.log(attachment.url);
      $('#featured_img').val(attachment.url);
      $('#uploaded_img').attr('src', attachment.url);
    });
    mediaUploader.open();
  });
});