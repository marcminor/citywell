<?php get_header(); ?>

</header>

<div id="main">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<?php
		
		if (get_post_meta($post->ID, '_file_mp3', true)){
			$audio_file = home_url() . '/wp-content/uploads/'.get_post_meta($post->ID, '_file_mp3', true);
		} else if (get_post_meta($post->ID, '_file_external_mp3', true)){
			$audio_file = get_post_meta($post->ID, '_file_external_mp3', true);
		} else {
			$audio_file = '';	
		}
		
		?>

		<div class="shell">
			<article id="content" <?php post_class('left'); ?>>
						
				<?php js_breadcrumbs($post->ID); ?>
				<h1><?php the_title(); ?></h1>
				
				<?php if ($audio_file){
					?><a href="#" class="button-small white play" data-src="<?php echo $audio_file; ?>"><?php _e('Play Audio','savior'); ?></a><br /><br /><?php
				} ?>
				
				<?php the_content(); ?>
				<?php comments_template(); ?>
							
			</article>
			<section id="sidebar" class="right">
				<?php get_sidebar(); ?>				
			</section>
		</div>
		
		<div class="cl"></div>

	<?php endwhile; endif; ?>
		
</div>
		
<?php get_footer(); ?>