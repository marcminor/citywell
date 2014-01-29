<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "Google_Language_Translator" );' ) );

class Google_Language_Translator extends WP_Widget {

public function __construct() {
parent::__construct(
'bapi_google_translate', // Base ID
'Google Language Translator', // Name
array( 'description' => __( 'Go to Settings > Google Language Translator to configure this widget.', 'text_domain' ), ) // Args
);
}

public function widget( $args, $instance ) {
extract( $args );
$title = apply_filters( 'widget_title', $instance['title'] );

echo $before_widget;
echo google_translator_shortcode();
echo $after_widget;
}

} // class Google_Translate_Widget
?>