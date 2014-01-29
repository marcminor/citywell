<?php

// Upcoming Events
// ----------------------------------------------------
class ThemeWidgetUpcomingEvents extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetUpcomingEvents() {
	
		global $aec;
		$aec_categories = $aec->db_query_categories();
		
		foreach($aec_categories as $category){
			$aec_category_array[$category->id] = $category->category;
		}
		
		$widget_opts = array(
			'classname' => 'theme-widget-upcoming-events', // class of the <li> holder
			'description' => __( 'Display one or more upcoming events.','savior'));
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-widget-upcoming-events', __('[SAVIOR] Upcoming Events','savior'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>__('Title','savior'), 
				'default'=>__('Upcoming Events','savior')
			),
			array(
				'name'=>'event_categories',
				'type'=>'set',
				'options'=>$aec_category_array,
				'title'=>__('Event Categories','gymboom'), 
				'default'=>false
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many total items?','savior'), 
				'default'=>'10'
			),
			array(
				'name'=>'show',
				'type'=>'integer',
				'title'=>__('How many visible items?','savior'), 
				'default'=>'3'
			),
			array(
				'name'=>'button_text',
				'type'=>'text',
				'title'=>'Button Text (optional)', 
				'default'=>''
			),
			array(
				'name'=>'button_url',
				'type'=>'text',
				'title'=>'Button URL (optional)', 
				'default'=>''
			),
			array(
				'name'=>'new_window',
				'type'=>'set',
				'title'=>'Open button URL in a new window?', 
				'default'=>'',
				'options'=>array(true=>'Yes')
			),
			array(
				'name'=>'scrollable_list',
				'type'=>'set',
				'title'=>'Scrollable List', 
				'default'=>true,
				'options'=>array(true=>'Yes')
			)
		);
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
		
		$current_sidebar = $args['id'];
		if ($current_sidebar == 'homepage-horizontal-blocks') { $is_horizontal = true; } else { $is_horizontal = false; }
	
		extract($args);
		
		$limit = intval($instance['load']);
		$title = $instance['title'];
		$button_text = $instance['button_text'];
		$button_url = $instance['button_url'];
		$new_window = $instance['new_window'];
		$scrollable_list = $instance['scrollable_list'];
		$show = $instance['show'];
		if ($scrollable_list || $button_url || $button_text) { $load = $show; }
		
		$categories = $instance['event_categories'];
		if (is_array($categories)){ $categories = implode(',',$instance['event_categories']); } else { $categories = false; }
		
		$event_list = get_upcoming_events($limit,$categories);
		
		global $template_dir;
		
		if (!empty($event_list)):
		
			?><div class="events" rel="<?php echo intval($show); ?>"><?php
		
				echo $before_title.$title.$after_title; ?>
				
				<?php if ($button_url || $button_text || !$scrollable_list){
				
					if ($button_url || $button_text) {
				
						?><a href="<?php echo $button_url; ?>"<?php if ($new_window){ ?>target="_blank"<?php } ?> class="widget-button"><?php echo $button_text; ?></a><?php
				
					}	
						
				} else {
				
					?><span class="prev"></span>
					<span class="next"></span><?php
				
				} ?>
				
				<ul><?php
				
				foreach($event_list as $event):
			
					$start_date = strtotime($event['start']);
					$end_date = strtotime($event['end']);
					$start_date_local = date('Y-m-d H:i:s',strtotime($event['start']));
					$end_date_local = date('Y-m-d H:i:s',strtotime($event['end']));
					$title = stripslashes($event['title']);
					$venue = stripslashes($event['venue']);
					$allday = $event['allday'];
					
					$start_date_compare = date('Ymd',$start_date);
					$today = strftime('%Y%m%d',strtotime('now'));
					
					if (!$allday && $start_date_compare == $today){
						$start_time = date('Gi',$start_date);
						$end_time = date('Gi',$end_date);
						$current_time = strftime('%H%M');
						if ($start_time < $current_time){
							continue;
						}
					}
	
					$start_day = date('F j', $start_date);
					$end_day = date('F j', $end_date);
					
					if ($start_day == $end_day): $same_day = true; else: $same_day = false; endif;
						
					if (of_get_option('js_time_format') && of_get_option('js_time_format') == '24h'){
						$date_format = 'G:i';
					} else {
						$date_format = 'g:ia';
					} ?>
				
					<li>
						<a href="#" class="event-link" onclick="jQuery.aecDialog({'id':<?php echo $event['id']; ?>,'start':'<?php echo $event['start']; ?>','end':'<?php echo $event['end']; ?>'}); return false;">
							<span class="date-area"><?php echo mysql2date('M',$start_date_local); ?> <strong><?php echo mysql2date('d',$start_date_local); ?></strong></span>
							<h5><?php echo $title; ?></h5>
							<p><?php echo $venue; ?></p>
							<?php if ($allday): ?>
								<p><?php _e('All day','savior'); ?></p>
							<?php else : ?>
								<p class="ico-time"><?php echo date($date_format,$start_date); if ($same_day): echo ' - '.date($date_format,$end_date); endif; ?></p>
							<?php endif; ?>
						</a>
					</li>
					
				<?php endforeach;
					
				echo '</ul>';
	
			?></div><?php
			
		endif;
				
	}
}

?>