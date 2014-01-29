<?php

get_header(); global $template_dir;
	
if (have_posts()) : while(have_posts()) : the_post();
	
	savior_slider($post); ?>
		
	</header>
	
	<?php
		
	$featured_thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'page-banner' );
	$featured_thumbnail_src = $featured_thumbnail_src[0];
	
	if ($featured_thumbnail_src) { ?>
		<section id="featured-image" style="background:url('<?php echo $featured_thumbnail_src; ?>') no-repeat top center;"></section>
	<?php }
		
	?>
	
	<?php
	
	// Page Layout
	$page_layout = get_post_meta($post->ID, '_page_layout', true);
	$page_layout = $page_layout ? $page_layout[0] : 'countdown_page_widgets';
	$page_layout_order = explode('_',$page_layout);
	$page_content = get_the_content($post->ID);
	
	// Countdown Type
	$countdown_type = get_post_meta($post->ID, '_countdown_type',true);
	
	// Page Widget Settings - Row 1
	$widget_layout = get_post_meta($post->ID, '_widget_layout', true);
	$widget_layout = $widget_layout ? $widget_layout[0] : 'no-widgets';
	
	// Sidebar Settings
	$sidebar_layout = get_post_meta($post->ID, '_sidebar_layout', true);
	$sidebar_layout = $sidebar_layout ? $sidebar_layout[0] : 'no-sidebar';
	$sidebar_choice = get_post_meta($post->ID, '_sidebar_choice', true);
	
	if ($widget_layout != 'no-widgets' || $page_content || $countdown_type): echo '<div id="main">'; endif;
		
		// Loop through page layout pieces
		foreach ($page_layout_order as $layout_type){
			
			// Add double lines where they look good
			if (isset($previous_layout_type) && $layout_type == 'page' && $previous_layout_type == 'widgets' || isset($previous_layout_type) && $layout_type == 'widgets' && $previous_layout_type == 'page' && $page_content ){
				$include_hr = true;
			} else {
				$include_hr = false;
			}
			
			// Change styling for event countdown if it's the last one
			if ($page_layout == 'page_widgets_countdown' || $page_layout == 'widgets_page_countdown' || !$page_content && $widget_layout == 'no-widgets'){
				$bottom = true;
			} else {
				$bottom = false;
			}
			
			// Load the page piece
			call_user_func_array('page_part_'.$layout_type,array($post->ID,$include_hr,$bottom));
			$previous_layout_type = $layout_type;
			
		}
		
	if ($widget_layout != 'no-widgets' || $page_content): echo '</div>'; endif;
	
	?>
	
	</div>
	
	<?php

	wp_reset_query();
	
	// Slider Settings
	$slider_speed = (get_post_meta($post->ID, '_slider_speed', true) ? get_post_meta($post->ID, '_slider_speed', true) : 'normal');
	$slider_interval = (get_post_meta($post->ID, '_slider_interval', true) ? get_post_meta($post->ID, '_slider_interval', true) : '8');
	$slider_autocycle = get_post_meta($post->ID, '_slider_autocycle', true);
	if (isset($slider_autocycle[0])) : $slider_autocycle = $slider_autocycle[0]; else : $slider_autocycle = 0; endif;
	
	if ($slider_speed == 'normal'){
		$slider_speed = 500;
	} else if ($slider_speed == 'slow'){
		$slider_speed = 1000;
	} else {
		$slider_speed = 200;
	}
	?>
	
	<script type="text/javascript">
		var slider_speed = <?php echo $slider_speed; ?>;
		var slider_autocycle = <?php echo (!$slider_autocycle ? 'false' : 'true'); ?>;
		var slider_interval = <?php echo ($slider_interval * 1000); ?>;
	</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>