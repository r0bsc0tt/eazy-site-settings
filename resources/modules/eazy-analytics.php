<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}


  // Add eazy analytics section to general options page
  add_action( 'admin_init', 'eazy_analytics_settings_init' );
  function eazy_analytics_settings_init() {
    // Add the section
    add_settings_section(
      'eazy_analytics',
      __('Eazy Analytics Settings', 'ez-site-settings'),
      'eazy_analytics_main_callback',
      'eazy-site-settings'
    );
    
    // Add the field for X-Frame
    add_settings_field(
      'eazy_analytics_code',
      __('Google Analytics', 'ez-site-settings'),
      'eazy_analytics_callback',
      'eazy-site-settings',
      'eazy_analytics'
    );
    

    // Register the settings
    register_setting( 'eazy-site-settings', 'eazy_analytics_code' );  
  } 

function eazy_analytics_main_callback() {
  _e('Insert your Google Analytics Javascript tracking code in the field below.');
}

// analytics callback
function eazy_analytics_callback() {
_e('<input name="eazy_analytics_code" id="eazy_analytics_code" type="textarea" value="'.get_option( 'eazy_analytics_code' ).'" class="code"  /> ', 'ez-site-settings');
}

function eazy_analytics_script() {?>
<script type="text/javascript"><?php _e(get_option( 'eazy_analytics_code' )); ?></script>
<?php }

if (get_option( 'eazy_analytics_code' ) !== '' || NULL) {
  add_action( 'wp_footer', 'eazy_analytics_script', 50 );
}
