<?php get_header(); ?>

</header>

<div id="main">
	<div class="shell">
		<article id="content" <?php post_class('left'); ?>>
					
			<?php js_breadcrumbs($post->ID); ?>
			<h1 class="bitter"><?php _e('Search Results','savior'); ?></h1>
			
			<?php if ( have_posts() ) : ?>
			
				<?php while (have_posts()) : the_post(); ?>
						
					<div class="single-post">
							
						<div class="post-content no-thumb">
							<h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
	
							<?php the_excerpt(); ?>
	
							<a href="<?php the_permalink() ?>" class="more"><?php _e('Continue Reading','savior'); ?></a>
						</div>
					
					</div>
		
				<?php endwhile; ?>
				
			<?php endif; ?>
			
			<?php js_get_pagination(); wp_reset_query(); ?>
							
		</article>
		<section id="sidebar" class="right">
			<?php get_sidebar(); ?>				
		</section>
			
		<div class="cl"></div>
	</div>
</div>
	
<?php get_footer(); ?>