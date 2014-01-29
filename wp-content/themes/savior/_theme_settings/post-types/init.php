<?php

// Sliders
include('sliders/slider.php');

// Galleries
include('galleries.php');
register_galleries_post_type();

// Video
include('videos.php');
register_videos_post_type();

// Audio
include('audio.php');
register_audio_post_type();

add_action('admin_init','admin_menu_separator');
function admin_menu_separator() {
	add_admin_menu_separator('25');
}

?>