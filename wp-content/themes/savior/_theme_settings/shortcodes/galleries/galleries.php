<?php



// ----------------------------------------------------------------------------------------------------
// Shortcode Button/Form

class Custom_Shortcodes_Galleries
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
		array_push( $buttons, '', 'js_galleries_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['js_galleries'] = get_template_directory_uri() . '/_theme_settings/shortcodes/galleries/script.js';
		return $plugins;
	}
}

$galleries = new Custom_Shortcodes_Galleries();



// ----------------------------------------------------------------------------------------------------
// Shortcode Display

function js_display_gallery( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'type' => 'normal',
		'size' => 'medium',
		'hide_featured' => '',
		'hide_captions' => '',
	), $atts ) );

	$gallery_content = '';

	// Normal Gallery
	if ($type == 'normal'){
		
		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } 
		elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } 
		else { $paged = 1; }
		
		global $post;
		
		$featured_image_id = get_post_thumbnail_id($post->ID);
		$img_count = 0;
	
		$args = array( 'orderby' => 'menu_order', 'order' => 'ASC', 'post_type' => 'attachment', 'numberposts' => -1, 'paged'=> $paged, 'post_status' => null, 'post_parent' => $post->ID ); 
		$attachments = get_posts($args);
		if ($attachments) {
			$key = 0;
			foreach ( $attachments as $attachment ) {
				
				$attachment_id = $attachment->ID;
				$key++;
				
				if ($hide_featured && $featured_image_id == $attachment_id){
			
					// Don't include this image because the shortcode has told us to hide it.
					
				} else {
				
					if ($size == 'thumbnail'){ $size = 'small'; }
				
					$thumbnail_image = wp_get_attachment_image_src($attachment->ID,'gallery-'.$size);
					$full_image = wp_get_attachment_image_src($attachment->ID,'lightbox-large');
					
					if (!$hide_captions){
						if (isset($attachment->post_excerpt) && $attachment->post_excerpt){
							$attachment_urls[$key]['caption'] = $attachment->post_excerpt;
						} else if (isset($attachment->post_title) && $attachment->post_title){
							$attachment_urls[$key]['caption'] = $attachment->post_title;
						} else {
							$attachment_urls[$key]['caption'] = '';
						}
					} else {
						$attachment_urls[$key]['caption'] = '';
					}
						
					$attachment_urls[$key]['thumb'] = $thumbnail_image[0];
					$attachment_urls[$key]['full'] = $full_image[0];
					
				}
				
			}
		}
		
		if ($size == 'medium'){
			$gallery_content .= '<div class="gallery">';
			foreach ($attachment_urls as $key => $gallery_image){
				
				$img_count++;
				if ($img_count == 3){ $last = true; } else { $last = false; }
				$gallery_content .= js_display_gallery_photo($gallery_image['full'],$gallery_image['caption'],$gallery_image['thumb'],$size,false,false,$last);
				if ($img_count == 3){ $gallery_content .= '<div class="cl"></div>'; $img_count = 0; }
				
			}
			$gallery_content .= '<div class="cl"></div></div>';
		} else if ($size == 'small'){
			$gallery_content .= '<div class="gallery">';
			foreach ($attachment_urls as $key => $gallery_image){
				
				$img_count++;
				if ($img_count == 5){ $last = true; } else { $last = false; }
				$gallery_content .= js_display_gallery_photo($gallery_image['full'],$gallery_image['caption'],$gallery_image['thumb'],$size,false,false,$last);
				if ($img_count == 5){ $gallery_content .= '<div class="cl"></div>'; $img_count = 0; }
				
			}
			$gallery_content .= '<div class="cl"></div></div>';
		}
		
	}

	return $gallery_content;
}
add_shortcode( 'display-gallery', 'js_display_gallery' );

?>