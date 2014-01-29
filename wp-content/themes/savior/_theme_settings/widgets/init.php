<?php

global $aec;

include('page-children.php');
include('recent-audio.php');
include('recent-posts.php');
include('recent-tweets.php');
include('facebook-feed.php');
include('gallery-widget.php');
include('video-widget.php');
include('text.php');

if (is_object($aec)) { include('upcoming-events.php'); }

/* Register the widgets */
function load_widgets() {
	
	global $aec;

	register_widget('ThemeWidgetRecentPosts');
	register_widget('ThemeWidgetRecentTweets');
	register_widget('ThemeWidgetFacebookFeed');
	register_widget('ThemeWidgetAudioItems');
	register_widget('ThemeWidgetGalleryItems');
	register_widget('ThemeWidgetVideoItems');
	register_widget('ThemeWidgetPageChildren');
	register_widget('ThemeWidgetTextWidget');
	
	if (is_object($aec)) { register_widget('ThemeWidgetUpcomingEvents'); }
	
}
add_action('widgets_init', 'load_widgets');

?>