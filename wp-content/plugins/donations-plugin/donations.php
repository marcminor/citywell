<?php
/*
Plugin Name: WP Donations
Plugin URI: http://www.tipsandtricks-hq.com/development-center
Description: Accept donation for a cause from your WordPress powered site.
Version: 1.1
Author: Tips and Tricks HQ
Author URI: http://www.tipsandtricks-hq.com/
License: GPL2
*/

define( 'DONATION_PLUGIN_NAME', 'WP Donations Plugin' );
define( 'DONATION_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'DONATION_PLUGIN_DIR_NAME', dirname( plugin_basename( __FILE__ ) ) );
define( 'DONATION_PLUGIN_CUSTOM_POST_TYPE', 'donation' );
define( 'DONATION_PLUGIN_VIEW_DIRECTORY', 'views' );
define( 'DONATION_PLUGIN_INCLUDE_DIRECTORY', 'includes' );
define( 'DONATION_PLUGIN_CAPABILITY', 'manage_options' );
define( 'DONATION_PLUGIN_TEXT_DOMAIN', 'donation-plugin' );
define( 'DONATION_PLUGIN_SHORTCODE', 'donation' );
define( 'DONATION_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'DONATION_PLUGIN_OPTIONS_ARRAY_NAME', 'donation_plugin_options' );

require_once (DONATION_PLUGIN_PATH . DONATION_PLUGIN_INCLUDE_DIRECTORY . DIRECTORY_SEPARATOR . 'functions.php');
muneeb_load_donation_plugin();
