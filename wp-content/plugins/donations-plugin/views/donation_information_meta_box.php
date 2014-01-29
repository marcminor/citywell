<?php

if ( ! current_user_can('edit_post') )
	wp_die( __('You do not have sufficient permissions to access this page.') );

?>

<table class="form-table">

	<!--<tr valign="top">
       <th scope="row">
       		<strong>
       			<label for="donation_email">
       				<?php echo __( 'Donation Email:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
       			</label>
       		<strong>
       </th>
       <td>
       		<input type="email" value="<?php echo $donation_info['donation_email']; ?>" id="donation_email" name="donation_email" class="regular-text"  />
        </td>
    </tr> -->

    <tr valign="top">
       <th scope="row">
       		<strong>
       			<label for="donation_goal">
       				<?php echo __( 'Donation Goal:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
       			</label>
       		<strong>
       </th>
       <td>
       		<input type="number" value="<?php echo $donation_info['donation_goal']; ?>" id="donation_goal" name="donation_goal" class="regular-text"  />
        </td>
    </tr>

    <tr valign="top">
       <th scope="row">
       		<strong>
       			<label for="donation_purpose">
       				<?php echo __( 'Donation Purpose:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
       			</label>
       		<strong>
       </th>
       <td>
       		<textarea rows="6" cols="40" id="donation_purpose" name="donation_purpose"><?php echo $donation_info['donation_purpose']; ?></textarea>
        </td>
    </tr>

    <?php if ( get_post_status( $donation_id ) == 'publish' ): ?>
	    <tr valign="top">
	       <th scope="row">
	       		<strong>
	       			<label for="donation_id">
	       				<?php echo __( 'Donation ID:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
	       			</label>
	       		<strong>
	       </th>
	       <td>
	       		<input type="text" value="<?php echo $donation_id; ?>" id="donation_id" class="regular-text disabled"  />
	        </td>
	    </tr>
	    <tr valign="top">
	       <th scope="row">
	       		<strong>
	       			<label for="donation_shortcode">
	       				<?php echo __( 'Shortcode:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
	       			</label>
	       		<strong>
	       </th>
	       <td>
	       		<input type="text" value="<?php echo $shortcode ?>" id="donation_shortcode" class="regular-text disabled"  />
	        </td>
	    </tr>
	<?php endif; ?>

</table>

<input type="hidden" name="donation_nonce" value="<?php echo $nonce ?>"  />
<input type="hidden" name="post_type_is_donation" />

<style>
#normal-sortables,#post-preview{
  display: none;
}
#donation_purpose{
	color: #333;
}
</style>