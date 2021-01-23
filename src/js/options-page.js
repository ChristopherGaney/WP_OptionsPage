var fieldChoice = `<div class="field_choice">
                      <p><strong>Field Type</strong></p>
                      <div class="radio_wrap">
                        <div class="input_wrap radio">
                          <p>Type Text</p>
                          <input type="radio" id="field-type-txt" name="type_choice" value="text">
                        </div>
                        <div class="input_wrap radio">
                          <p>Type Image</p>
                          <input type="radio" id="field-type-img" name="type_choice" value="image">
                        </div>
                      </div>
                  </div>`;



  jQuery(document).ready(function($){
  var mediaUploader;

  
  var fieldPool = (function() {
    var i,nod,len,fields;
    var savedElements = [];

    // grab the fields after page loads
    fields = $('#option_page .fields_holder .field_wrap');

    // detach each field and push it to savedElements
    fields.each(function(i,el) {
      nod = $(el).detach();
      savedElements.push(nod);
    });
  

    setTimeout(function() {
      $('#option_page .fields_holder').append(savedElements[0]);
      $('#option_page .fields_holder .field_wrap').addClass('enabld');
      $('.value_wrap').append(fieldChoice);
      setTimeout(function() {
        $('#option_page .fields_holder .field_wrap').addClass('fadin');

      },200);
    },1000);
  })();
  
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