jQuery(document).ready(function($){
  var mediaUploader;
  $('#add_new').click(function(e) {
  	$('#new_option_specs').addClass('showing');
  });
  $('#add_new_option').click(function(e) {
  	// herre we add new option w/ ajax
  });
  $('.upload_image_button').click(function(e) {
    var url,img;
    e.preventDefault();
    console.log('clicked now');
    url = $(this).closest('.input_wrap').find('.option_url');
    img = $(this).closest('.input_wrap').find('.uploaded_img');
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
      $(url).val(attachment.url);
      $(img).attr('src', attachment.url);
    });
    mediaUploader.open();
  });
});