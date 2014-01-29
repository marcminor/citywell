<?php



// Page Layout
$page_layout = ECF_Field::factory('imageradio', 'page_layout', __('Page Layout','savior') );
$page_layout->add_options(array(
		'countdown_page_widgets'=>get_template_directory_uri().'/_theme_settings/images/page_layout_01.png',
		'widgets_page_countdown'=>get_template_directory_uri().'/_theme_settings/images/page_layout_02.png',
		'page_widgets_countdown'=>get_template_directory_uri().'/_theme_settings/images/page_layout_03.png',
		'page_countdown_widgets'=>get_template_directory_uri().'/_theme_settings/images/page_layout_04.png',
		'countdown_widgets_page'=>get_template_directory_uri().'/_theme_settings/images/page_layout_05.png',
		'widgets_countdown_page'=>get_template_directory_uri().'/_theme_settings/images/page_layout_06.png',
	))->help_text(__('Individual blocks can be hidden using the other options on this page.','savior'));
	
$page_options = ECF_Field::factory('set', 'page_options', __('Other Options','savior') );
$page_options->add_options(array('hide_breadcrumbs' => __('Hide the breadcrumbs above the title.','savior'), 'hide_title' => __('Hide the page title.','savior')));

$page_settings_panel = new ECF_Panel('page_settings_panel', __('Page Settings','savior'), 'page', 'normal', 'high');
$page_settings_panel->add_fields(array($page_layout,$page_options));



////////////////////////////////////////////////////////////////////////////////
// SLIDERS //

$revSliders = array(); $slider_items = array();

// Is the "Slider Revolution plugin installed?
if (class_exists('RevSlider')):

	// Get any "Slider Revolution" sliders that are built out, if any.
	$temp_count = 0;				
	$slider = new RevSlider();
	$arrSliders = $slider->getArrSliders();
	if (!empty($arrSliders)):
		foreach($arrSliders as $slider):
				
			$title = $slider->getTitle();
			$alias = $slider->getAlias();
			$revSliders['REVSLIDER---'.$alias] = 'REVOLUTION: '.$title;
			$temp_count++;
				
		endforeach;
	endif;
	
endif;

// Get the Espresso sliders
$slider_items = post_array('custom-slider');

// Add Revolution sliders to the array, if any
if (!empty($revSliders)):
	$slider_items = $revSliders + $slider_items;
	ksort($slider_items);
endif;

if (!empty($slider_items)):
	$slider_choice = ECF_Field::factory('select', 'slider_choice', __('Slider to display:','savior'));
	$slider_choice->add_options($slider_items);
	$slider_choice->help_text('<a href="post-new.php?post_type=custom-slider">'.__('Create a new slider','savior').'</a>');
endif;

$slider_speeds = array('normal' => 'Normal','fast' => 'Fast','slow' => 'Slow');
$slider_speed = ECF_Field::factory('select', 'slider_speed', __('Slider Animation Speed? <strong>Note:</strong> This only applies to the Savior sliders.','savior'));
$slider_speed->add_options($slider_speeds);
$slider_speed->help_text('How fast do you want the slider to animate? <strong>Note:</strong> This only applies to the Full Width sliders.');

$slider_autocycle = ECF_Field::factory('set', 'slider_autocycle', __('Auto-cycle the slider? <strong>Note:</strong> This only applies to the Savior sliders.','savior'));
$slider_autocycle->add_options(array(true => __('Yes','savior')));

$slider_intervals = array(	'8' => '8 (Default)',
							'1' => '1', '2' => '2', '3' => '3',
							'4' => '4', '5' => '5', '6' => '6',
							'7' => '7', '9' => '9',
							'10' => '10', '11' => '11', '12' => '12',
							'13' => '13', '14' => '14', '15' => '15',
							'16' => '16', '17' => '17', '18' => '18',
							'19' => '19', '20' => '20');
							
$slider_interval = ECF_Field::factory('select', 'slider_interval', __('Slider Interval:','savior'));
$slider_interval->add_options($slider_intervals);
$slider_interval->help_text('If auto-cycling, how many seconds between each slide? <strong>Note:</strong> This only applies to the Savior sliders.');

$slider_settings_panel = new ECF_Panel('slider_settings_panel', __('Slider Settings','savior'), 'page', 'normal', 'high');
$slider_settings_panel->add_fields(array($slider_choice,$slider_speed,$slider_autocycle,$slider_interval));



// Event Countdown Block
if (class_exists('ajax_event_calendar')) {
	// Disable the events when the module is not enabled in the administration
	$aec = ajax_event_calendar::get_instance();
	$event_array = events_dropdown_data($aec);
	
	if (!empty($event_array)):

		$countdown_type = ECF_Field::factory('select', 'countdown_type', __('Event to display:','savior'));
		$countdown_type->add_options($event_array);
		
		$countdown_order = ECF_Field::factory('select', 'countdown_order', __('Countdown Layout','savior'));
		$countdown_order->add_options(array(false=>'Default (Countdown, then Event Title)','flipped'=>'Event Title, then Countdown'));
		
		$countdown_pretext = ECF_Field::factory('text', 'countdown_pretext', 'Countdown Pretext');
		$countdown_pretext->help_text(__('"DEFAULT" is "Featured event in..." or "Next event in..." depending on the type of countdown &mdash; set a custom one here or leave blank to display no pretext."','savior'))->set_default_value('DEFAULT');
	
		$countdown_settings_panel = new ECF_Panel('countdown_settings_panel', __('Countdown Block Settings','savior'), 'page', 'normal', 'high');
		$countdown_settings_panel->add_fields(array($countdown_type,$countdown_order,$countdown_pretext));
		
	endif;
	
}


// Sidebar Settings
$sidebar_layout = ECF_Field::factory('imageradio', 'sidebar_layout', __('Sidebar Layout','savior') );
$sidebar_layout->add_options(array(
		'no-sidebar'=>get_template_directory_uri().'/_theme_settings/images/sidebar_none.png',
		'left'=>get_template_directory_uri().'/_theme_settings/images/sidebar_left.png',
		'right'=>get_template_directory_uri().'/_theme_settings/images/sidebar_right.png',
	));

global $wp_registered_sidebars;
$sidebar_dropdown_elements = array();
foreach($wp_registered_sidebars as $sidebar_id => $sidebar){
	$sidebar_dropdown_elements[$sidebar['id']] = $sidebar['name'];	
}

// Sidebar Choice
$sidebar_choice = ECF_Field::factory('select', 'sidebar_choice', __('Choose a sidebar:','savior'));
$sidebar_choice->add_options($sidebar_dropdown_elements);
	
$sidebar_settings_panel = new ECF_Panel('sidebar_settings_panel', __('Sidebar Settings','savior'), 'page', 'normal', 'high');
$sidebar_settings_panel->add_fields(array($sidebar_layout,$sidebar_choice));


// First Widget Row
$widget_layout_row_1 = ECF_Field::factory('imageradio', 'widget_layout', __('Widget Layout','savior') );
$widget_layout_row_1->add_options(array(
		'no-widgets'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_none.png',
		'one'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_one.png',
		'two'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_two.png',
		'three'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_three.png',
		'onethird_twothird'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_onethird_twothird.png',
		'twothird_onethird'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_twothird_onethird.png',
	));
	
// Widget Block 1
$widget_block_1_row_1 = ECF_Field::factory('select', 'widget_block_1', __('Widget Block for ZONE 1:','savior'));
$widget_block_1_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 2
$widget_block_2_row_1 = ECF_Field::factory('select', 'widget_block_2', __('Widget Block for ZONE 2:','savior'));
$widget_block_2_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 3
$widget_block_3_row_1 = ECF_Field::factory('select', 'widget_block_3', __('Widget Block for ZONE 3:','savior'));
$widget_block_3_row_1->add_options($sidebar_dropdown_elements);

$widget_settings_panel_row_1 = new ECF_Panel('widget_settings_panel', __('First Widget Row','savior'), 'page', 'normal', 'high');
$widget_settings_panel_row_1->add_fields(array($widget_layout_row_1,$widget_block_1_row_1,$widget_block_2_row_1,$widget_block_3_row_1));

?>