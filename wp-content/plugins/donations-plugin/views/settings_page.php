<div class="wrap">
<div id="icon-options-general" class="icon32">
	<br />
</div>
<h2><?php echo __( 'Settings', DONATION_PLUGIN_TEXT_DOMAIN ); ?></h2>

<?php if ( $show_settings_updated_notice ): ?>
	<div id="message" class="updated below-h2" style="margin:5px">
		<p><?php echo __('Settings updated.'); ?></p>
	</div>
<?php endif; ?>

<form method="post" action="">

<input type="hidden" name="nonce" value="<?php echo $nonce ?>" />

<table class="form-table">

	<tr valign="top">
       <th scope="row">
       		<strong>
       			<label for="paypal_email">
       				<?php echo __( 'PayPal Email:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
       			</label>
       		<strong>
       </th>
       <td>
       		<input type="email" value="<?php echo $paypal_email; ?>" id="paypal_email" name="paypal_email" class="regular-text"  />
        </td>
    </tr>

    <tr valign="top">
       <th scope="row">
       		<strong>
       			<label for="paypal_platform">
       				<?php echo __( 'PayPal Environment:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
       			</label>
       		<strong>
       </th>
       <td>
       		<select name="paypal_platform">
       			
       			<option value="sandbox" <?php selected( 'sandbox', $paypal_platform ) ?> >
       				<?php echo __( 'Sandbox', DONATION_PLUGIN_TEXT_DOMAIN ) ?>
       			</option>
       			
       			<option value="live" <?php selected( 'live', $paypal_platform ) ?> >
       				<?php echo __( 'Live', DONATION_PLUGIN_TEXT_DOMAIN ) ?>
       			</option>
       		
       		</select>
        </td>
    </tr>

    <tr valign="top">
       <th scope="row">
       		<strong>
       			<label for="paypal_currency">
       				<?php echo __( 'Currency:', DONATION_PLUGIN_TEXT_DOMAIN ); ?>
       			</label>
       		<strong>
       </th>
       <td>
    		<select name="paypal_currency">
			<?php foreach ($currencies as $key => $currency): ?>
				<option value="<?php echo $currency['code']; ?>"
					<?php selected( $currency['code'], $paypal_currency ) ?> >
					<?php echo $currency['title']; ?>
				</option>
			<?php endforeach; ?>
			</select>
        </td>
    </tr>
</table>

<?php submit_button( __( 'Save Changes', DONATION_PLUGIN_TEXT_DOMAIN ) ); ?>

</form>

<p>Visit our <a href="http://www.tipsandtricks-hq.com/development-center" target="_blank">WordPress plugins page</a> for more cool WordPress plugins</p>

</div>