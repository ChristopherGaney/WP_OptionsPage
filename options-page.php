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

add_action('admin_menu', 'add_gcf_interface');
function add_gcf_interface() {
   $my_page = add_options_page('Global Custom Fields', 'Global Custom Fields', 'manage_options', 'functions', 'options_page_saved_opts');

   add_action( 'admin_init', 'register_option_settings' );
}

function register_option_settings() {
  $opts = get_option('field_array');
  foreach ($opts as $name) {
    register_setting( 'option-settings-group', $name);
  }
}

function options_page_saved_opts(){ 

  global $new_whitelist_options;
  $option_names = $new_whitelist_options[ 'option-settings-group' ];
  add_option( 'field_array', $option_names );
  echo $option_names[0];
  echo 'break <br>';
  $ct = count($option_names);
  echo $ct;
  $unique_num = get_option('unique_num');
  echo $unique_num;
  if(empty($unique_num)) {
    add_option('unique_num', $ct + 1);
    $unique_num = $ct + 1;
  }
?>

  <div class="options-page-global-fields">
      <h2>Global Custom Fields</h2>
      <div class="page_option_wrap">
        <div class="page_option_specs">
          <form method="post" action="options.php" name="option_addition">
            <?php wp_nonce_field('update-options'); 
              $count = 1; ?>
              <div id="add_option" class="fields_holder">
             <?php foreach ($option_names as $option_name) : ?>
                <?php $options = get_option($option_name); ?>

                  <div class="field_wrap">
                    <div class="input_wrap">
                      <p><strong>Field Name</strong></p>
                      <input type="text" name="<?php echo $option_name; ?>[field_name]" size="45" form="add_option" value="<?php echo $options['field_name']; ?>" placeholder="Field Name" />
                    </div>
                    <div class="input_wrap">
                      <p><strong>Field Type</strong></p>
                      <div class="radio_wrap">
                        <?php $radio = $options['field_type']; ?>
                        <div class="input_wrap radio">
                          <p>Type Text</p>
                          <input type="radio" id="type_text" name="<?php echo $option_name; ?>[field_type]" form="add_option" value="text" <?php checked($radio == 'text'); ?>/>
                        </div>
                        <div class="input_wrap radio">
                          <p>Type Image</p>
                          <input type="radio" id="type_image" name="<?php echo $option_name; ?>[field_type]" form="add_option" value="image" <?php checked($radio == 'image'); ?>/>
                        </div>
                      </div>
                    </div>
                  </div>
             <?php $count++; endforeach; ?>
           </div>

            <div class="add_new_btn_wrap clearfix">
              <div id="add_new">ADD NEW</div>
            </div> 
        
            <div id="new_option_specs" class="field_wrap new_spec_field">
              <div class="input_wrap">
                <p><strong>Field Name</strong></p>
                <input type="text" name="dat_set_<?php echo $unique_num; ?>[field_name]" size="45" form="add_option" value="" placeholder="Field Name" />
              </div>
              <div class="input_wrap">
                <p><strong>Field Type</strong></p>
                <div class="radio_wrap">
                  <div class="input_wrap radio">
                    <p>Type Text</p>
                    <input type="radio" id="type_text" name="dat_set_<?php echo $unique_num; ?>[field_type]" form="add_option" value="text"/>
                  </div>
                  <div class="input_wrap radio">
                    <p>Type Image</p>
                    <input type="radio" id="type_image" name="dat_set_<?php echo $unique_num; ?>[field_type]" form="add_option" value="image"/>
                  </div>
                </div>
              </div>
              <div class="create_btn_wrap clearfix">
                <div id="create">CREATE</div>
              </div>
            </div>

              
              

            <div class="input_wrap submit_wrap">
                <input type="submit" name="Submit" id="add_new_option" form="add_option" value="Add Option" />
                <input type="hidden" name="action" form="add_option" value="update" />
                <input type="hidden" name="page_options" form="add_option" value="dat_set_1,dat_set_2" />
            </div>
          </form>
        </div>
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


  