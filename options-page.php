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
// add options page

add_action('admin_menu', 'add_gcf_interface');
function add_gcf_interface() {
   $my_page = add_options_page('Global Custom Fields', 'Global Custom Fields', 'manage_options', 'functions', 'editglobalcustomfields');

   add_action( 'admin_init', 'register_option_settings' );
}

function register_option_settings() {
	//register our settings
	register_setting( 'option-settings-group', 'header_text_1' );
	register_setting( 'option-settings-group', 'header_image_1' );
	register_setting( 'option-settings-group', 'sidebar_text_1' );
	register_setting( 'option-settings-group', 'sidebar_image_1' );
}

function editglobalcustomfields() {
    ?>
    <div class="wrap options-page-global-fields">
      <h2>Global Custom Fields</h2>
      <form id="option_fields" method="post" action="options.php" name="options_inputs">
        <?php wp_nonce_field('update-options') ?>
      </form>
      <form id="add_option" method="post" action="options.php" name="option_addition">
          <?php wp_nonce_field('update-options') ?>
          
      </form>
        <div class="input_wrap">
          <p><strong>Header Text 1</strong></p>
          <input type="text" name="header_text_1" size="45" form="option_fields" value="<?php echo get_option('header_text_1'); ?>" />
        </div>
        
        <div class="input_wrap">
          <p><strong>Header Image 1</strong></p>
          <?php $header_image_1 = get_option('header_image_1'); ?>
          <input type="text" name="header_image_1" class="option_url" size="45"" form="option_fields" value="<?php echo $header_image_1; ?>" />
          <input id="" type="button" class="button-primary upload_image_button" value="Insert Image" />
          <div class="img_wrap">
            <img src="<?php echo $header_image_1; ?>" class="uploaded_img">
          </div>
        </div>

        <div class="input_wrap">
          <p><strong>Sidebar Text 1</strong></p>
          <input type="text" name="sidebar_text_1" size="45" form="option_fields" value="<?php echo get_option('sidebar_text_1'); ?>" />
        </div>
        <div class="input_wrap">
          <p><strong>Sidebar Image 1</strong></p>
          <?php $sidebar_image_1 = get_option('sidebar_image_1'); ?>
          <input type="text" name="sidebar_image_1" class="option_url" size="45" form="option_fields" value="<?php echo $sidebar_image_1; ?>" />
          <input id="" type="button" class="button-primary upload_image_button" value="Insert Image" />
          <div class="img_wrap">
            <img src="<?php echo $sidebar_image_1; ?>" class="uploaded_img">
          </div>
        </div>
        <!-- Place to add new option -->
        <div class="add_new_option_wrap">
          <button id="add_new">ADD NEW</button>
          <div class="new_option_specs">
            <div class="input_wrap">
              <p><strong>Field Name</strong></p>
              <input type="text" name="field_name" size="45" form="add_option" value="" placeholder="Field Name" />
            </div>
            <p><strong>Field Type</strong></p>
            <div class="radio_wrap">
              <div class="input_wrap">
                <p>Type Text</p>
                <input type="radio" id="type_text" name="field_type" form="add_option" value="text"/>
              </div>
              <div class="input_wrap">
                <p>Type Image</p>
                <input type="radio" id="type_image" name="field_type" form="add_option" value="image"/>
              </div>
            </div>
            <div class="input_wrap submit_wrap">
                <input type="submit" name="Submit" form="add_option" value="Add Option" />
                <input type="hidden" name="action" form="add_option" value="update" />
                <input type="hidden" name="page_options" form="add_option" value="field_name, field_type" />
            </div>
          </div>
        </div>
        <!-- End Place to add new option -->
        <div class="input_wrap submit_wrap">
          <input type="submit" name="Submit" form="option_fields" value="Update Options" />

          <input type="hidden" name="action" value="update" />
          <input type="hidden" name="page_options" value="header_text_1,header_image_1,sidebar_text_1,sidebar_image_1" />
        </div>
    </div>
    <?php
}

  function options_page_enqueue() {
      wp_enqueue_media();
      wp_register_script('options-page', plugin_dir_url( __FILE__ ) . 'js/options-page.js', array('jquery'), '1.0.0', true);
      wp_enqueue_script('options-page');
      wp_register_style('options-page', plugin_dir_url( __FILE__ ) . 'css/options-page.css', array(), '2.3.4', 'all');
      wp_enqueue_style('options-page');
  }
  add_action('admin_enqueue_scripts', 'options_page_enqueue');
?>