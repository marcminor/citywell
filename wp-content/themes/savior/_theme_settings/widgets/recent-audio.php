<?php

// Recent Media Items
// ----------------------------------------------------
class ThemeWidgetAudioItems extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetAudioItems() {
	
		$widget_opts = array(
			'classname' => 'theme-widget-audio-items', // class of the <li> holder
			'description' => __( 'Display one or more recent audio items.','savior'));
			
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		
		$args = array('type' => 'audio-item','taxonomy' => 'audio');
		$audio_categories = get_categories($args);
		
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-widget-audio-items', __('[SAVIOR] Recent Audio Items','savior'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>__('Title','savior'), 
				'default'=>__('Recent Sermons','savior')
			),
			array(
				'name'=>'categories',
				'type'=>'customCategories',
				'options'=>array(
					'post_type'=>'audio-item',
					'taxonomy'=>'audio'
				),
				'title'=>__('Audio Categories','savior'),
				'default'=>''
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
				'name'=>'sort_by',
				'type'=>'select',
				'title'=>'Sort by', 
				'default'=>'',
				'options'=>array(
					'rand'=>'Random',
					'name'=>'Title',
					'date'=>'Date Added',
					'menu_order'=>'Menu Order'
				)
			),
			array(
				'name'=>'order',
				'type'=>'select',
				'title'=>'Order', 
				'default'=>'',
				'options'=>array(
					'desc'=>'Descending',
					'asc'=>'Ascending'
				)
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
	
		extract($args);
		
		$limit = intval($instance['load']);
		$title = $instance['title'];
		
		$categories = $instance['categories'];
		$category_array = array();
		$category_list = array();
		
		$sort_by = $instance['sort_by'];
		$order = $instance['order'];

		$button_text = $instance['button_text'];
		$button_url = $instance['button_url'];
		$new_window = $instance['new_window'];
		$scrollable_list = $instance['scrollable_list'];
		$show = $instance['show'];
		if ($scrollable_list || $button_url || $button_text) { $load = $show; }
		
		if (!$categories) {
			$category_list = array();
			$audio_cats = get_categories(array('type' => 'audio-items','hide_empty'=>0,'taxonomy'=>'audio'));
			foreach($audio_cats as $audio_cat){
				$category_array[] = $audio_cat->slug;
			}
		} else {
			foreach($categories as $id){
				$term = get_term($id,'audio');
				$category_array[] = $term->slug;
			}
		}
			
		$all_posts = array(
			'post_type' => 'audio-items',
		    'posts_per_page' => $limit,
		    'audio' => implode(',',$category_array),
		    'orderby' => $sort_by,
		    'order' => $order
		);
		query_posts($all_posts);
		
		if ( have_posts() ) :
		
			?><div class="sermons-widget" rel="<?php echo intval($show); ?>"><?php
				
				echo $before_title.$title.$after_title; ?>

				<?php if ($button_url || $button_text || !$scrollable_list){
					
					if ($button_url || $button_text) {
				
						?><a href="<?php echo $button_url; ?>"<?php if ($new_window){ ?>target="_blank"<?php } ?> class="widget-button"><?php echo $button_text; ?></a><?php
				
					}	
						
				} else {
				
					?><span class="prev"></span>
					<span class="next"></span><?php
				
				} ?>

				<ul id="audio-<?php echo $widget_id; ?>"><?php
				
					$temp_counter = 0;
					while ( have_posts() ) : the_post(); global $post; $temp_counter++;
					
						if (get_post_meta($post->ID, '_file_mp3', true)){
							$audio_file = home_url() . '/wp-content/uploads/'.get_post_meta($post->ID, '_file_mp3', true);
						} else if (get_post_meta($post->ID, '_file_external_mp3', true)){
							$audio_file = get_post_meta($post->ID, '_file_external_mp3', true);
						} else {
							$audio_file = '';	
						} ?>
						
						<li>
							<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<h6>Posted on <?php the_time('F j, Y'); ?></h6>							
							<?php the_excerpt(); ?>
							<BR/><a href="#" class="button-small white play" data-src="<?php echo $audio_file; ?>"><?php _e('Play Audio','savior'); ?></a>


						</li><?php

					endwhile;
			
			?></ul></div><?php
						
		endif; wp_reset_query();
		
	}
}

?>