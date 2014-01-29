<?php



// ----------------------------------------------------------------------------------------------------
// Shortcode Button/Form

class Custom_Shortcodes_Event
{
	function __construct() {
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}
	
	function action_admin_init() {
		// only hook up these filters if we're in the admin panel, and the current user has permission
		// to edit posts and pages
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons_3', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
		}
	}
	
	function filter_mce_button( $buttons ) {
		array_push( $buttons, '', 'js_event_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['js_event'] = get_template_directory_uri() . '/_theme_settings/shortcodes/event/script.js';
		return $plugins;
	}
}

$event = new Custom_Shortcodes_Event();



// ----------------------------------------------------------------------------------------------------
// Shortcode Display

function js_display_event( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );

	$event_content = '';

	ob_start();
	
	?><div class="widget">
	<div class="events sc" rel="9999"><?php
		
		echo '<ul>';
		
			if ($id):	
				$event = featured_event($id);
				single_event_display($event);	
			else :
				$event_list = get_upcoming_events(2);
				foreach($event_list as $event):
					single_event_display($event);
				endforeach;
			endif;
		
		echo '</ul>';

	?></div></div><?php
	
	return ob_get_clean();
}
add_shortcode( 'display-event', 'js_display_event' );

?>