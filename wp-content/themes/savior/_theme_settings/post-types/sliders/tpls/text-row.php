<?php
/*
	Use:
	* $k - index
	* $subitem - item
	* obo_slides[<?php echo $i ?>][items][<?php echo $k >][****]
*/
?>
<div class="title-wrap">
	<?php
	$text = $subitem['title'] ? $subitem['title'] :
   							    'Adding a new Text Row ...';

	$class = $subitem['title'] ? '' : ' class="inactive"';
	?>
	<h4<?php echo $class ?>>[TEXT] <span class="title-text"><?php echo $text ?></span></h4>
</div><!-- /.preview -->

<div class="content">
	<div class="row arrow-row">
		<?php echo $this->render_field("obo_slides[$i][items][$k][title]", $subitem['title'], 'Title (optional) ...', 'title-field') ?>	
		<?php echo $this->render_field("obo_slides[$i][items][$k][button_text]", $subitem['button_text'], 'Button Text (optional) ...', 'button-text-field') ?>	
		<?php echo $this->render_field("obo_slides[$i][items][$k][button_link]", $subitem['button_link'], 'Button link (optional) ...', 'button-link-field') ?>	
		<div class="cl">&nbsp;</div>
	</div>

	<div class="row">
		<textarea placeholder="Content ..." name="obo_slides[<?php echo $i ?>][items][<?php echo $k ?>][content]"><?php echo esc_html($subitem['content']) ?></textarea>
		<div class="cl">&nbsp;</div>
	</div>

	<div class="row">
		<div class="width-wrap width-20">
			<label>Top (px):</label>
			<?php echo $this->render_field("obo_slides[$i][items][$k][top]", $subitem['top']) ?>	
		</div>

		<div class="width-wrap width-20">
			<label>Left (px):</label>
			<?php echo $this->render_field("obo_slides[$i][items][$k][left]", $subitem['left']) ?>	
		</div>

		<div class="width-wrap width-40">
			<label>Animation:</label>
			<?php echo $this->render_selectbox("obo_slides[$i][items][$k][animation]", $this->settings['animations'], $subitem['animation']) ?>
		</div>

		<div class="width-wrap width-20 last">
			<label>Width:</label>
			<?php echo $this->render_field("obo_slides[$i][items][$k][width]", $subitem['width']) ?>
		</div>
		<div class="cl">&nbsp;</div>
	</div>
	<div class="cl">&nbsp;</div>
</div>