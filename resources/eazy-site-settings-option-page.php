<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

// add modules
require_once(plugin_dir_path(__FILE__).'modules/eazy-http-headers.php');
require_once(plugin_dir_path(__FILE__).'modules/eazy-remove-emoji.php');
require_once(plugin_dir_path(__FILE__).'modules/eazy-xmlrpc-disable.php');
require_once(plugin_dir_path(__FILE__).'modules/eazy-login-logo.php');
require_once(plugin_dir_path(__FILE__).'modules/eazy-analytics.php');

// add settings page
add_action( 'admin_menu', 'eazy_site_settings' );
function eazy_site_settings() {
  add_options_page( 
    'Eazy Site Settings',
    'Eazy Site Settings',
    'activate_plugins',
    'eazy-site-settings',
    'eazy_site_settings_page'
  );
}

//settings page callback
function eazy_site_settings_page() { ?>
  <div class="wrap">
    <h2>Eazy Site Settings</h2>
    <form method="post" action="options.php">
      <?php settings_fields( 'eazy-site-settings' ); ?>
      <?php do_settings_sections('eazy-site-settings'); ?>
      <?php submit_button(); ?>
    </form>
  </div><?php
}
