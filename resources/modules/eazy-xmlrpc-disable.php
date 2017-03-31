<?php 

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

  // Add eazy xmlrpc settings section to options page
  add_action( 'admin_init', 'eazy_xmlrpc_settings_init' );
  function eazy_xmlrpc_settings_init() {
    // Add the section
    add_settings_section(
      'eazy_xmlrpc_settings',
      __('Eazy XMLRPC Settings', 'ez-site-settings'),
      'eazy_xmlrpc_settings_callback_function',
      'eazy-site-settings'
    );
    
    // Add the field to disable xmlrpc pingback
    add_settings_field(
      'eazy_xmlrpc_pingback_checkbox',
      __('pingback.ping & pingback.extensions.getPingbacks', 'ez-site-settings'),
      'eazy_xmlrpc_ping_callback',
      'eazy-site-settings',
      'eazy_xmlrpc_settings'
    );

    // Add the field to remove xmlrpc
    add_settings_field(
      'eazy_xmlrpc_remove_checkbox',
      __('Disable All XMLRPC', 'ez-site-settings'),
      'eazy_xmlrpc_remove_callback',
      'eazy-site-settings',
      'eazy_xmlrpc_settings'
    );

    // Register the setting
    register_setting( 'eazy-site-settings', 'eazy_xmlrpc_pingback_checkbox' );
    register_setting( 'eazy-site-settings', 'eazy_xmlrpc_remove_checkbox' );
  
  }

  // eazy xmlrpc section callback
  function eazy_xmlrpc_settings_callback_function() {
    _e('<p class="eazy-site-settings-section-descrip">You can disable XMLRPC completely or just disable pingback.ping & pingback.extensions.getPingbacks.</p>', 'ez-site-settings');
  }

  // Eazy XMLRPC callback
  function eazy_xmlrpc_ping_callback() {
    _e('<input name="eazy_xmlrpc_pingback_checkbox" id="eazy_xmlrpc_pingback_checkbox" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_xmlrpc_pingback_checkbox' ), false ) . ' /> ', 'ez-site-settings');
  }

  // Eazy XMLRPC callback
  function eazy_xmlrpc_remove_callback() {
    _e('<input name="eazy_xmlrpc_remove_checkbox" id="eazy_xmlrpc_remove_checkbox" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_xmlrpc_remove_checkbox' ), false ) . ' /> ', 'ez-site-settings');
  }


//if XMLRPC checkbox is checked unset pingback methods
if (get_option( 'eazy_xmlrpc_pingback_checkbox' ) === '1') {
  add_filter( 'xmlrpc_methods', 'eazy_xmlrpc_ping_disable' );
  function eazy_xmlrpc_ping_disable( $methods ) {
     unset( $methods['pingback.ping'] );
     unset( $methods['pingback.extensions.getPingbacks'] );
     return $methods;
  } ;
}
//if remove XMLRPC checkbox is checked, set xmlrpc to return false
if (get_option( 'eazy_xmlrpc_remove_checkbox' ) === '1') {
  add_filter('xmlrpc_enabled', '__return_false');
}