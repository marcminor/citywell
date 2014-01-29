<?php
if (function_exists('register_sidebar')) {

	// Default
	register_sidebar(array(
		'name' => __('Default Sidebar','savior'),
		'id'   => 'default-sidebar',
		'description'   => __('The default sidebar for pages.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Page Block 1
	register_sidebar(array(
		'name' => __('Page Widget Block A','savior'),
		'id'   => 'page-block-1',
		'description'   => __('These widgets show up on pages that have widgets active. This is block #1.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Page Block 2
	register_sidebar(array(
		'name' => __('Page Widget Block B','savior'),
		'id'   => 'page-block-2',
		'description'   => __('These widgets show up on pages that have widgets active. This is block #2.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Page Block 3
	register_sidebar(array(
		'name' => __('Page Widget Block C','savior'),
		'id'   => 'page-block-3',
		'description'   => __('These widgets show up on pages that have widgets active. This is block #3.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Footer Left
	register_sidebar(array(
		'name' => __('Bottom Widget Block A','savior'),
		'id'   => 'bottom-footer-1',
		'description'   => __('These widgets show up in the bottom footer (left side).','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Footer Middle
	register_sidebar(array(
		'name' => __('Bottom Widget Block B','savior'),
		'id'   => 'bottom-footer-2',
		'description'   => __('These widgets show up in the bottom footer (middle).','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Footer Right
	register_sidebar(array(
		'name' => __('Bottom Widget Block C','savior'),
		'id'   => 'bottom-footer-3',
		'description'   => __('These widgets show up in the bottom footer (right side).','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Posts
	register_sidebar(array(
		'name' => __('Post Sidebar','savior'),
		'id'   => 'post-sidebar',
		'description'   => __('These widgets will show up on posts only.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Audio
	register_sidebar(array(
		'name' => __('Audio Posts/Category Sidebar','savior'),
		'id'   => 'audio-sidebar',
		'description'   => __('These widgets will show up on Audio posts only.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Video
	register_sidebar(array(
		'name' => __('Video Posts/Category Sidebar','savior'),
		'id'   => 'videos-sidebar',
		'description'   => __('These widgets will show up on Video posts only.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	// Gallery
	register_sidebar(array(
		'name' => __('Gallery Posts/Category Sidebar','savior'),
		'id'   => 'galleries-sidebar',
		'description'   => __('These widgets will show up on Gallery posts only.','savior'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
}
?>