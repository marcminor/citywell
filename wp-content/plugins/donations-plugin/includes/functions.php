<?php

function muneeb_load_donation_plugin() {

	muneeb_load_donation_plugin_files();

	if ( is_admin() )
		new Donation_Plugin_Custom_Post_Type(true);

	muneeb_register_donation_shortcode();
	new Donation_Plugin_PayPal_IPN(true);
	new Donation_Plugin_Settings(true);
	
}

function muneeb_load_donation_plugin_files() {
	muneeb_donation_plugin_include( 'donation_custom_post_type.php' );
	muneeb_donation_plugin_include( 'donation_paypal_ipn.php' );
	muneeb_donation_plugin_include( 'donation_shortcode.php' );
	muneeb_donation_plugin_include( 'settings.php' );
}

function muneeb_donation_plugin_view_path( $view_name, $is_php = true ) {

	if ( strpos( $view_name, '.php' ) === FALSE && $is_php )
		$view_name = $view_name . '.php';

	$path = DONATION_PLUGIN_PATH . DONATION_PLUGIN_VIEW_DIRECTORY
								 . DIRECTORY_SEPARATOR . $view_name;

	return $path;
}

function muneeb_donation_plugin_include( $file_name, $require = true ) {

	$path = DONATION_PLUGIN_PATH . DONATION_PLUGIN_INCLUDE_DIRECTORY
								 . DIRECTORY_SEPARATOR . $file_name;

	if ( $require ) 
		require $path;
	else
		include $path;

}
