var newHTMLfield = `<div class="field_wrap next_spec_field">
              <div class="input_wrap">
                <p><strong>Field Name</strong></p>
                <input type="text" name="dat_set_<?php echo $count_dracula; ?>[field_name]" size="45" form="add_option" value="" placeholder="Field Name" />
              </div>
              <div class="input_wrap">
                <p><strong>Field Type</strong></p>
                <div class="radio_wrap">
                  <div class="input_wrap radio">
                    <p>Type Text</p>
                    <input type="radio" id="type_text" name="dat_set_<?php echo $count; ?>[field_type]" form="add_option" value="text"/>
                  </div>
                  <div class="input_wrap radio">
                    <p>Type Image</p>
                    <input type="radio" id="type_image" name="dat_set_<?php echo $count; ?>[field_type]" form="add_option" value="image"/>
                  </div>
                </div>
              </div>`;


jQuery(document).ready(function($){
  var mediaUploader;
  $('#add_new').click(function(e) {
  	$('#new_option_specs').toggleClass('showing');
  });
  $('#create').click(function(e) {
  	 $('#new_option_specs').toggleClass('showing');
     $('#add_option').append(newHTMLfield); 
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