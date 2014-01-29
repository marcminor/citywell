<div class="cs-settings">
	<h4>Slider Type</h4>

	<ul>
		<?php foreach($options as $val => $label) {
			$checked = ($val == $current || (!$current && $val == 'one-by-one')) ? ' checked="checked"' : '';

			echo '<li>
				<label>
					<input type="radio" name="slider_type" value="' . esc_attr($val) . '"' . $checked . ' />
					' . $label . '
				</label>
			</li>';
		} ?>
	</ul>
</div>