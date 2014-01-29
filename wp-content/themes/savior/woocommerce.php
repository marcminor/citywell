<?php get_header(); ?>

</header>
	
<div id="main">
	<div class="shell">
		<article id="content" <?php post_class('full'); ?>>

			<?php woocommerce_content(); ?>

		</article>
	</div>
</div>

<?php get_footer(); ?>