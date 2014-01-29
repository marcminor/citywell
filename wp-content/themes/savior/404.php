<?php get_header(); ?>
	
</header>

<div id="main">
	<div class="shell">
		<article id="content" <?php post_class('full'); ?>>
					
			<h1><?php _e('Page Not Found','savior'); ?></h1>
					
			<?php echo (of_get_option('js_404_content') ? of_get_option('js_404_content') : '<p>'.__('Sorry, this page cannot be found.','savior').'</p>'); ?>
								
		</article>
	</div>
</div>

<?php get_footer(); ?>