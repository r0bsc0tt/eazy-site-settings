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

//add settings
require_once(plugin_dir_path(__FILE__).'resources/eazy-site-settings-option-page.php');
