<?php 

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

  // Add eazy emoji settings section to options page
  add_action( 'admin_init', 'eazy_emoji_settings_init' );
  function eazy_emoji_settings_init() {
    // Add the section
    add_settings_section(
      'eazy_emoji_settings',
      __('Eazy Emoji Settings', 'ez-site-settings'),
      'eazy_emoji_settings_callback_function',
      'eazy-site-settings'
    );
    
    // Add the field for removing emoji support
    add_settings_field(
      'eazy_emoji_checkbox',
      __('Remove WP Emoji Support', 'ez-site-settings'),
      'eazy_emoji_callback',
      'eazy-site-settings',
      'eazy_emoji_settings'
    );

    // Register the settings
    register_setting( 'eazy-site-settings', 'eazy_emoji_checkbox' );
  
  }

  // eazy emoji section callback
  function eazy_emoji_settings_callback_function() {
    _e('<p class="eazy-site-settings-section-descrip">You can remove WP Emoji support if your site does not use it to remove the css & js it adds to head.</p>', 'ez-site-settings');
  }

  // Eazy Emoji callback
  function eazy_emoji_callback() {
    _e('<input name="eazy_emoji_checkbox" id="eazy_emoji_checkbox" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eazy_emoji_checkbox' ), false ) . ' /> ', 'ez-site-settings');
  }



//remove emoji from head
if (get_option( 'eazy_emoji_checkbox' ) === '1') {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
