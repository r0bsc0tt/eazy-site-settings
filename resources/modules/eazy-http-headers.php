<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

  // Add eazy http settings section to general options page
  add_action( 'admin_init', 'eazy_httphead_settings_init' );
  function eazy_httphead_settings_init() {
    // Add the section
    add_settings_section(
      'eazy_http_settings',
      __('Eazy HTTP Headers Settings', 'ez-site-settings'),
      'eazy_httphead_settings_callback_function',
      'eazy-site-settings'
    );
    
    // Add the field for X-Frame
    add_settings_field(
      'eazyHTTPhead_checkbox_frame',
      __('X-Frame-Options', 'ez-site-settings'),
      'eazy_httphead_frame_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );
    
    // Add the field for X-XSS Protection
    add_settings_field(
      'eazyHTTPhead_checkbox_xss',
      __('X-XSS-Protection', 'ez-site-settings'),
      'eazy_httphead_xss_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );

    //add the field for NoSniff
    add_settings_field(
      'eazyHTTPhead_checkbox_nosniff',
      __('X-Content-Type-Options', 'ez-site-settings'),
      'eazy_httphead_nosniff_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );

    // Register the settings
    register_setting( 'eazy-site-settings', 'eazy_httphead_checkbox_frame' );
    register_setting( 'eazy-site-settings', 'eazy_httphead_checkbox_xss' );  
    register_setting( 'eazy-site-settings', 'eazy_httphead_checkbox_nosniff' );  

  } 
   

 
  
  // Settings section callback
  function eazy_httphead_settings_callback_function() {
    _e('<p>Set your HTTP headers to secure your site.</p>', 'ez-site-settings');
  }

  // X-Frame callback
  function eazy_httphead_frame_callback() {
    _e('<input name="eazy_httphead_checkbox_frame" id="eazy_httphead_checkbox_frame" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_httphead_checkbox_frame' ), false ) . ' /> "SAMEORIGIN"', 'ez-site-settings');
  }

  // X-XSS callback
  function eazy_httphead_xss_callback() {
    _e('<input name="eazy_httphead_checkbox_xss" id="eazy_httphead_checkbox_xss" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_httphead_checkbox_xss' ), false ) . ' /> "1; mode=block;"', 'ez-site-settings');
  }

  // nosniff callback
  function eazy_httphead_nosniff_callback() {
    _e('<input name="eazy_httphead_checkbox_nosniff" id="eazy_httphead_checkbox_nosniff" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_httphead_checkbox_nosniff' ), false ) . ' /> "nosniff"', 'ez-site-settings');
  }
 


  // send headers with options if option checkbox is checked
  add_action('send_headers','eazy_http_header',1);
  function eazy_http_header() {
    
    //if x-frame checkbox is checked use WP x-frame options header
    if (get_option( 'eazy_httphead_checkbox_frame' ) === '1') {
      send_frame_options_header();
    }

    //if X-XSS protection checkbox is checked set X-XSS-Protection header
    if (get_option( 'eazy_httphead_checkbox_xss' ) === '1') {
      header("X-XSS-Protection: 1; mode=block;");
    }  

    //if 'X-Content-Type checkbox is checked use WP nosniff header
    if (get_option( 'eazy_httphead_checkbox_nosniff' ) === '1') {
      send_nosniff_header();
    }

  }
