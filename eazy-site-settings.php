<?php
/*
Plugin Name: Eazy Site Settings
Plugin URI: http://robjscott.com/wordpress/plugins/eazy-site-settings
Description: create a settings page to control included options 
Version: 1.0.0
Author: Rob Scott, LLC
Author URI: http://robjscott.com
Text Domain: ez-site-settings
License: GPLv2 or any later version
License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

// add modules
require_once(plugin_dir_path(__FILE__).'resources/modules/eazy-http-headers.php');
require_once(plugin_dir_path(__FILE__).'resources/modules/eazy-remove-emoji.php');
require_once(plugin_dir_path(__FILE__).'resources/modules/eazy-xmlrpc-disable.php');
require_once(plugin_dir_path(__FILE__).'resources/modules/eazy-login-logo.php');
require_once(plugin_dir_path(__FILE__).'resources/modules/eazy-analytics.php');
require_once(plugin_dir_path(__FILE__).'resources/modules/eazy-rest-api-disable.php');


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

// modified settings output to wrap sections in divs on settings page callback
function eazy_site_settings_sections( $page ) {
    global $wp_settings_sections, $wp_settings_fields;
 
    if ( ! isset( $wp_settings_sections[$page] ) )
        return;
 
    foreach ( (array) $wp_settings_sections[$page] as $section ) {
       $current_title = strtolower($section['title']);
       $cleaned_title = preg_replace("/[\s_]/", "-", $current_title);

      echo "<div id='".$cleaned_title."' class='eazy-site-settings-section'>";

        if ( $section['title'] )
            echo "<h2 class='eazy-site-settings-section-title'>{$section['title']}</h2>\n";
 
        if ( $section['callback'] )
            call_user_func( $section['callback'], $section );
 
        if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) )
            continue;
        echo '<table class="form-table">';
        do_settings_fields( $page, $section['id'] );
        echo '</table>';

      echo "</div>";
    }
}


//settings page callback
function eazy_site_settings_page() { ?>
  <div class="wrap">
    <h2 id="eazy-site-settings-title">Eazy Site Settings</h2>
    <form method="post" action="options.php">
      <?php settings_fields( 'eazy-site-settings' ); ?>
      <?php eazy_site_settings_sections('eazy-site-settings'); ?>
      <?php submit_button(); ?>
    </form>
  </div><?php
}



//admin css
add_action( 'admin_enqueue_scripts', 'load_eazy_site_settings_admin_style' );
function load_eazy_site_settings_admin_style($hook) {
        // Load only on ?page=mypluginname
        if($hook != 'settings_page_eazy-site-settings') {
            return;
        }
        wp_enqueue_style( 'custom_wp_admin_css', plugins_url('resources/css/admin-style.css', __FILE__) );
}
