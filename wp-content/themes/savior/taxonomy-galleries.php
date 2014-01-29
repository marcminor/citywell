<?php get_header(); ?>

</header>

<div id="main">
	<div class="shell">
		<article id="content">
					
			<?php js_breadcrumbs($post->ID); ?>
			<?php // Get the Event category and display the title.
			// Get the Event category and display the title.
			$cat = get_query_var('galleries');
			$category_name = get_term_by('slug',$cat,'galleries');
							
			echo '<h1>'.$category_name->name.'</h1>'; ?>
								
			<?php if ( have_posts() ) : ?>
	
				<section id="galleries">
					
					<?php
				
					$counter = 0;
				
					while ( have_posts() ) : the_post(); global $post;
					
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

					endwhile;
					
					?>
					
					<div class="cl"></div>
					
				</section>
						
			<?php endif; ?>
					
			<?php js_get_pagination(); wp_reset_query(); ?>
								
		</article>
	</div>
</div>
	
<?php get_footer(); ?>