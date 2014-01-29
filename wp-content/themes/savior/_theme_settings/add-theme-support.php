<?php

// Post Thumbnails
add_theme_support('post-thumbnails', array('post','page','gallery-items','audio-items','video-items'));
set_post_thumbnail_size(66,66,true);

// Main Images (slider and page banners)
add_image_size('slide-image',2000,553,true);
add_image_size('page-banner',2000,200,true);

// Lightbox images and medium thumbnails
add_image_size('lightbox-large',1000,1000,false);
add_image_size('medium',288,197,true);
add_image_size('gallery-post-thumb',610,350,true);
add_image_size('gallery-medium',288,197,true);
add_image_size('gallery-small',165,165,true);

// Navigation
add_theme_support('menus');
register_nav_menus(array( 'main-menu' => __( 'Main Menu','savior' )));

?>