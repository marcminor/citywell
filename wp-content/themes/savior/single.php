<?php get_header(); ?>

</header>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php
		
	$featured_thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'page-banner' );
	$featured_thumbnail_src = $featured_thumbnail_src[0];
	
	if ($featured_thumbnail_src) { ?>
		<section id="featured-image" style="background:url('<?php echo $featured_thumbnail_src; ?>') no-repeat top center;"></section>
	<?php }
		
	?>

	
	<div id="main">
		<div class="shell">
			<article id="content" <?php post_class('left'); ?>>
					
					<?php js_breadcrumbs($post->ID); ?>
					<h2><?php the_title(); ?></h2>
					
					<?php the_content(); wp_link_pages(); ?>
					
					<?php the_tags('<small><strong>Tags:</strong> ', ', ', '</small>'); ?>
					
					<?php comments_template(); ?>
								
				</article>
				<section id="sidebar" class="right">
					<?php get_sidebar(); ?>				
				</section>
				
				<div class="cl"></div>
				
			</article>
		</div>
	</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>