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

  $option_names = $new_whitelist_options[ 'option-settings-group' ];

  $fa = get_option('field_array');
  if(empty($fa)) {
    add_option( 'field_array', $option_names );
  }
  print_r($option_names);

  return $option_names;
}

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
  $option_names = get_optionpage_settings();
?>

  <div class="options-page-global-fields">
      <h2>Global Custom Fields</h2>
      <div class="page_option_wrap">
          <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); 
              $count = 1; ?>
              <div id="add_option" class="fields_holder">
               <?php foreach ($option_names as $option_name) : ?>
                  <?php $options = get_option($option_name); ?>
                    <?php print_r($options); ?>

                    <div class="field_wrap">
                      <div class="config_wrap">
                        <div class="input_wrap">
                          <p><strong>Field Name</strong></p>
                          <input type="text" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_name]" size="45" value="<?php if(!empty($options['field_name'])) { echo $options['field_name']; } ?>" placeholder="Field Name" />
                        </div>
                        <div class="input_wrap">
                          <p><strong>Field Type</strong></p>
                          <div class="radio_wrap">
                            <?php if(!empty($options['field_type'])) { $radio = $options['field_type']; } ?>
                            <div class="input_wrap radio">
                              <p>Type Text</p>
                              <input type="radio" id="type_text" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_type]" value="text" <?php if(!empty($radio)) { checked($radio == 'text'); } ?>/>
                            </div>
                            <div class="input_wrap radio">
                              <p>Type Image</p>
                              <input type="radio" id="type_image" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_type]" value="image" <?php if(!empty($radio)) { checked($radio == 'image'); } ?>/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="content_wrap">

                        <?php if($radio == 'text') : ?>

                            <div class="input_wrap">
                              <p><strong><?php if(!empty($options['field_name'])) { echo $options['field_name']; } ?></strong></p>
                              <input type="text" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_value]" size="45" value="<?php if(!empty($options['field_value'])) { echo $options['field_value']; } ?>" />
                            </div>

                        <?php elseif($radio == 'image') : ?>

                            <?php 
                              $value = ''; 
                              if(!empty($options['field_value'])) { 
                                $value = $options['field_value']; 
                              } ?>

                            <div class="input_wrap">
                              <p><strong><?php if(!empty($options['field_name'])) { echo $options['field_name']; } ?></strong></p>
                              
                              <input type="text" name="<?php if(!empty($option_name)) { echo $option_name; } ?>[field_value]" class="option_url" size="45" value="<?php echo $value; ?>" />
                              <input id="" type="button" class="button-primary upload_image_button" value="Insert Image" />
                              <div class="img_wrap">
                                <img src="<?php echo $value; ?>" class="uploaded_img">
                              </div>
                            </div>

                        <?php endif; ?>

                      </div>
                    </div>

               <?php $count++; endforeach; ?>
            </div>

            <!-- <div class="add_new_btn_wrap clearfix">
              <div id="add_new">ADD NEW</div>
            </div> 
        
            <?php //$uid = uniqid(); ?>
            <div id="new_option_specs" class="field_wrap new_spec_field">
              <div class="input_wrap">
                <p><strong>Field Name</strong></p>
                <input type="text" name="dat_set_<?php //echo $uid; ?>[field_name]" size="45" value="" placeholder="Field Name" />
              </div>
              <div class="input_wrap">
                <p><strong>Field Type</strong></p>
                <div class="radio_wrap">
                  <div class="input_wrap radio">
                    <p>Type Text</p>
                    <input type="radio" id="type_text" name="dat_set_<?php //echo $uid; ?>[field_type]" value="text"/>
                  </div>
                  <div class="input_wrap radio">
                    <p>Type Image</p>
                    <input type="radio" id="type_image" name="dat_set_<?php //echo $uid; ?>[field_type]" value="image"/>
                  </div>
                </div>
              </div>
              <div class="create_btn_wrap clearfix">
                <div id="create">CREATE</div>
              </div>
            </div> -->
            

              
              

            <div class="input_wrap submit_wrap">
                <input type="submit" name="Submit" id="add_new_option" value="Add Option" />
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="dat_set_1,dat_set_2" />
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


  