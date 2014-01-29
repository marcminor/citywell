<?php

function register_videos_post_type() {

	// Videos
	$labels = array(
		'name' => __('Videos','savior'),
		'singular_name' => __('Video','savior'),
		'add_new' => __('Add New Video','savior'),
		'add_new_item' => __('Add New Video','savior'),
		'edit_item' => __('Edit Video','savior'),
		'new_item' => __('New Video','savior'),
		'view_item' => __('View Video','savior'),
		'search_items' => __('Search Videos','savior'),
		'not_found' => __('No Videos Found','savior'),
		'not_found_in_trash' => __('No Videos Found In Trash','savior'),
		'parent_item_colon' => __('Parent Video:','savior')
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'video',
			'with_front' => false
		),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => '25.4',
		'menu_icon' => get_template_directory_uri().'/_theme_settings/images/menu_icon_video.png',
		'supports' => array('title','editor', 'page-attributes','thumbnail','comments','author','excerpt'),
		'has_archive' => 'videos'
	); 
	register_post_type('video-items', $args);
	
	$labels = array(
	    'name' => _x( 'Video Categories', 'taxonomy general name','savior' ),
	    'singular_name' => _x( 'Video Category', 'taxonomy singular name','savior' ),
	    'search_items' =>  __( 'Search Video Categories','savior' ),
	    'popular_items' => __( 'Popular Video Categories','savior' ),
	    'all_items' => __( 'All Video Categories','savior' ),
	    'parent_item' => null,
	    'parent_item_colon' => null,
	    'edit_item' => __( 'Edit Video Category','savior' ), 
	    'update_item' => __( 'Update Video Category','savior' ),
	    'add_new_item' => __( 'Add New Video Category','savior' ),
	    'new_item_name' => __( 'New Video Category Name','savior' ),
	    'separate_items_with_commas' => __( 'Separate Video Categories with commas','savior' ),
	    'add_or_remove_items' => __( 'Add or remove Video Categories','savior' ),
	    'choose_from_most_used' => __( 'Choose from the most used Video Categories','savior' )
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
	register_taxonomy('videos', 'video-items', $args);
	
} ?>