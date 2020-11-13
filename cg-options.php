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
    <style>.img_wrap {display: block;padding: 1rem 1rem 2rem;}</style>
    <div class='wrap'>
    <h2>Global Custom Fields</h2>
    <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?>

    <p><strong>My Name:</strong><br />
    <input type="text" name="myname" size="45" value="<?php echo get_option('myname'); ?>" /></p>
    
    <p><strong>Amazon ID:</strong><br />
    <input type="text" name="amazonid" size="45" value="<?php echo get_option('amazonid'); ?>" /></p>

    <p><strong>Today's Featured Website:</strong><br />
    <input type="text" name="todaysite" size="45" value="<?php echo get_option('todaysite'); ?>" /></p>

    <p><strong>Welcome Text:</strong><br />
    <textarea name="welcomemessage" cols="100%" rows="7"><?php echo get_option('welcomemessage'); ?></textarea></p>

    <p><strong>Image Uploader</strong><br />
    <input id="featured_img" type="text" name="featured_image" value="<?php echo get_option('featured_image'); ?>" />
    <input id="upload_image_button" type="button" class="button-primary" value="Insert Image" />
    <div class="img_wrap">
      <img src="<?php echo get_option('featured_image'); ?>" id="uploaded_img">
    </div>

    <p><input type="submit" name="Submit" value="Update Options" /></p>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="myname,amazonid,todaysite,welcomemessage,featured_image" />

    </form>
    </div>
    <?php
}



    function media_uploader_enqueue() {
        wp_enqueue_media();
        wp_register_script('cg-options', plugin_dir_url( __FILE__ ) . 'js/media-uploader.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('cg-options');
    }
    add_action('admin_enqueue_scripts', 'media_uploader_enqueue');
?>