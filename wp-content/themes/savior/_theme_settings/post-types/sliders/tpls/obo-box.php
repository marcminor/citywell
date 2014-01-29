<div class="cslides">
	<a href="#" class="button-secondary add">Add a One-by-one Slide</a>

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

					$class = $item['title'] ? ' class="overall"' : ' class="overall inactive"';
					?>
					<h4<?php echo $class ?>><span class="title-text"><?php echo $text ?></span></h4>
				</div><!-- /.preview -->

				<div class="content">
					<div class="row obo-top-row">
						<div class="buttons">
							<a href="#" class="button-secondary add add-text">Add Text Block</a>
							<a href="#" class="button-secondary add add-image">Add Image</a>
						</div>
						<?php echo $this->render_field('obo_slides[' . $i . '][title]', $item['title'], 'Slide Title ...', 'title-field') ?>
					</div>

					<div class="cslides cparts">
						<ul class="sortable">
							<?php foreach($item['items'] as $k => $subitem) {
								$classes = array();

								if(isset($subitem['prototype'])) {
									$k = '%e%';
									$classes[] = 'prototype';
								}

								$classes[] = 'type-' . $subitem['type'];
								?>
								<li class="<?php echo implode(' ', $classes) ?>" data-id="<?php echo $k ?>" style="display:<?php echo isset($subitem['prototype']) ? 'none' : 'block' ?>">
									<span class="notext drag"></span>
									<a href="#" class="notext remove"></a>
									<a href="#" class="toggle"></a>

									<?php include($subitem['type'] . '-row.php') ?>

									<input type="hidden" name="obo_slides[<?php echo $i ?>][items][<?php echo $k ?>][type]" value="<?php echo $subitem['type'] ?>" />
								</li>
								<?php
							} ?>
						</ul>

						<input type="hidden" name="obo_slides[<?php echo $i ?>][items_order]" value="<?php echo esc_attr(implode(',', array_keys($item['items']))) ?>" class="order-field" />
					</div>

					<div class="cl"></div>
				</div><!-- /.content -->
			</li>
			<?php
		} ?>
	</ul>

	<input type="hidden" name="obo_slides_order" value="<?php echo esc_attr(implode(',', array_keys($items))) ?>" class="order-field" />
</div>