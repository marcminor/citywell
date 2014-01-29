<?php

class Donation_Plugin_Settings{

	private $options;

	function __construct( $do_start = false ) {

		$this->setup_options();
		
		if ( $do_start )
			$this->start();

	}

	function start() {

		$this->hooks();
		$this->filters();

	}

	function hooks() {

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

	}

	function filters() {


	}

	function get_default_options() {

		$options = array(
				'paypal_email' => 'example@example.com',
				'paypal_currency' => 'USD',
				'paypal_platform' => 'sandbox'
			);

		return $options;

	}

	function setup_options() {

		$options = get_option( DONATION_PLUGIN_OPTIONS_ARRAY_NAME );

		if ( ! $options )
			add_option( DONATION_PLUGIN_OPTIONS_ARRAY_NAME , $this->get_default_options(), '', 'yes');

		$this->options = $options;

	}

	function add_admin_menu() {

		$parent_menu_slug = 'edit.php?post_type=' . DONATION_PLUGIN_CUSTOM_POST_TYPE;
		$menu_slug = 'donation_settings_page';

		add_submenu_page( $parent_menu_slug, 
			__( 'Donation Settings', DONATION_PLUGIN_TEXT_DOMAIN ),
			__( 'Settings', DONATION_PLUGIN_TEXT_DOMAIN ),
			DONATION_PLUGIN_CAPABILITY,
			$menu_slug,
			array( $this, 'settings_page' )
			 );

	}

	function settings_page() {

		$show_settings_updated_notice = false;
		$currencies = $this->currencies();
		$nonce = wp_create_nonce('donation_settings_page');
		$options = $this->options;

		if ( isset( $_POST['submit'] ) ) {
			$options = $this->save_settings( $options );
			$show_settings_updated_notice = true;
		}

		extract( $options );

		include muneeb_donation_plugin_view_path(__FUNCTION__);

	}

	function save_settings( $options ) {

		extract( $_POST );

		if ( ! current_user_can( DONATION_PLUGIN_CAPABILITY ) )
			return;

		if ( ! wp_verify_nonce( $nonce , 'donation_settings_page' ) ) 
			return;

		$options['paypal_email'] = $paypal_email;
		$options['paypal_platform'] = $paypal_platform;
		$options['paypal_currency'] = $paypal_currency;

		update_option( DONATION_PLUGIN_OPTIONS_ARRAY_NAME , $options);

		return $options;
	}

	function currencies(){
	return array('USD' => array('title' => 'U.S. Dollar', 'code' => 'USD', 'symbol_left' => '$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'EUR' => array('title' => 'Euro', 'code' => 'EUR', 'symbol_left' => '', 'symbol_right' => '€', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'JPY' => array('title' => 'Japanese Yen', 'code' => 'JPY', 'symbol_left' => '¥', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'GBP' => array('title' => 'Pounds Sterling', 'code' => 'GBP', 'symbol_left' => '£', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'CHF' => array('title' => 'Swiss Franc', 'code' => 'CHF', 'symbol_left' => '', 'symbol_right' => 'CHF', 'decimal_point' => ',', 'thousands_point' => '.', 'decimal_places' => '2'),
                           'AUS' => array('title' => 'Australian Dollar', 'code' => 'AUS', 'symbol_left' => '$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'CAD' => array('title' => 'Canadian Dollar', 'code' => 'CAD', 'symbol_left' => '$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'SEK' => array('title' => 'Swedish Krona', 'code' => 'SEK', 'symbol_left' => '', 'symbol_right' => 'kr', 'decimal_point' => ',', 'thousands_point' => '.', 'decimal_places' => '2'),
                           'HKD' => array('title' => 'Hong Kong Dollar', 'code' => 'HKD', 'symbol_left' => '$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'NOK' => array('title' => 'Norwegian Krone', 'code' => 'NOK', 'symbol_left' => 'kr', 'symbol_right' => '', 'decimal_point' => ',', 'thousands_point' => '.', 'decimal_places' => '2'),
                           'NZD' => array('title' => 'New Zealand Dollar', 'code' => 'NZD', 'symbol_left' => '$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'MXN' => array('title' => 'Mexican Peso', 'code' => 'MXN', 'symbol_left' => '$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'SGD' => array('title' => 'Singapore Dollar', 'code' => 'SGD', 'symbol_left' => '$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'BRL' => array('title' => 'Brazilian Real', 'code' => 'BRL', 'symbol_left' => 'R$', 'symbol_right' => '', 'decimal_point' => ',', 'thousands_point' => '.', 'decimal_places' => '2'),
                           'CNY' => array('title' => 'Chinese RMB', 'code' => 'CNY', 'symbol_left' => '￥', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'CZK' => array('title' => 'Czech Koruna', 'code' => 'CZK', 'symbol_left' => '', 'symbol_right' => 'Kč', 'decimal_point' => ',', 'thousands_point' => '.', 'decimal_places' => '2'),
                           'DKK' => array('title' => 'Danish Krone', 'code' => 'DKK', 'symbol_left' => '', 'symbol_right' => 'kr', 'decimal_point' => ',', 'thousands_point' => '.', 'decimal_places' => '2'),
                           'HUF' => array('title' => 'Hungarian Forint', 'code' => 'HUF', 'symbol_left' => '', 'symbol_right' => 'Ft', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'ILS' => array('title' => 'Israeli New Shekel', 'code' => 'ILS', 'symbol_left' => '₪', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'INR' => array('title' => 'Indian Rupee', 'code' => 'INR', 'symbol_left' => 'Rs.', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'MYR' => array('title' => 'Malaysian Ringgit', 'code' => 'MYR', 'symbol_left' => 'RM', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'PHP' => array('title' => 'Philippine Peso', 'code' => 'PHP', 'symbol_left' => 'Php', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'PLN' => array('title' => 'Polish Zloty', 'code' => 'PLN', 'symbol_left' => '', 'symbol_right' => 'zł', 'decimal_point' => ',', 'thousands_point' => '.', 'decimal_places' => '2'),
                           'THB' => array('title' => 'Thai Baht', 'code' => 'THB', 'symbol_left' => '', 'symbol_right' => '฿', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'),
                           'TWD' => array('title' => 'Taiwan New Dollar', 'code' => 'TWD', 'symbol_left' => 'NT$', 'symbol_right' => '', 'decimal_point' => '.', 'thousands_point' => ',', 'decimal_places' => '2'));
	}

	public static function currency_ascii_code( $currency_code ) {

		$currencies = self::currencies();

		if ( empty( $currencies[$currency_code]['symbol_left'] ) )
			return $currencies[$currency_code]['symbol_right'];

		return $currencies[$currency_code]['symbol_left'];

	}

	public static function options() {
		return get_option( DONATION_PLUGIN_OPTIONS_ARRAY_NAME );
	}
}

?>