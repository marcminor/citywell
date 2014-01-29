<div class="submitbox" id="submitdonate">

<div id="misc-publishing-actions">
<div class="misc-pub-section"> 
</div>
</div>


<div id="major-publishing-actions">
	
	<?php if ( $post_status == 'publish'  ): ?>
		<div id="delete-action">
			<a class="submitdelete deletion" href="<?php echo $delete_link ?>">
				<?php echo __( 'Move to Trash', 'isell' ); ?>
			</a>
		</div>
	<?php endif; ?>
	
	<div id="publishing-action">
		<?php 
			if ( $post_status != 'publish'  ):
				submit_button( __( 'Add Donation', DONATION_PLUGIN_TEXT_DOMAIN ), 'primary', 'publish', false );
			else:
				submit_button( __( 'Update Donation', DONATION_PLUGIN_TEXT_DOMAIN ), 'primary', 'submit', false );
			endif;
		?>
	</div>
	
</div>

<div class="clear"></div>

</div>
