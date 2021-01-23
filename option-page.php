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



function get_optionpage_settings() {
  global $new_whitelist_options; 
  $option_names = $new_whitelist_options[ 'option-pool-group' ];// check for options

  if(!empty($option_names)) {
      print_r($option_names);
  }


 //  $unids = [];
 //  for($i = 0;$i < 10;$i++) {
 //       array_push($unids, 'txt_pool_' . uniqid());
 //  }
 // // print_r(get_option('field_array'));
 //  update_option( 'field_array', $unids );


  //print_r(get_option('field_array'));
 //  //if(!empty($option_names)) {
 //    // array_push($option_names, $latest);
 //  //}
   //add_option( 'field_array', $latest );

 // // create one new option
 //  /*$unids = [];
 // // figure out how to merge the two arrays . .  the first is assoc
 //  for($i = 0;$i < 20;$i++) {
 //      array_push($unids, 'dat_node_' . uniqid());
 //  }
 //  // add old and new options to array for register
 //  add_option( 'field_array', $unids );*/

 //  // return to calling function
   return $option_names;
}

add_action('admin_menu', 'add_gcf_interface');
function add_gcf_interface() {
   $my_page = add_options_page('Global Custom Fields', 'Global Custom Fields', 'manage_options', 'functions', 'options_page_saved_opts');

   add_action( 'admin_init', 'register_option_settings' );
}

function register_option_settings() {
    $option_names = get_option('field_array');
    //print_r($options);
    foreach($option_names as $option) {
    register_setting( 'option-pool-group', $option);
  }
}

function options_page_saved_opts(){ 
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
                <?php $options = get_option($option_name); ?>

                  <div class="field_wrap">
                    <div class="config_wrap">
                      <div class="input_wrap data_wrap">
                        <input type="hidden" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_data]" value="<?php if(!empty($options['field_name'])) { echo $options['field_data']; } ?>">
                      </div>
                      <div class="input_wrap name_wrap">
                        <p><strong>Field Name</strong></p>
                        <input type="text" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_name]" value="<?php if(!empty($options['field_name'])) { echo $options['field_name']; } ?>">
                      </div>
                      <div class="input_wrap value_wrap">
                            <p class="v_name"><strong><?php if(!empty($options['field_name'])) { echo $options['field_name']; } ?></strong></p>
                            <input class="v_input" type="text" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_value]" value="<?php if(!empty($options['field_value'])) { echo $options['field_value']; } ?>">
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
                        <input type="radio" id="field-type-txt" name="type_choice" value="text" checked>
                      </div>
                      <div class="input_wrap radio">
                        <p>Type TextArea</p>
                        <input type="radio" id="field-type-txtArea" name="type_choice" value="textarea" disabled>
                      </div>
                      <div class="input_wrap radio">
                        <p>Type Image</p>
                        <input type="radio" id="field-type-img" name="type_choice" value="image" disabled>
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
              <input type="hidden" id="hid-pg-opts" name="page_options" value="<?php implode(',',$option_names); ?>">
          </div>
        </form>
  
    </div>
  </div>



  <?php }

 function options_page_enqueue() {
    echo 'enqueuing now';
      wp_enqueue_media();
      wp_register_script('options-page', plugin_dir_url( __FILE__ ) . 'dist/js/options-page.min.js', array('jquery'), '1.0.0', true);
      wp_enqueue_script('options-page');
      wp_register_style('options-page', plugin_dir_url( __FILE__ ) . 'dist/css/options-page.min.css', array(), '2.0.0', 'all');
      wp_enqueue_style('options-page');
  }
  add_action('admin_enqueue_scripts', 'options_page_enqueue');

  ?>      
