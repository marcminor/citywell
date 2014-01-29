<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetRecentTweets extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetRecentTweets() {
		$widget_opts = array(
			'classname' => 'theme-widget-recent-tweets', // class of the <li> holder
			'description' => __( 'Displays recent tweets from a username.','savior' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-recent-tweets', __('[SAVIOR] Recent Tweets','savior'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Recent Tweets','savior')
			),
			array(
				'name'=>'twitter_user',
				'type'=>'text',
				'title'=>'Twitter Username', 
				'default'=>''
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many total items?','savior'), 
				'default'=>'15'
			),
			array(
				'name'=>'show',
				'type'=>'integer',
				'title'=>__('How many visible items?','savior'), 
				'default'=>'4'
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
				'name'=>'show_icon',
				'type'=>'set',
				'title'=>'Show Twitter Icon?', 
				'default'=>true,
				'options'=>array(true=>'Yes')
			),
			array(
				'name'=>'scrollable_list',
				'type'=>'set',
				'title'=>'Scrollable List', 
				'default'=>true,
				'options'=>array(true=>'Yes')
			),
		);
	}

	/**
	 * Outputs a description before the widget form,
	 * instructing the users to enter options
	 */
	function get_description() {
		return __( 'Please make sure that you have your application settings entered in the Twitter Settings tab at <a href="' . admin_url( 'themes.php?page=options-framework' ) . '">Theme Options</a>.', 'gymboom' );
	}

	/**
	 * Don't display the widget if settings aren't okay
	 */
	function widget( $args, $instance ) {
		$savior = get_option( 'savior' );
		$option_names = array( 'twitter_oauth_access_token', 'twitter_oauth_access_token_secret', 'twitter_consumer_key', 'twitter_consumer_secret' );
		foreach ( $option_names as $optname )
			if ( ! isset( $savior[ $optname ] ) )
				return;

		parent::widget( $args, $instance );
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
	
		extract($args);
		
		$tweets = intval($instance['load']);
		$title = $instance['title'];
		$twitter_user = $instance['twitter_user'];
		$button_text = $instance['button_text'];
		$button_url = $instance['button_url'];
		$new_window = $instance['new_window'];
		$scrollable_list = $instance['scrollable_list'];
		$show = $instance['show'];
		$show_icon = $instance['show_icon'];
		if ($scrollable_list || $button_url || $button_text) { $load = $show; }
		$random_number = rand(100,999);
		
		$tweet_data = TwitterHelper::get_tweets($instance['twitter_user'], $instance['load']);
		
		?><div id="<?php echo $twitter_user; ?>-<?php echo $random_number; ?>-wrap" class="tweets-widget" rel="<?php echo intval($show); ?>"><?php
			
			echo $before_title.($show_icon ? '<span class="icon"></span>' : '').$title.$after_title; ?>
			
			<?php if ($button_url || $button_text || !$scrollable_list){
				
				if ($button_url || $button_text) {
			
					?><a href="<?php echo $button_url; ?>"<?php if ($new_window){ ?>target="_blank"<?php } ?> class="widget-button"><?php echo $button_text; ?></a><?php
			
				}	
					
			} else {
			
				?><span class="prev"></span>
				<span class="next"></span><?php
			
			} ?>
		
			<div id="<?php echo $twitter_user; ?>-<?php echo $random_number; ?>" class="tweets-container">
				<ul>
				<?php foreach ($tweet_data as $tweet): ?>
					<li><span class="tweet_text"><?php echo $tweet->tweet_text ?></span><span class="tweet_time"><?php echo $tweet->time_distance ?> ago</span></li>
				<?php endforeach ?>
				</ul>
			</div>
		
		</div><?php
		
	}
}

?>