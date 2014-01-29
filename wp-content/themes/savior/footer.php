<?php global $template_dir; ?>

	<footer id="footer">
		
		<?php if (is_active_sidebar('bottom-footer-1') || is_active_sidebar('bottom-footer-2') || is_active_sidebar('bottom-footer-3')){ ?>
	
			<div class="shell">
			
				<?php
				
				$bottom_widget_layout = of_get_option('js_footer_widget_layout');
				
				switch ($bottom_widget_layout) {
			
					case 'one' :
					
						if (is_active_sidebar('bottom-footer-1')){
							
							dynamic_sidebar('bottom-footer-1');
							
						}
					
					break;
					
					case 'two' :
					
						if (is_active_sidebar('bottom-footer-1') || is_active_sidebar('bottom-footer-2')){
							
							echo '<div class="one_half">';
								dynamic_sidebar('bottom-footer-1');
							echo '</div>';
							
							echo '<div class="one_half last">';
								dynamic_sidebar('bottom-footer-2');
							echo '</div>';
							
						}
					
					break;
					
					case 'three' :
					
						if (is_active_sidebar('bottom-footer-1') || is_active_sidebar('bottom-footer-2') || is_active_sidebar('bottom-footer-3')){
							
							echo '<div class="one_third">';
								dynamic_sidebar('bottom-footer-1');
							echo '</div>';
							
							echo '<div class="one_third">';
								dynamic_sidebar('bottom-footer-2');
							echo '</div>';
							
							echo '<div class="one_third last">';
								dynamic_sidebar('bottom-footer-3');
							echo '</div>';
							
						}
					
					break;
					
				}
				
				?>
				
			</div>

		<?php } ?>
		
		<?php if (!of_get_option('js_bottom_bar_disabled')): ?>
		<div class="bottom">
			<div class="shell">
			
				<!-- Bottom Right Content -->
				<div class="right"><?php display_bottom_right_content(); ?></div>
				
				<!-- Bottom Left Content -->
				<?php display_bottom_left_content(); ?>
				
			</div>
		</div>
		<?php endif; ?>
		
	</footer>
	
	<script type="text/javascript">
		var customColor = '<?php echo (of_get_option('js_highlight_color') ? str_replace('#','',of_get_option('js_highlight_color')) : '0ca6bd'); ?>';
		var templateDir = '<?php echo $template_dir; ?>';
		var in_lang = '<?php _e('in','savior'); ?>';
	</script>
	
	<?php if (!is_page()): ?>
		<script type="text/javascript">
			var slider_speed = false;
			var slider_autocycle = false;
			var slider_interval = false;
		</script>
	<?php endif; ?>
	
	<?php wp_footer(); ?>
	
</body>
</html>