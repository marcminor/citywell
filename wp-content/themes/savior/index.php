<?php get_header(); ?>

</header>

<div id="main">
	<div class="shell">
	
		<article id="content">
		
			<h1>Welcome to Savior!</h1>
			<h2>This is your homepage without any content. Kinda boring, huh?</h2>
			<ol>
				<li>Go to your admin panel and <a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=page">create a new page</a>.</li>
				<li>Feel free to add whatever you want to the page, you can always update it later.</li>
				<li>Call it "Homepage" or something similar so you can easily reference it later.</li>
				<li>Then, on the "<a href="<?php echo home_url(); ?>/wp-admin/options-reading.php">Settings > Reading</a>" panel (next to the "Front page displays" section), set the "Front Page" to use that newly created page.</li>
				<li>Refresh this screen to see your homepage!</li>
			</ol>
			
		</article>
	</div>
</div>

<?php get_footer(); ?>