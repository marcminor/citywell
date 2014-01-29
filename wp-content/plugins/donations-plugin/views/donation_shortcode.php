<?php

if ( ! defined( 'DONATION_PLUGIN_PROCESS_VIEW' ) || ! DONATION_PLUGIN_PROCESS_VIEW )
	return;
?>

<?php if ( $skin == 'meter' ): ?>
<div id="donation_plugin_widget">
	<ul>
		<li class="donation_button">
			<a href="<?php echo $donate_now_url ?>">
				<img src="<?php echo $button_image_url; ?>" alt="Donate" />
			</a>
		</li>
		<li class="donation_meter">
			<img src="<?php echo $meter_url; ?>" />
		</li>
	</ul>
	<br style="clear: both" />
</div>

<style>
#donation_plugin_widget { margin: 0; padding: 0; }
#donation_plugin_widget ul li { list-style-type: none !important; float: left; }
#donation_plugin_widget .donation_meter { margin-left: 50px; }
#donation_plugin_widget .donation_button { margin-top:20px; cursor: pointer; }
</style>

<?php endif; ?>

<?php if ( $skin == 'pie' ): ?>
<div id="donation_plugin_widget_pie">
		<div class="donation_meter">
			<img src="<?php echo $meter_url; ?>" />
		</div>
		<div class="donation_button">
			<a href="<?php echo $donate_now_url ?>">
				<img src="<?php echo $button_image_url; ?>" alt="Donate" />
			</a>
		</div>
	<br style="clear: both" />
</div>

<style>
#donation_plugin_widget_pie {margin: 0; padding: 0;}
#donation_plugin_widget_pie { }
#donation_plugin_widget_pie .donation_meter { }
#donation_plugin_widget_pie .donation_button {margin-left: 35px;}
</style>

<?php endif; ?>

<style>
.donation_meter img, .donation_button img{
	border-radius: 0 !important;
	box-shadow: none !important;
}
</style>