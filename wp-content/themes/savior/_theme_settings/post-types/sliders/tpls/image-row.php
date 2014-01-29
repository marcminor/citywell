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
   							    'Adding a new Image Block ...';

	$class = $subitem['title'] ? '' : ' class="inactive"';
	?>
	<h4<?php echo $class ?>>[IMAGE] <span class="title-text"><?php echo $text ?></span></h4>
</div><!-- /.preview -->

<div class="content">
	<div class="cnt-inner">
		<div class="image-preview">
			<?php if($subitem['image_id']) {
				$src = wp_get_attachment_image_src($subitem['image_id'], 'full');
				echo '<img src="' . esc_attr($this->get_thumb($src[0], 79, 87)) . '" alt="" />';							
			} ?>
		</div>

		<div class="row title-row">
			<div class="uploader">
				<input class="plupload-browse-button button-secondary" type="button" value="<?php esc_attr_e('Upload Image'); ?>" class="button" />
				<div class="progressbar"><span></span></div>
				<input type="hidden" name="obo_slides[<?php echo $i ?>][items][<?php echo $k ?>][image_id]" class="image-id" value="<?php echo $subitem['image_id'] ? $subitem['image_id'] : '' ?>" />
			</div>

			<?php echo $this->render_field("obo_slides[$i][items][$k][title]", $subitem['title'], 'Image Title (optional) ...', 'title-field') ?>	
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

			<div class="width-wrap width-60">
				<label>Animation:</label>
				<?php echo $this->render_selectbox("obo_slides[$i][items][$k][animation]", $this->settings['animations'], $subitem['animation']) ?>
			</div>
		</div>
		
		<div class="row">
			<div class="width-wrap width-95">
				<label>Image URL (optional):</label>
				<?php echo $this->render_field("obo_slides[$i][items][$k][image_url]", (isset($subitem['image_url']) ? $subitem['image_url'] : '')) ?>
			</div>
		</div>

		<div class="cl">&nbsp;</div>
	</div>
</div>