<?php

class Donation_Plugin_Custom_Post_Type
{
	function __construct( $do_start = false ) {

		if ( $do_start )
			$this->start();

	}

	function start() {

		$this->hooks();
		$this->filters();
	}

	function hooks() {

		add_action( 'init' , array( $this, 'register_donation_post_type' ) );

		add_action( 'admin_menu', array( $this, 'remove_meta_boxes' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post', array( $this, 'save_meta_box_data' ) );
	}

	function filters() {

		add_filter( 'post_updated_messages', array( $this, 'custom_update_messages' ) );

		add_filter( 'post_row_actions', array( $this, 'remove_post_row_actions' ) );
	}

	function register_donation_post_type() {

		$labels = array(
		    'name' => _x('Donations', 'post type general name'),
		    'singular_name' => _x('Donation', 'post type singular name'),
		    'add_new' => _x('Add New', 'Donation'),
		    'add_new_item' => __('Add New Donation'),
		    'edit_item' => __('Edit Donation'),
		    'new_item' => __('New Donation'),
		    'all_items' => __('All Donations'),
		    'view_item' => __('View Donation'),
		    'search_items' => __('Search Donations'),
		    'not_found' =>  __('No Donations found'),
		    'not_found_in_trash' => __('No Donations found in Trash'), 
		    'parent_item_colon' => '',
		    'menu_name' => __('Donations')

	  	);

	  	$args = array(
		    'labels' => $labels,
		    'public' => false,
		    'publicly_queryable' => false,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => false,
		    'rewrite' => false,
		    'capability_type' => 'post',
		    'has_archive' => false, 
		    'hierarchical' => false,
		    'menu_position' => null,
		    'supports' => array( 'title' )
	  	);

	  	register_post_type(DONATION_PLUGIN_CUSTOM_POST_TYPE, $args);

	}

	function remove_meta_boxes() {

		remove_meta_box( 'submitdiv', DONATION_PLUGIN_CUSTOM_POST_TYPE, 'side' );

	}

	function add_meta_boxes() {

		add_meta_box( 
        'donation_info_meta_box',
        __( 'Information', DONATION_PLUGIN_TEXT_DOMAIN ),
        array($this,'donation_information_meta_box'),
        DONATION_PLUGIN_CUSTOM_POST_TYPE
    	);

    	add_meta_box( 
        'custom_publish_meta_box',
        __( 'Save', DONATION_PLUGIN_TEXT_DOMAIN ),
        array($this,'donation_custom_publish_meta_box'),
        DONATION_PLUGIN_CUSTOM_POST_TYPE,
        'side'
    	);

	}

	function donation_information_meta_box( $post ) {

		$donation_id = $post->ID;

		$nonce = wp_create_nonce( 'donation_nonce' );

		$donation_info = get_post_meta( $donation_id, 'donation_info', true );

		$shortcode = sprintf( '[%s id=%d]', DONATION_PLUGIN_SHORTCODE, $donation_id );

		if ( ! $donation_info ) {
			$donation_info['donation_email'] = '';
			$donation_info['donation_purpose'] = '';
			$donation_info['donation_goal'] = '';
		}

		include muneeb_donation_plugin_view_path(__FUNCTION__);
	}

	function donation_custom_publish_meta_box( $post ) {

		$donation_id = $post->ID;

		$post_status = get_post_status( $donation_id );

		$delete_link = get_delete_post_link( $donation_id );

		include muneeb_donation_plugin_view_path(__FUNCTION__);

	}

	function save_meta_box_data( $post_id ) {

		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
		if ( wp_is_post_revision( $post_id ) )
			return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $post_id;
		if ( ! isset( $_POST['post_type_is_donation'] ) )
			return;
		if ( ! wp_verify_nonce( $_POST['donation_nonce'], 'donation_nonce' ) )
			return;

		$donation_id = $post_id;

		if ( get_post_type( $donation_id ) !== DONATION_PLUGIN_CUSTOM_POST_TYPE )
			return;

		$donation_info = get_post_meta( $donation_id, 'donation_info', true ); 

		//$donation_info['donation_email'] = $_POST['donation_email'];
		$donation_info['donation_purpose'] = stripslashes($_POST['donation_purpose']);
		$donation_info['donation_goal'] = $_POST['donation_goal'];

		update_post_meta( $donation_id, 'donation_info', $donation_info );

	}

	function custom_update_messages() {

		global $post;
		$messages[DONATION_PLUGIN_CUSTOM_POST_TYPE] = array(
					0 => '',
					1 =>  __('Donation updated.'),
					2 => __('Custom field updated.'),
					3 => __('Custom field deleted.'),
					4 => __('Donation updated.'),
					5 => isset($_GET['revision']) ? sprintf( __('Donation restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
					6 => __('Donation created.'),
					7 => __('Donation saved.'),
					8 => '',
					9 => sprintf( __('Donation scheduled for: <strong>%1$s</strong>.'),
					  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
					10 => __('Donation draft updated.')
				);

		return $messages;

	}

	function remove_post_row_actions( $actions ) {

		if ( get_post_type() !== DONATION_PLUGIN_CUSTOM_POST_TYPE )
			return $actions;

		unset( $actions['view'] );
        unset( $actions['inline hide-if-no-js'] );
        unset( $actions['pgcache_purge'] );

        return $actions;
	}
}

?>