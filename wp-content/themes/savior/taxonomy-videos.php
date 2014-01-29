<?php get_header(); ?>

</header>

<div id="main">
	<div class="shell">
		<article id="content" <?php post_class('left'); ?>>
					
			<?php js_breadcrumbs($post->ID); ?>
					
			<?php // Get the Event category and display the title.
			// Get the Event category and display the title.
			$cat = get_query_var('videos');
			$category_name = get_term_by('slug',$cat,'videos');
							
			echo '<h1>'.$category_name->name.'</h1>'; ?>
		
			<?php if ( have_posts() ) : ?>
			
				<?php while (have_posts()) : the_post(); ?>
						
					<div class="single-post">
									
						<div class="post-content<?php if (!has_post_thumbnail($post->ID)){ ?> no-thumb<?php } ?>">
							
							<h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							
							<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
								<p class="post-meta"><?php _e('Posted on','savior'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','savior'); ?> <?php the_author_posts_link(); ?> <?php _e('in','savior'); ?>
								<?php the_terms($post->ID,'videos','',', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','savior').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','savior').'</a>' ); ?></a></p>
							<?php } else { ?>
								<br />
							<?php }
							
							$video_link = get_post_meta($post->ID, '_video_link', true);
							if ($video_link) { echo video_link_to_iframe($video_link,610,343); }
							
							the_excerpt(); ?>
							
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