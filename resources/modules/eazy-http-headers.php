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
      'eazy_httphead_checkbox_frame',
      __('X-Frame-Options', 'ez-site-settings'),
      'eazy_httphead_frame_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );
    
    // Add the field for X-XSS Protection
    add_settings_field(
      'eazy_httphead_checkbox_xss',
      __('X-XSS-Protection', 'ez-site-settings'),
      'eazy_httphead_xss_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );

    //add the field for NoSniff
    add_settings_field(
      'eazy_httphead_checkbox_nosniff',
      __('X-Content-Type-Options', 'ez-site-settings'),
      'eazy_httphead_nosniff_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );

    //add the field for Strict Transport Security
    add_settings_field(
      'eazy_httphead_checkbox_strict_transport_security',
      __('Strict-Transport-Security', 'ez-site-settings'),
      'eazy_httphead_strict_transport_security_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );

    //add the field for Referrer Policy
    add_settings_field(
      'eazy_httphead_referrer_policy',
      __('Referrer Policy', 'ez-site-settings'),
      'eazy_httphead_referrer_policy_callback',
      'eazy-site-settings',
      'eazy_http_settings'
    );


    // Register the settings
    register_setting( 'eazy-site-settings', 'eazy_httphead_checkbox_frame' );
    register_setting( 'eazy-site-settings', 'eazy_httphead_checkbox_xss' );  
    register_setting( 'eazy-site-settings', 'eazy_httphead_checkbox_nosniff' );  
    register_setting( 'eazy-site-settings', 'eazy_httphead_checkbox_strict_transport_security' );
    register_setting( 'eazy-site-settings', 'eazy_httphead_referrer_policy' );  
  } 
   

 
  
  // Settings section callback
  function eazy_httphead_settings_callback_function() {
    _e('<p class="eazy-site-settings-section-descrip">Set your HTTP headers to secure your site.</p>', 'ez-site-settings');
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
 
  // strict transport security callback
  function eazy_httphead_strict_transport_security_callback() {
    _e('<input name="eazy_httphead_checkbox_strict_transport_security" id="eazy_httphead_checkbox_strict_transport_security" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_httphead_checkbox_strict_transport_security' ), false ) . ' /> "strict-transport-security: max-age=31536000; includeSubDomains"', 'ez-site-settings');
  }
 
  // Referrer Policy Callback 
  function eazy_httphead_referrer_policy_callback() {
      $options = get_option('eazy_httphead_referrer_policy');
      $items = array("","no-referrer","no-referrer-when-downgrade","same-origin","origin","strict-origin","origin-when-cross-origin","strict-origin-when-cross-origin","unsafe-url");
      echo "<select id='eazy_httphead_referrer_policy' name='eazy_httphead_referrer_policy'>";
      foreach($items as $item) {
        $selected = ($options==$item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
      }
      echo "</select>";
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
      header("Referrer-Policy: no-referrer");
    }  

    //if 'X-Content-Type checkbox is checked use WP nosniff header
    if (get_option( 'eazy_httphead_checkbox_nosniff' ) === '1') {
      send_nosniff_header();
    }

    //if 'X-Content-Type checkbox is checked use WP nosniff header
    if (get_option( 'eazy_httphead_checkbox_strict_transport_security' ) === '1') {
      header("strict-transport-security: max-age=31536000; includeSubDomains");
    }

    //if referrer policy is set output it to header
    if ( get_option('eazy_httphead_referrer_policy') == 'no-referrer' ) {
          header("Referrer-Policy: no-referrer");
    } 
    if ( get_option('eazy_httphead_referrer_policy') == 'no-referrer-when-downgrade') {
          header("Referrer-Policy: no-referrer-when-downgrade");
    }
    if ( get_option('eazy_httphead_referrer_policy') == 'same-origin') {
          header("Referrer-Policy: same-origin");
    }
    if ( get_option('eazy_httphead_referrer_policy') == 'origin') {
          header("Referrer-Policy: origin");
    }
    if ( get_option('eazy_httphead_referrer_policy') == 'strict-origin') {
          header("Referrer-Policy: strict-origin");
    }
    if ( get_option('eazy_httphead_referrer_policy') == 'origin-when-cross-origin') {
          header("Referrer-Policy: origin-when-cross-origin");
    }
    if ( get_option('eazy_httphead_referrer_policy') == 'strict-origin-when-cross-origin') {
          header("Referrer-Policy: strict-origin-when-cross-origin");
    }
    if ( get_option('eazy_httphead_referrer_policy') == 'unsafe-url') {
          header("Referrer-Policy: unsafe-url");
    }                    

  }
