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
}

function editglobalcustomfields() {
    ?>
    <div class="wrap options-page-global-fields">
      <h2>Global Custom Fields</h2>
      <form method="post" action="options.php">
        <?php wp_nonce_field('update-options') ?>

        <div class="input_wrap">
          <p><strong>Header Text 1</strong></p>
          <input type="text" name="header_text_1" size="45" value="<?php echo get_option('header_text_1'); ?>" />
        </div>
        
        <div class="input_wrap">
          <p><strong>Header Image 1</strong></p>
          <?php $header_image_1 = get_option('header_image_1'); ?>
          <input type="text" name="header_image_1" class="option_url" size="45" value="<?php echo $header_image_1; ?>" />
          <input id="" type="button" class="button-primary upload_image_button" value="Insert Image" />
          <div class="img_wrap">
            <img src="<?php echo $header_image_1; ?>" class="uploaded_img">
          </div>
        </div>

        <div class="input_wrap">
          <p><strong>Sidebar Text 1</strong></p>
          <input type="text" name="sidebar_text_1" size="45" value="<?php echo get_option('sidebar_text_1'); ?>" />
        </div>
        <div class="input_wrap">
          <p><strong>Sidebar Image 1</strong></p>
          <?php $sidebar_image_1 = get_option('sidebar_image_1'); ?>
          <input type="text" name="sidebar_image_1" class="option_url" size="45" value="<?php echo $sidebar_image_1; ?>" />
          <input id="" type="button" class="button-primary upload_image_button" value="Insert Image" />
          <div class="img_wrap">
            <img src="<?php echo $sidebar_image_1; ?>" class="uploaded_img">
          </div>
        </div>

        <div class="input_wrap submit_wrap">
          <input type="submit" name="Submit" value="Update Options" />

          <input type="hidden" name="action" value="update" />
          <input type="hidden" name="page_options" value="header_text_1,header_image_1,sidebar_text_1,sidebar_image_1" />
        </div>
      </form>
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