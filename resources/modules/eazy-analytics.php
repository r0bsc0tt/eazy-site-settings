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
    
    // Add the field for the analytics code
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
  _e('<p class="eazy-site-settings-section-descrip">Insert your Google Analytics Tracking ID in the field below.</p>');
  _e('<p class="eazy-site-settings-section-descrip">The Tracking ID format should be similar to UA-12345678-1</p>');
}

// analytics callback
function eazy_analytics_callback() {
  _e('<input name="eazy_analytics_code" id="eazy_analytics_code" type="textarea" value="'.get_option( 'eazy_analytics_code' ).'" class="code"  /> ', 'ez-site-settings');
}

function eazy_analytics_script() {?>
<script src="https://cdn.jsdelivr.net/ga-lite/latest/ga-lite.min.js" async></script>
<script>var galite = galite || {}; galite.UA = '<?php _e(get_option( 'eazy_analytics_code' )); ?>';</script>

<?php }

if (get_option( 'eazy_analytics_code' ) !== '' || NULL) {
  add_action( 'wp_footer', 'eazy_analytics_script', 50 );
}
