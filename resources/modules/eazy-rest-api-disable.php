<?php 

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}




  // Add eazy rest_api settings section to options page
  add_action( 'admin_init', 'eazy_rest_api_settings_init' );
  function eazy_rest_api_settings_init() {
    // Add the section
    add_settings_section(
      'eazy_rest_api_settings',
      __('Eazy REST API Settings', 'ez-site-settings'),
      'eazy_rest_api_settings_callback_function',
      'eazy-site-settings'
    );

    // Add the field to remove rest_api
    add_settings_field(
      'eazy_rest_api_remove_checkbox',
      __('Disable REST API', 'ez-site-settings'),
      'eazy_rest_api_remove_callback',
      'eazy-site-settings',
      'eazy_rest_api_settings'
    );

    // Register the setting
    register_setting( 'eazy-site-settings', 'eazy_rest_api_remove_checkbox' );
  
  }


  // eazy rest_api section callback
  function eazy_rest_api_settings_callback_function() {
    _e('<p class="eazy-site-settings-section-descrip">This option will forcibly return an authentication error to any API requests from sources who are not logged into your website.</p>', 'ez-site-settings');
  }
  
    // Eazy rest_api callback
  function eazy_rest_api_remove_callback() {
    _e('<input name="eazy_rest_api_remove_checkbox" id="eazy_rest_api_remove_checkbox" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_rest_api_remove_checkbox' ), false ) . ' /> ', 'ez-site-settings');
  }





  
//if remove rest_api checkbox is checked, set rest_api to return false
if (get_option( 'eazy_rest_api_remove_checkbox' ) === '1') {


    add_filter( 'rest_authentication_errors', 'eazy_rest_api_authentication_error' );
    function eazy_rest_api_authentication_error() {
     return new WP_Error( 'rest_cannot_access', __( 'REST API not authorized with Eazy Site Settings.', 'disable-json-api' ), array( 'status' => rest_authorization_required_code() ) );
    }



}