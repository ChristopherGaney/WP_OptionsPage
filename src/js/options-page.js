 
      // val = document.getElementById('hid-pg-opts').value;
      // val = val.split(',');
      // val.pop();
      // val = val.join(',');
      // console.log(val);
      // $('#hid-pg-opts').val(val);



  jQuery(document).ready(function($){
    var mediaUploader;
    var savedElements = [];

    var fieldPool = (function() {
      var i,nod,len,fields;
      
      // grab the fields after page loads
      fields = $('#option_page .fields_holder .field_wrap');
      
      //detach each field and push it to savedElements
      fields.each(function(i,el) {
        nod = $(el).detach();
        savedElements.push(nod);
      });
      $('.fields_holder').append(fields[0]);
      $('.fields_holder').append(fields[1]);

    })();
    
    $('#add_new').click(function(e) {
      var val;
    	if($('#new_option_specs').hasClass('showing')) {
        $('#new_option_specs').removeClass('showing');
        $('#update_options').removeClass('disabld');
        $('#new_option_specs.field_wrap').removeClass('fadin');
        setTimeout(function() {
          $('#new_option_specs.field_wrap').removeClass('enabld');
        },200);
      }
      else {
        $('#new_option_specs').addClass('showing');
        $('#update_options').addClass('disabld');
        $('#new_option_specs.field_wrap').addClass('enabld');
        setTimeout(function() {
        $('#new_option_specs.field_wrap').addClass('fadin');

        },200);
      }
    });
  
    $('#create').click(function(e) {
      var name,type,el;
      e.preventDefault();
      name = $('input[name=name_choice]').val();
      type = $('input[name=type_choice]').val();
      // Here we would grab the correct field based on type

      // add rest of data to element i.e data array
      el = savedElements[0];
      el.addClass('active');
      $('.fields_holder').append(el);
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