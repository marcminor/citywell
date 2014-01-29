<?php
// Include SD Frameworks
// ----------------------------------------------------------------------

// Localization Functionality
add_action('after_setup_theme', 'theme_load_textdomain');

function theme_load_textdomain(){
	$path = get_template_directory() . '/languages';
	$loaded = load_theme_textdomain('savior',  $path);
}

// WooCommerce!
add_theme_support( 'woocommerce' );

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
 
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}

// Event Plugin
require('_theme_settings/plugins/ajax-event-calendar/ajax-event-calendar.php');

// Initial Load
require('_framework/init.php');

// Add theme support for post thumbnails & post formats
require('_theme_settings/add-theme-support.php');

// Include Custom Theme Settings/Options
require('_theme_settings/theme-options.php');

// Register Post Types
require('_theme_settings/post-types/init.php');

// Register Sidebars
require('_theme_settings/register-sidebars.php');

// Register widgets
require('_theme_settings/widgets/init.php');

// Theme related functions
require('_theme_settings/theme-functions.php');

// Set up custom meta fields
require('_theme_settings/custom-fields/init.php');

// Shortcodes
require('_theme_settings/theme-shortcodes.php');

// Page part functions
require('_theme_settings/page-parts.php');

add_action('admin_init', 'sav_add_custom_editor_caps');
function sav_add_custom_editor_caps() {

	$role = get_role('editor');
	$role->add_cap('aec_add_events');
	$role->add_cap('aec_manage_events');
	$role->add_cap('aec_manage_calendar');
	
	$role = get_role('calendar_contributor');
	if (is_object($role)):
		$role->add_cap('aec_add_events');
		$role->add_cap('aec_manage_events');
		$role->add_cap('aec_manage_calendar');
	endif;
	
	$role = get_role('author');
	$role->add_cap('aec_add_events');
	$role->add_cap('aec_manage_events');
	$role->add_cap('aec_manage_calendar');
	
}

?>