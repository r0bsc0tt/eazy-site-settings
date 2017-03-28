<?php 

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

  // Add eazy login logo settings section to options page
  add_action( 'admin_init', 'eazy_login_logo_settings_init' );
  function eazy_login_logo_settings_init() {
    // Add the section
    add_settings_section(
      'eazy_login_logo_settings',
      __('Eazy Login Logo Settings', 'ez-site-settings'),
      'eazy_login_logo_settings_callback_function',
      'eazy-site-settings'
    );
    
    // Add the field to disable login logo pingback
    add_settings_field(
      'eazy_login_logo_checkbox',
      __('Add a logo to the admin login screen', 'ez-site-settings'),
      'eazy_login_logo_callback',
      'eazy-site-settings',
      'eazy_login_logo_settings'
    );
    // Add the field to disable login logo pingback
    add_settings_field(
      'eazy_login_logo_image',
      __('Select image', 'ez-site-settings'),
      'eazy_login_logo_image_callback',
      'eazy-site-settings',
      'eazy_login_logo_settings'
    );

    // Register the setting
    register_setting( 'eazy-site-settings', 'eazy_login_logo_checkbox' );
    register_setting( 'eazy-site-settings', 'eazy_login_logo_image' );
    register_setting( 'eazy-site-settings', 'eazy_login_logo_image_url' );
  }


  // eazy login logo section callback
  function eazy_login_logo_settings_callback_function() {
    _e('<p>You can add a custom login logo to the wp-admin login screen.</p>', 'ez-site-settings');
  }

  // Eazy Login Logo callback
  function eazy_login_logo_callback() {
    _e('<input name="eazy_login_logo_checkbox" id="eazy_login_logo_checkbox" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_login_logo_checkbox' ), false ) . ' /> ', 'ez-site-settings');
  }
  //image upload callback
  function eazy_login_logo_image_callback() {
    wp_enqueue_media();
    _e('<input type="button" name="eazy_login_logo_image" id="eazy_login_logo_image" class="button-secondary" value="Upload Image"> <input type="text" name="eazy_login_logo_image_url" id="eazy_login_logo_image_url" class="regular-text" '. checked( 1, get_option( 'eazy_login_logo_image_url' ), false ).' >', 'ez-site-settings');
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#eazy_login_logo_image').click(function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Upload Image',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open()
            .on('select', function(e){
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                // Let's assign the url value to the input field
                $('#eazy_login_logo_image_url').val(image_url);
            });
        });
    });

      <?php 
      // if login logo url is set, add it to the url value field
      if (get_option( 'eazy_login_logo_image_url' ) !== '') { ?>
        jQuery(document).ready(function($){
          $('#eazy_login_logo_image_url').val('<?php echo get_option("eazy_login_logo_image_url"); ?>');
        });
      <?php } ?>
      console.log( '<?php print_r(wp_get_attachment_metadata( get_option("eazy_login_logo_image_url") )); ?>' );
    </script> <?php
  }


//if add Login Logo checkbox is checked, make the logo show up on the admin login page
if ( get_option( 'eazy_login_logo_checkbox' ) === '1' && get_option( 'eazy_login_logo_image_url' ) !== '' ) {
    
    // Add Login Logo URL 
    add_filter('login_headerurl', 'eazy_login_logo_url');
    function eazy_login_logo_url() {
      return get_home_url();
    }

    // Add Login Logo Title
    add_filter('login_headertitle', 'eazy_login_logo_title');
    function eazy_login_logo_title() {
      return get_option('blogname');
    }

    // Add Login Logo Image
    add_action( 'login_enqueue_scripts', 'eazy_login_logo' );
    function eazy_login_logo() { 
      //set image sizes array as variable
      $eazy_image_size = getimagesize( get_option("eazy_login_logo_image_url") ); 
      ?>
        <style type="text/css">
            body.login div#login h1 a {
                background-image: url('<?php echo get_option("eazy_login_logo_image_url"); ?>' );
                background-size: <?php echo $eazy_image_size[0] . "px ". $eazy_image_size[1] . "px"; ?>;
                height: <?php echo $eazy_image_size[1]; ?>px;
                width: <?php echo $eazy_image_size[0]; ?>px;
            }
        </style>
    <?php }

}