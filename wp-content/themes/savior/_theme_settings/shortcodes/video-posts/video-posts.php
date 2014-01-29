<?php



// ----------------------------------------------------------------------------------------------------
// Shortcode Button/Form

class Custom_Shortcodes_VideoPosts
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
		array_push( $buttons, '', 'js_videoPosts_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['js_videoPosts'] = get_template_directory_uri() . '/_theme_settings/shortcodes/video-posts/script.js';
		return $plugins;
	}
}

$posts = new Custom_Shortcodes_VideoPosts();



// ----------------------------------------------------------------------------------------------------
// Shortcode Display

function js_display_videoPosts( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'category' => '',
		'count' => 5
	), $atts ) );
			
	global $post;
	
	$args = array( 'post_type' => 'video-items', 'numberposts' => $count);
	if ($category){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'videos',
				'field' => 'id',
				'terms' => $category
				)
			);
	}
	
	$posts = get_posts($args);
	if ($posts) {
	
		ob_start();
	
		$counter = 0;
		
		?><div class="gallery-widget gallery" rel="<?php echo intval($show); ?>"><?php
			
			foreach ( $posts as $post ) {
			
				$photo_count_override = get_post_meta($post->ID, '_photo_count', true);
				if ($photo_count_override):
					$total_attachments = $photo_count_override;
				else :
					$attachments = get_children( array( 'post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );
					$total_attachments = count( $attachments );
				endif;
				
				$counter++;
				
				$video_link = get_post_meta($post->ID, '_video_link', true);
				if ($video_link) {
				
					$video_embed_link = video_link_to_iframe($video_link,610,343,false);
				
					?>
					
					<div class="gallery-thumb one_third<?php if ($counter == 3) { echo ' last'; } ?>">
						
						<?php echo '<a class="fancybox fancybox.iframe" href="'.$video_embed_link.'">';
							
							if (has_post_thumbnail($post->ID)){
								echo get_the_post_thumbnail($post->ID,'gallery-medium');
							} else {
								echo '<img width="220" height="148" src="'.get_template_directory_uri().'/_theme_styles/images/default_medium_thumb.jpg" />';
							} ?>
							
							<span class="caption"><?php the_title(); ?></span>
							<span class="play-icon"></span>
							
						<?php echo '</a>'; ?>

					</div>
					
					<?php if ($counter == 3) { echo '<div class="cl"></div>'; $counter = 0; }
				
				}

			}
			
		?></div><div class="cl"></div><?php
		
		return ob_get_clean();
		
	}
	
	wp_reset_query();
	
}
add_shortcode( 'display-videos', 'js_display_videoPosts' );

?>