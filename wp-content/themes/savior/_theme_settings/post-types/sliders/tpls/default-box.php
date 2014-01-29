<div class="cslides">
	<a href="#" class="button-secondary add">Add a Slide</a>

	<ul class="sortable">
		<?php foreach($items as $i => $item) {
			$li_atts = isset($item['prototype']) ? ' class="prototype" style="display:none"' : '';

			if(isset($item['prototype'])) {
				$i = '%d%';
			}
			?>
			<li<?php echo $li_atts ?> data-id="<?php echo $i ?>">
				<!-- Controls -->
				<span class="notext drag"></span>
				<a href="#" class="notext remove"></a>
				<a href="#" class="toggle"></a>

				<div class="title-wrap">
					<?php
					$text = $item['title'] ? $item['title'] :
											 $this->settings['strings']['no-title'];

					$class = $item['title'] ? '' : ' class="inactive"';
					?>
					<h4<?php echo $class ?>><span class="title-text"><?php echo $text ?></span></h4>
				</div><!-- /.preview -->

				<div class="content">
					<div class="row uploader-row">
						<div class="uploader">
							<input class="plupload-browse-button button-secondary" type="button" value="<?php esc_attr_e('Upload Image'); ?>" class="button" />
							<div class="progressbar"><span></span></div>
							<input type="hidden" name="slides[<?php echo $i ?>][image_id]" class="image-id" value="<?php echo $item['image_id'] ? $item['image_id'] : '' ?>" />
						</div>

						<div class="full-col">
							<?php echo $this->render_field('slides[' . $i . '][title]', $item['title'], 'Slide Title ...', 'title-field') ?>							
						</div>
					</div>

					<div class="row">
						<div class="fixed">
							<div class="image-preview">
								<?php if($item['image_id']) {
									$src = wp_get_attachment_image_src($item['image_id'], 'full');
									echo '<img src="' . esc_attr($this->get_thumb($src[0], 149, 87)) . '" alt="" />';							
								} ?>
							</div>							
						</div>

						<div class="full-col">
							<textarea placeholder="Content ..." name="slides[<?php echo $i ?>][content]"><?php echo htmlentities(utf8_decode($item['content'])) ?></textarea>							
						</div>
					</div>

					<div class="row">
						<div class="fixed">
							<?php echo $this->render_field('slides[' . $i . '][button_text]', $item['button_text'], 'Button Text (optional)', 'button-text') ?>
						</div>

						<div class="full-col">
							<?php echo $this->render_field('slides[' . $i . '][button_link]', $item['button_link'], 'Button Link (optional)', 'button-link') ?>							
						</div>
					</div>

					<div class="cl"></div>
				</div><!-- /.content -->
			</li>
			<?php
		} ?>
	</ul>

	<input type="hidden" name="slides_order" value="<?php echo esc_attr(implode(',', array_keys($items))) ?>" class="order-field" />
</div>