<?php

function register_galleries_post_type() {

	// Galleries
	$labels = array(
		'name' => __('Galleries','savior'),
		'singular_name' => __('Gallery','savior'),
		'add_new' => __('Add New Gallery','savior'),
		'add_new_item' => __('Add New Gallery','savior'),
		'edit_item' => __('Edit Gallery','savior'),
		'new_item' => __('New Gallery','savior'),
		'view_item' => __('View Gallery','savior'),
		'search_items' => __('Search Galleries','savior'),
		'not_found' => __('No Galleries Found','savior'),
		'not_found_in_trash' => __('No Galleries Found In Trash','savior'),
		'parent_item_colon' => __('Parent Gallery:','savior')
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'gallery',
			'with_front' => false
		),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => '25.3',
		'menu_icon' => get_template_directory_uri().'/_theme_settings/images/menu_icon_gallery.png',
		'supports' => array('title','editor', 'page-attributes','thumbnail','comments','author','excerpt'),
		'has_archive' => 'galleries'
	); 
	register_post_type('gallery-items', $args);
	
	$labels = array(
	    'name' => _x( 'Gallery Categories', 'taxonomy general name','savior' ),
	    'singular_name' => _x( 'Gallery Category', 'taxonomy singular name','savior' ),
	    'search_items' =>  __( 'Search Gallery Categories','savior' ),
	    'popular_items' => __( 'Popular Gallery Categories','savior' ),
	    'all_items' => __( 'All Gallery Categories','savior' ),
	    'parent_item' => null,
	    'parent_item_colon' => null,
	    'edit_item' => __( 'Edit Gallery Category','savior' ), 
	    'update_item' => __( 'Update Gallery Category','savior' ),
	    'add_new_item' => __( 'Add New Gallery Category','savior' ),
	    'new_item_name' => __( 'New Gallery Category Name','savior' ),
	    'separate_items_with_commas' => __( 'Separate Gallery Categories with commas','savior' ),
	    'add_or_remove_items' => __( 'Add or remove Gallery Categories','savior' ),
	    'choose_from_most_used' => __( 'Choose from the most used Gallery Categories','savior' )
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
	register_taxonomy('galleries', 'gallery-items', $args);

} ?>