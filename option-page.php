<?php
  /* 
   Plugin Name: optionspage
   Plugin URI: https://github.com
   description: >-
  a plugin for creating an options page
   Version: 1.0
   Author: CG
   Author URI: https://github.com
   License: GPL2
   */
?>


<?php

//$new_allowed_options

function get_optionpage_settings() {
  
  $option_names = get_option('field_array');

  //echo 'option names';
  //print_r($option_names);

  if(empty($option_names)) {
        echo 'building $option names';

        $option_names = [];
      
        for($i = 0;$i < 3;$i++) {
          $field_id = 'txt_input_' . $i;//uniqid();
          $tmp = array("field_id"=> $field_id, "field_type" => "text" );
          array_push($option_names, $tmp);
      }
    
      update_option( 'field_array', $option_names );
  }
  
   return $option_names;
}

add_action('admin_menu', 'add_gcf_interface');
function add_gcf_interface() {
   $my_page = add_options_page('Global Custom Fields', 'Global Custom Fields', 'manage_options', 'functions', 'options_page_saved_opts');

   add_action( 'admin_init', 'register_option_settings' );
}

function register_option_settings() {

    $option_names = get_optionpage_settings();//get_option('field_array');

    foreach($option_names as $option) {
      register_setting( 'option-pool-group', $option['field_id']);
    }
}

function options_page_saved_opts(){ 
//  global $new_whitelist_options; 
//   $reggie_fields = $new_whitelist_options[ 'option-pool-group' ];// check for options
// echo 'printing';
//   if(!empty($reggie_fields)) {
//       print_r($reggie_fields);
//   }
//   echo 'fetcher<br><br>';
  $option_names = get_optionpage_settings();
  //print_r($option_names);
  
?>

  <div class="options-page-global-fields">
    <h2>Global Custom Fields</h2>
    <div class="page_option_wrap">
        <form id="option_page" method="post" action="options.php">
          <?php wp_nonce_field('update-options'); 
            $count = 1; ?>
          <div class="fields_holder">
             <?php foreach ($option_names as $option_name) : ?>
                <?php $options = get_option($option_name['field_id']);
               // print_r($option_name); 
                //print_r($options);
            $jsn = htmlspecialchars(json_encode($option_name)); 

              ?>

                <div class="field_wrap">
                    <div class="config_wrap">
                      <div class="input_wrap data_wrap">
                        <input type="text" name="<?php if(!empty($option_name['field_id'])) { echo $option_name['field_id']; } ?>[field_data]" value="<?php if(!empty($options['field_data'])) { echo $options['field_data'];}else { echo $jsn; } ?>">
                      </div>
                      <div class="input_wrap name_wrap">
                        <p>Field Name</p>
                        <input type="text" name="<?php if(!empty($option_name['field_id'])) { echo $option_name['field_id']; } ?>[field_name]" value="<?php if(!empty($options['field_name'])) { echo $options['field_name']; } ?>">
                      </div>
                      <div class="input_wrap value_wrap">
                            <p class="v_name"><?php if(!empty($options['field_name'])) { echo $options['field_name']; } ?></p>
                            <input class="v_input" type="text" name="<?php if(!empty($option_name['field_id'])) { echo $option_name['field_id']; } ?>[field_value]" value="<?php if(!empty($options['field_value'])) { echo $options['field_value']; } ?>">
                          </div>
                    </div>
                  </div>
                 

             <?php $count++; endforeach; ?>
          </div>

          <!--****************************************************************-->
          <div class="add_new_btn_wrap clearfix">
              <div id="add_new">ADD NEW</div>
          </div> 
        
          <div id="new_option_specs" data-id="" class="field_wrap new_spec_field">
              
                <div class="config_wrap">
                    <div class="input_wrap name_wrap">
                      <p><strong>Field Name</strong></p>
                      <input type="text" name="name_choice" value="">
                    </div>
                    <p><strong>Field Type</strong></p>
                    <div class="radio_wrap">
                      <div class="input_wrap radio">
                        <p>Type Text</p>
                        <input type="radio" id="field_type_txt" name="type_choice" value="text" checked>
                      </div>
                      <div class="input_wrap radio">
                        <p>Type TextArea</p>
                        <input type="radio" id="field_type-txt_area" name="type_choice" value="textarea" disabled>
                      </div>
                      <div class="input_wrap radio">
                        <p>Type Image</p>
                        <input type="radio" id="field_type_img" name="type_choice" value="image" disabled>
                      </div>
                    </div>
                    <div class="create_btn_wrap">
                      <div id="create">CREATE FIELD</div>
                    </div>
                </div>
          </div>

            <!--****************************************************************-->

          <div class="input_wrap submit_wrap">
              <input type="submit" name="Submit" id="update_options" value="Update Options">
              <input type="hidden" name="action" value="update">
              <input type="hidden" id="hid-pg-opts" name="page_options" value="<?php 
                // these maybe don't need to be here until fields are saved
                $option_names = get_option('field_array');
                $len = count($option_names);
            
                for($i = 0;$i < $len;$i++) {
                  if($i == ($len - 1)) {
                    echo $option_names[$i]['field_id'];
                  }
                  else {
                    echo $option_names[$i]['field_id'] . ',';
                  }
                }
              //implode(',',$option_names);
                ?>">
          </div>
        </form>
  
    </div>
  </div>



  <?php }

 function options_page_enqueue() {
  
      wp_enqueue_media();
      wp_register_script('options-page', plugin_dir_url( __FILE__ ) . 'dist/js/options-page.min.js', array('jquery'), '1.0.0', true);
      wp_enqueue_script('options-page');
      wp_register_style('options-page', plugin_dir_url( __FILE__ ) . 'dist/css/options-page.min.css', array(), '2.0.0', 'all');
      wp_enqueue_style('options-page');
  }
  add_action('admin_enqueue_scripts', 'options_page_enqueue');

  ?>      
