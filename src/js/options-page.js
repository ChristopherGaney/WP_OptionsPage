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
    var val;
  	if($('#new_option_specs').hasClass('showing')) {
      $('#new_option_specs').removeClass('showing');
      $('#field-name-input, #field-type-txt, #field-type-img').prop( "disabled", true );
      $('#update_options').css({"opacity":"1", "pointerEvents":"auto"});
      val = document.getElementById('hid-pg-opts').value;
      val = val.split(',');
      val.pop();
      val = val.join(',');
      console.log(val);
      $('#hid-pg-opts').val(val);
    }
    else {
      $('#new_option_specs').addClass('showing');
      $('#field-name-input, #field-type-txt, #field-type-img').prop( "disabled", false );
      $('#update_options').css({"opacity":".35", "pointerEvents":"none"});
      val = $('#hid-pg-opts').val();
      $('#hid-pg-opts').val(val + ',' + $('#new_option_specs').data('id'));
      console.log(val);
    }
  });
  $('#create').click(function(e) {
  	 //$('#add_new').trigger('click');
     //$('#add_option').append(newHTMLfield); 
     console.log('clicked create');
     $('#option_page').submit();
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