<?php



// ----------------------------------------------------------------------------------------------------
// Shortcode Button/Form

class Custom_Shortcodes_GalleryPosts
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
		array_push( $buttons, '', 'js_galleryPosts_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['js_galleryPosts'] = get_template_directory_uri() . '/_theme_settings/shortcodes/gallery-posts/script.js';
		return $plugins;
	}
}

$posts = new Custom_Shortcodes_GalleryPosts();



// ----------------------------------------------------------------------------------------------------
// Shortcode Display

function js_display_galleryPosts( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'category' => '',
		'count' => '-1',
		'orderby' => '',
		'title' => '',
		'buttontext' => '',
		'buttonlink' => '',
	), $atts ) );
			
	global $post;
	
	if ($orderby == 'newest-first'){
		$orderby = 'date';
		$order = 'desc';
	} else if ($orderby == 'oldest-first'){
		$orderby = 'date';
		$order = 'asc';
	} else if ($orderby == 'menu-order'){
		$orderby = 'menu_order';
		$order = 'asc';
	} else if ($orderby == 'alphabetical'){
		$orderby = 'name';
		$order = 'asc';
	} else if ($orderby == 'random'){
		$orderby = 'rand';
		$order = 'desc';
	} else {
		$orderby = 'date';
		$order = 'desc';
	}
	
	if (!$count){
		$count = '-1';
	}
		
	$args = array( 'post_type' => 'gallery-items', 'numberposts' => $count, 'orderby' => $orderby, 'order' => $order);
	if ($category){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'galleries',
				'field' => 'id',
				'terms' => $category
				)
			);
	}
	
	ob_start();
	
	$posts = get_posts($args);
	if ($posts) {
		
		if ($title){ ?>
		<div class="widget" style="margin-bottom:10px;">
			<h4 style="padding:0; border:0;"><?php echo $title; ?></h4>
			<?php if ($buttontext && $buttonlink){ ?><a href="<?php echo $buttonlink; ?>" class="widget-button"><?php echo $buttontext; ?></a><?php } ?>
		</div>
		<?php }
	
		$counter = 0;
		
		foreach ( $posts as $post ) {
		
			$photo_count_override = get_post_meta($post->ID, '_photo_count', true);
			if ($photo_count_override):
				$total_attachments = $photo_count_override;
			else :
				$attachments = get_children( array( 'post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );
				$total_attachments = count( $attachments );
			endif;
			
			$counter++;
			
			?>
			
			<div class="gallery-thumb one_third<?php if ($counter == 3) { echo ' last'; } ?>">
				
				<?php echo '<a href="'.get_permalink($post->ID).'">';
					if (has_post_thumbnail($post->ID)){
						echo get_the_post_thumbnail($post->ID,'gallery-medium');
					} else {
						echo '<img width="220" height="148" src="'.get_template_directory_uri().'/_theme_styles/images/default_medium_thumb.jpg" />';
					} ?>
					
					<span class="caption"><?php the_title(); ?></span>
					<span class="gallery-icon"><?php echo $total_attachments; ?></span>
					
				<?php echo '</a>'; ?>

			</div>
			
			<?php if ($counter == 3) { echo '<div class="cl"></div>'; $counter = 0; }
		}
		
		echo '<div class="cl"></div>';
		
	}
	
	wp_reset_query();
	return ob_get_clean();
	
}
add_shortcode( 'display-galleries', 'js_display_galleryPosts' );

?>