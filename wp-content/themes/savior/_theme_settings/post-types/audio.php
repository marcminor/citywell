<?php

function register_audio_post_type() {

	// Audio Items
	$labels = array(
		'name' => __('Audio Items','savior'),
		'singular_name' => __('Audio Item','savior'),
		'add_new' => __('Add New Audio Item','savior'),
		'add_new_item' => __('Add New Audio Item','savior'),
		'edit_item' => __('Edit Audio Item','savior'),
		'new_item' => __('New Audio Item','savior'),
		'view_item' => __('View Audio Item','savior'),
		'search_items' => __('Search Audio Items','savior'),
		'not_found' => __('No Audio Items Found','savior'),
		'not_found_in_trash' => __('No Audio Items Found In Trash','savior'),
		'parent_item_colon' => __('Parent Audio Item:','savior')
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'audio-items',
			'with_front' => false
		),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => '25.2',
		'menu_icon' => get_template_directory_uri().'/_theme_settings/images/menu_icon_audio.png',
		'supports' => array('title','editor','page-attributes','thumbnail','comments','author','excerpt'),
		'has_archive' => 'audio'
	); 
	register_post_type('audio-items', $args);
	
	$labels = array(
	    'name' => _x( 'Audio Series', 'taxonomy general name','savior' ),
	    'singular_name' => _x( 'Audio Series', 'taxonomy singular name','savior' ),
	    'search_items' =>  __( 'Search Audio Series','savior' ),
	    'popular_items' => __( 'Popular Audio Series','savior' ),
	    'all_items' => __( 'All Audio Series','savior' ),
	    'parent_item' => null,
	    'parent_item_colon' => null,
	    'edit_item' => __( 'Edit Audio Series','savior' ), 
	    'update_item' => __( 'Update Audio Series','savior' ),
	    'add_new_item' => __( 'Add New Audio Series','savior' ),
	    'new_item_name' => __( 'New Audio Series Name','savior' ),
	    'separate_items_with_commas' => __( 'Separate Audio Series with commas','savior' ),
	    'add_or_remove_items' => __( 'Add or remove Audio Series','savior' ),
	    'choose_from_most_used' => __( 'Choose from the most used Audio Series','savior' )
	);
	
	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			"with_front" => true,
		),
	);
	register_taxonomy('audio', 'audio-items', $args);
	
} ?>