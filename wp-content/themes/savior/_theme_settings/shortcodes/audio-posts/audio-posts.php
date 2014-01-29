<?php



// ----------------------------------------------------------------------------------------------------
// Shortcode Button/Form

class Custom_Shortcodes_AudioPosts
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
		array_push( $buttons, '', 'js_audioPosts_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['js_audioPosts'] = get_template_directory_uri() . '/_theme_settings/shortcodes/audio-posts/script.js';
		return $plugins;
	}
}

$posts = new Custom_Shortcodes_AudioPosts();



// ----------------------------------------------------------------------------------------------------
// Shortcode Display

function js_display_audioPosts( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'category' => '',
		'count' => 5
	), $atts ) );
			
	global $post;
	
	$args = array( 'post_type' => 'audio-items', 'numberposts' => $count);
	if ($category){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'audio',
				'field' => 'id',
				'terms' => $category
				)
			);
	}
	
	$posts = get_posts($args);
	if ($posts) {
	
		ob_start();
	
		$counter = 0;
		
		foreach ( $posts as $post ) {
		
			if (get_post_meta($post->ID, '_file_mp3', true)){
				$audio_file = home_url() . '/wp-content/uploads/'.get_post_meta($post->ID, '_file_mp3', true);
			} else if (get_post_meta($post->ID, '_file_external_mp3', true)){
				$audio_file = get_post_meta($post->ID, '_file_external_mp3', true);
			} else {
				$audio_file = '';
			} ?>
				
			<div class="single-post audio-items">
			
				<div class="post-content">
					<h4 id="post-<?php echo $post->ID; ?>"><a href="<?php echo get_permalink($post->ID) ?>"><?php echo get_the_title($post->ID); ?></a></h4>
					
					<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
						<p class="post-meta"><?php _e('Posted on','savior'); ?> <strong><?php echo get_the_time('F j, Y',$post->ID) ?></strong> <?php _e('by','savior'); ?> <?php echo '<a href="'.get_author_posts_url($post->post_author).'">'.get_the_author_meta('display_name',$post->post_author).'</a>'; ?> <?php _e('in','savior'); ?>
						<?php the_terms($post->ID,'audio','',', '); ?></p>
					<?php } else { ?>
						<br />
					<?php } ?>
					
					<?php if ($audio_file){
						?><a href="#" class="button-small white play" data-src="<?php echo $audio_file; ?>"><?php _e('Play Audio','savior'); ?></a><br /><br /><?php
					} ?>
					
					<p><?php echo $post->post_excerpt; ?></p>
					
				</div>
			
			</div><?php
			
		}
		
		return ob_get_clean();
		
	}
	
	wp_reset_query();
	
}
add_shortcode( 'display-audio', 'js_display_audioPosts' );

?>