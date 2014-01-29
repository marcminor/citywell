<?php get_header(); ?>

</header>

<div id="main">
	<div class="shell">
		<article id="content" <?php post_class('left'); ?>>
					
			<?php js_breadcrumbs($post->ID); ?>
			<h1>
				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

				<?php /* If this is a category archive */ if (is_category()) { ?>
					<?php single_cat_title(); ?>
		
				<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
					<?php _e('Tagged','savior'); ?>: &ldquo;<?php single_tag_title(); ?>&rdquo;
		
				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
					<?php _e('Archive for','savior'); echo ' '; the_time('F jS, Y'); ?>
		
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
					<?php _e('Archive for','savior'); echo ' '; the_time('F, Y'); ?>
		
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
					<?php _e('Archive for','savior'); echo ' '; the_time('Y'); ?>
		
				<?php /* If this is an author archive */ } elseif (is_author()) { ?>
					<?php _e('Author Archive','savior'); ?>
					
				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
					<?php _e('Archives','savior'); ?>
				<?php } ?>
			</h1>
			
			<?php if ( have_posts() ) : ?>
			
				<?php while (have_posts()) : the_post(); ?>
						
					<div class="single-post">
						
						<?php if (has_post_thumbnail($post->ID)){ ?>
							<div class="one_fourth postlist-thumbnail">
							<a href="<?php the_permalink() ?>"><?php
							$featured_caption = get_the_title($post->ID);
							$featured_image = get_the_post_thumbnail($post->ID,'thumbnail', array('title'=>$featured_caption));
							echo $featured_image;
							?></a></div>
						<?php } ?>
									
						<?php if (has_post_thumbnail($post->ID)){ ?>
							<div class="three_fourth last"><?php
						} ?>	
							
								<div class="post-content<?php if (!has_post_thumbnail($post->ID)){ ?> no-thumb<?php } ?>">
									<h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
									
									<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
										<p class="post-meta"><?php _e('Posted on','savior'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','savior'); ?> <?php the_author_posts_link(); ?> <?php _e('in','savior'); ?>
										<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','savior').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','savior').'</a>' ); ?></a></p>
									<?php } else { ?>
										<br />
									<?php } ?>
			
									<?php the_excerpt(); ?>
			
									<a href="<?php the_permalink() ?>" class="more"><?php _e('Continue Reading','savior'); ?></a>
								</div>
								
						<?php if (has_post_thumbnail($post->ID)){ ?>
							</div><?php
						} ?>
						
						<div class="cl"></div>
					
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