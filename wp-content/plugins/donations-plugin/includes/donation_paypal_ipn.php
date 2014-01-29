<?php

class Donation_Plugin_PayPal_IPN{

	public $currency_code;
	public $platform;
	public $email;

	function __construct( $do_start = false ) {

		$options = Donation_Plugin_Settings::options();

		$this->currency_code = $options['paypal_currency'];	
		$this->platform = $options['paypal_platform'];
		$this->email = $options['paypal_email'];
		
		if ( $do_start )
			$this->start();

	}

	public function start() {

		$this->hooks();
		$this->filters();

	}

	function hooks() {

		add_action( 'wp_ajax_nopriv_donation_paypal_ipn', array( $this, 'process_ipn' ) );
		add_action( 'wp_ajax_donation_paypal_ipn', array( $this, 'process_ipn' ) );

	}

	function filters() {


	}

	function process_ipn() {

		$listener = $this->setup_ipn_listener();

		$donation_id = $this->validate_ipn( $listener );

		if ( ! $donation_id ) exit(0);

		$donations = get_post_meta( $donation_id, 'donations', true );

		if ( ! is_array( $donations ) )
			$donations = array();

		$donations[] = $_POST;

		update_post_meta( $donation_id, 'donations', $donations );


		exit(0);
	}

	function setup_ipn_listener() {

		muneeb_donation_plugin_include('ipnlistener.php');

		$listener = new IpnListener();

		if ( $this->platform == 'sandbox' )
			$listener->use_sandbox = true;
		else
			$listener->use_sandbox = false;

		if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
			$listener->use_curl = false;
		else
			$listener->use_curl = true;

		return $listener;
	}

	function validate_ipn( &$listener ) {

		try 
		{
			$listener->requirePostMethod();
			$verified = $listener->processIpn();
		} 
		catch ( Exception $e )
		{
			exit(0);
		}

		if ( ! $verified ) exit(0);

		if ( $_POST['payment_status'] == 'Completed' || $_POST['payment_status'] == 'Pending' ) {

			$donation_id = $_POST['item_number'];
			//$donation_info = get_post_meta( $donation_id, 'donation_info', true );

			if ( $_POST['receiver_email'] == $this->email ) {
				if ( $_POST['mc_currency'] == $this->currency_code )
					return $donation_id;
			}

		}
		

		return false;

	}

}

?>