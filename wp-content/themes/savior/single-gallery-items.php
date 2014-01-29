<?php get_header(); ?>

</header>

<div id="main">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php
					
		$show_image = get_post_meta($post->ID, '_show_big_image', true);
			
		$featured_thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'page-banner' );
		$featured_thumbnail_src = $featured_thumbnail_src[0];
		
		if ($featured_thumbnail_src && $show_image) { ?>
			<section id="featured-image" style="background:url('<?php echo $featured_thumbnail_src; ?>') no-repeat top center;"></section>
		<?php }
			
		?>
		
		<div class="shell">
			<article id="content">
									
				<?php js_breadcrumbs($post->ID); ?>
				<h1><?php the_title(); ?></h1>
				
				<?php the_content(); ?>
				<?php comments_template(); ?>
						
			</article>
		</div>
		
	<?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>