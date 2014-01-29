<?php

function muneeb_register_donation_shortcode() {
	add_shortcode( DONATION_PLUGIN_SHORTCODE , 'muneeb_donation_shortcode' );
}

function muneeb_donation_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( 
		array( 
			'id' => null,
			'skin' => 'pie',
			'pie_width' => 250,
			'pie_height' => 120,
			'pie_show_labels' => true,
			'button_image_url' => null,
		), 
		$atts ));
	
	$donation_id = $id;

	if ( ! $donation_id || get_post_status( $donation_id ) !== 'publish' ) 
		echo __( 'Invalid donation ID or donation does not exist/not-published.', DONATION_PLUGIN_TEXT_DOMAIN ) ;

	$donation_info = get_post_meta( $donation_id, 'donation_info', true );

	$donation_goal = $donation_info['donation_goal'];

	$money_raised = muneeb_donation_plugin_money_raised( $donation_id );

	$donate_now_url = muneeb_donation_plugin_donate_button_url( $donation_id );

	$options = Donation_Plugin_Settings::options();

	$unit = Donation_Plugin_Settings::currency_ascii_code( $options['paypal_currency'] );

	$donation_goal = urlencode( $donation_goal );
	$money_raised = urlencode( $money_raised );
	$unit = urlencode( $unit );

	if ( ! extension_loaded( 'gd' ) && ! function_exists( 'gd_info' ) )
		$skin = 'pie';

	if ( $skin == 'meter' )
		$meter_url = plugins_url( "/phpfundthermo/thermo.php?max={$donation_goal}&current={$money_raised}&unit={$unit}", __FILE__ );

	if ( $skin == 'pie' ) {

		$chdl = '';
		$chtt = '';

		if ( $pie_show_labels === true ) {
			$chdl = __( "&chdl=Total {$unit}{$donation_goal}|Money+Raised {$unit}{$money_raised}", DONATION_PLUGIN_TEXT_DOMAIN );
			//$chtt = __( 'Donations', DONATION_PLUGIN_TEXT_DOMAIN );
		}


		$meter_url = "http://chart.googleapis.com/chart?chf=a,s,000000&chs={$pie_width}x{$pie_height}&cht=p3&chd=t:{$donation_goal},{$money_raised}&chtt={$chtt}&{$chdl}";
	}

	if ( ! $button_image_url )
		$button_image_url = plugins_url( '/images/btn_donateCC_LG.gif' , dirname(__FILE__)  );
	
	if ( ! defined( 'DONATION_PLUGIN_PROCESS_VIEW' ) )
		define( 'DONATION_PLUGIN_PROCESS_VIEW', true );

	ob_start();

	include muneeb_donation_plugin_view_path( 'donation_shortcode' );

	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function muneeb_donation_plugin_money_raised( $donation_id ) {

	$donations = get_post_meta( $donation_id, 'donations', true );

	$money_raised = 0;

	if ( empty( $donations ) ) return $money_raised;

	foreach ($donations as $donation) {
		$money_raised += (float)$donation['mc_gross'];
	}

	return $money_raised;
}

function muneeb_donation_plugin_donate_button_url( $donation_id ) {

	$options = Donation_Plugin_Settings::options();
	$platform = $options['paypal_platform'];
	$currency_code = $options['paypal_currency'];
	$email = $options['paypal_email'];

	$donation_info = get_post_meta( $donation_id, 'donation_info', true );
	$donation_purpose = $donation_info['donation_purpose'];
	
	$notify_url = admin_url('admin-ajax.php').'?action=donation_paypal_ipn';

	if ( $platform == 'sandbox' )
		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
	else
		$url = 'https://www.paypal.com/cgi-bin/webscr?';

	$donation_purpose = substr( $donation_purpose , 0, 150 );
	
	$parameters = array(
			'currency_code' => $currency_code,
			'cmd' => '_donations',
			'business' => $email,
			'receiver_email' => $email,
			'item_name' => $donation_purpose,
			'item_number' => (int)$donation_id,
			'notify_url' => $notify_url
		);

	$parameters = http_build_query($parameters);
	$url = $url . $parameters;

	return $url;
}

?>