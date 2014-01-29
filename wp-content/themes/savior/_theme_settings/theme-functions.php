<?php

// Function for the slider images
function get_absolute_file_url( $url ) {
	if( is_multisite() ) {
	    global $blog_id;
	    $upload_dir = wp_upload_dir();
	    if( strpos( $upload_dir['basedir'], 'blogs.dir' ) !== false ) {
	        $parts = explode( '/files/', $url );
	        $url = '/wp-content/blogs.dir/' . $blog_id . '/files/' . $parts[ 1 ];
	    }
	}
	return $url;
}

// ------------------------------------------------------------
// Load Stylesheets, Scripts & Customizations
function savior_theme_styles_scripts()  
{

	global $load_slider_scripts;

	$template_dir = get_template_directory_uri();
	
	$highlight_color = of_get_option('js_highlight_color');
	if ($highlight_color){
		$highlight_color = explode('#',$highlight_color);
		$highlight_color = $highlight_color[1];
	} else {
		$highlight_color = 'c86300';
	}
	
	$main_bg_color = (of_get_option('js_main_bg_color') ? of_get_option('js_main_bg_color') : '#ffffff');
	$main_bg_color = explode('#',$main_bg_color);
	$main_bg_color = $main_bg_color[1];
	
	$text_color = (of_get_option('js_text_color') ? of_get_option('js_text_color') : '#333333');
	$text_color = explode('#',$text_color);
	$text_color = $text_color[1];
	
	$logo_height = of_get_option('js_logo_height');
	if (!$logo_height){ $logo_height = 109; }
	
	$logo_width = of_get_option('js_logo_width');
	if (!$logo_width){ $logo_width = 174; }
	
	$custom_font = of_get_option('js_custom_font');
	if (!$custom_font){ $custom_font = 'Open+Sans'; }
	
	$overall_style = of_get_option('js_overall_style');
	if ($overall_style && $overall_style == 'light'){ $custom_append = '-light'; } else { $custom_append = ''; }
	
	$responsive_disabled = (of_get_option('js_responsive_disabled') ? of_get_option('js_responsive_disabled') : 'no');
	
	// jQuery, because of course.
	if (!is_admin()) {
		wp_enqueue_script('jquery');
	}
	
	wp_register_style( 'onebyone', $template_dir . '/_theme_styles/jquery.onebyone.css', array(), '1.0', 'all' );
	wp_register_style( 'fancybox', $template_dir . '/js/fancybox/jquery.fancybox.css', array(), '1.0', 'all' );
	wp_register_style( 'custom-google-fonts', 'http://fonts.googleapis.com/css?family='.$custom_font.':100,200,300,400,500,600,700,800&subset=latin,cyrillic-ext,cyrillic,greek-ext,vietnamese,latin-ext', array(), '1.0', 'all');
	wp_register_style( 'custom-stylesheet', get_bloginfo('stylesheet_url'), array(), '1.0', 'all' );
	if ($responsive_disabled != 'yes'){ wp_register_style( 'custom-responsive', $template_dir . '/_theme_styles/responsive.css', array(), '1.0', 'all' ); }
	wp_register_style( 'customized-styles', $template_dir . '/_theme_styles/custom'.$custom_append.'.php?bg_color='.$main_bg_color.'&text_color='.$text_color.'&color='.$highlight_color.'&font='.$custom_font, array(), '1.0', 'all');

  	wp_enqueue_style( 'onebyone' );
  	wp_enqueue_style( 'fancybox' );
  	wp_enqueue_style( 'custom-google-fonts' );
  	wp_enqueue_style( 'custom-stylesheet' );
  	if ($responsive_disabled != 'yes'){ wp_enqueue_style( 'custom-responsive' ); }
  	wp_enqueue_style( 'customized-styles' );
 
	// Scripts, to make it flow	
	wp_enqueue_script('customModernizr', $template_dir . '/js/modernizr.js', array(), '2.6.0', false);
	wp_enqueue_script('fancybox', $template_dir . '/js/fancybox/jquery.fancybox.pack.js', array(), '1.0', true);
	wp_enqueue_script('audioPlayer', $template_dir . '/js/audio-player.js', array(), '1.0', true);
	wp_enqueue_script('carouFredSel', $template_dir . '/js/jquery.carouFredSel-6.1.0-packed.js', array(), '1.0', true);
	wp_enqueue_script('easing', $template_dir . '/js/jquery.easing.1.3.js', array(), '1.0', true);
	wp_enqueue_script('onebyone', $template_dir . '/js/jquery.onebyone.min.js', array(), '1.0', true);
	wp_enqueue_script('placeholders', $template_dir . '/js/jquery.placeholders-1.0.js', array(), '1.0', true);
	wp_enqueue_script('touchwipe', $template_dir . '/js/jquery.touchwipe.min.js', array(), '1.0', true);
	wp_enqueue_script('countdown', $template_dir . '/js/jquery.countdown.min.js', array(), '1.0', true);
	wp_enqueue_script('tweet', $template_dir . '/js/jquery.tweet.js', array(), '1.0', true);

	if (of_get_option('js_countdown_language') && of_get_option('js_countdown_language') != "english"){
		wp_enqueue_script('tweet', $template_dir . '/js/countdown_languages/'.of_get_option('js_countdown_language').'.js', array(), '1.0', true);
	}
	
	wp_enqueue_script('customFunctions', $template_dir . '/js/functions.js', array(), '1.0', true);

}

add_action('wp_enqueue_scripts', 'savior_theme_styles_scripts');

// ------------------------------------------------------------
// Savior Slider

	function savior_slider($post){
	
		global $template_dir, $load_slider_scripts;
	
		$slider_choice = get_post_meta($post->ID, '_slider_choice', true);
		$alias_split = explode('---',$slider_choice);
		$alias_type = $alias_split[0];
		
		// Revolution Slider?
		if ($alias_type == 'REVSLIDER'):
		
			$alias_name = $alias_split[1];
			putRevSlider($alias_name);
		
		// Savior Slider?
		else :
	
			if ($slider_choice):
	
				$type = get_post_meta($slider_choice, '_slider_type', true);
		
				if($type == 'one-by-one'):
				?>
				<div id="slider">
					<div class="shell">
						<?php
						$items = get_post_meta($slider_choice, '_obo_slides', true);
						$animations = array('fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'fadeInLeftBig', 'fadeInRightBig', 'fadeInUpBig', 'fadeInDownBig', 'flipInX', 'flipInY', 'lightSpeedIn');
		
						foreach($items as $item) {
							echo '<div class="oneByOne_item">';
							foreach($item['items'] as $i) {
								if($i['type'] == 'image') {
									if(!$i['image_id']) {
										continue;
									}
									
									$i['left'] = str_replace('px','',$i['left']);
									$i['top'] = str_replace('px','',$i['top']);
		
									$atts = array(
										'style' => "position:absolute;left:" . $i['left'] . "px;top:" . $i['top'] . "px;"
									);
		
									if($i['animation']) {
										if(!$i['animation']) {
											$i['animation'] = array_rand($animations) + 1;
										}
		
										$atts['data-animate'] = $animations[$i['animation']-1];
									}
									
									$image_url = (isset($i['image_url']) ? $i['image_url'] : '');
									if ($image_url && $atts['data-animate']){
										$linked_animation = $atts['data-animate'];
										$linked_style = $atts['style'];
										$atts['data-animate'] = null;
										$atts['style'] = 'position:relative;';
									} else {
										$linked_animation = '';
										$linked_style = '';
									}
									
									
									echo ($image_url ? '<a'.($linked_style ? ' style="'.$linked_style.'"' : '').' href="'.$image_url.'"'.($linked_animation ? ' data-animate="'.$linked_animation.'"' : '').'>' : '');
									echo str_replace('files','files/',wp_get_attachment_image($i['image_id'], 'full', false, $atts));
									echo ($image_url ? '</a>' : '');
								
								} else {
									if($i['button_text'] && $i['button_link']) {
										$button = '<a href="' . esc_attr($i['button_link']) . '" class="button-mini">' . $i['button_text'] . '</a>';
									} else {
										$button = '';
									}
									
									if($i['animation']) {
										if(!$i['animation']) {
											$i['animation'] = array_rand($animations) + 1;
										}
		
										$text_animation = $animations[$i['animation']-1];
									}
									
									$i['left'] = str_replace('px','',$i['left']);
									$i['top'] = str_replace('px','',$i['top']);
									$i['width'] = str_replace('px','',$i['width']);
		
									if(!$i['width']){
										$width = 300;
									} else {
										$width = $i['width'];
									}
		
									echo '<div class="text" data-animate="'.$text_animation.'" style="width:'.$width.'px; top:'.$i['top'].'px; left:'.$i['left'].'px;">
											' . ($i['title'] ? '<h3>' . $i['title'] . '</h3>' : '') . '
											' . wpautop(do_shortcode($i['content'])) . '
											' . $button . '
										</div>';
								}
							}
							echo '</div>';
						}
						?>
					</div>
				</div>
				
				<?php else:
					
				// Get text styling
				$slider_styling = (of_get_option('js_fullwidth_slider_styling') ? of_get_option('js_fullwidth_slider_styling') : 'floating'); ?>
				
				<div id="<?php echo $type == 'full-width' ? 'full-slider' : 'full-slider-behind' ?>" class="<?php echo $slider_styling; ?>"<?php if (of_get_option('js_top_bar_disabled') && $type == 'behind-header'): ?> style="top:0 !important;"<?php endif; ?>>
					
					<?php
					$items = get_post_meta($slider_choice, '_slides', true);
					if($type == 'full-width'): echo '<span class="line"></span>'; endif;
					
					$item_count = count($items); if ($item_count > 1): ?>
						<span class="prev"></span>
						<span class="next"></span>
					<?php endif; ?>
					
					<div class="container">
						<ul>
							<?php foreach($items as $i) {
								echo '<li>';
								
								if($i['button_text'] && $i['button_link']) {
									$button = '<a href="' . esc_attr($i['button_link']) . '" class="button-mini">' . $i['button_text'] . '</a>';
								} else {
									$button = '';
								}
		
								if($i['image_id']) {
									$src = wp_get_attachment_image_src($i['image_id'], 'full');
									$src = get_absolute_file_url( $src[0] );
									$src = $template_dir . '/_theme_settings/post-types/sliders/timthumb.php?w=2000&h=536&zc=1&src=' . urlencode($src);
									if(!$i['button_text'] && $i['button_link']) { echo '<a href="'.$i['button_link'].'">'; }
									echo '<img src="' . esc_attr($src) . '" alt="" width="2000" height="536" />';
									if(!$i['button_text'] && $i['button_link']) { echo '</a>'; }
								}
								
								if($i['content'] && $slider_styling == 'floating') {
								
									$pieces = array();
									$words = explode(' ', $i['content']);
									
									$row = '';
									$max_chars = 75;
									foreach($words as $w) {
										if(strlen($row . ' ' . $w) > $max_chars) {
											$pieces[] = $row;
											$row = '';
										}
		
										$row .= $w . ' ';
									}
									$pieces[] = $row;
		
									$content = '<p><span>' . implode('</span><span>', $pieces) . '</span></p>'.$button;
									
									echo '<div class="text">
										' . ($i['title'] ? '<h3><span>' . $i['title'] . '</span></h3>' : '') . '
										' . $content . '
									</div>';
									
								} else if ($i['content'] && $slider_styling == 'boxed-black' || $i['content'] && $slider_styling == 'boxed-white'){
									
									$content = '<div class="caption '.$slider_styling.'"><div class="shell">' . ($i['title'] ? '<h3><span>' . $i['title'] . '</span></h3>' : '') . '<p>' . $i['content'] . '</p>'.$button.'</div></div>';
									echo $content;
									
								} else {
								
									$content = '';
									
								}
								
								echo '</li>';
							} ?>
						</ul>
					</div>
				</div><?php
					
				endif;
				
			endif;
		
		endif;
	
	}

// End Savior Slider
// ------------------------------------------------------------



// ------------------------------------------------------------
// Add Thumbnails to Page/Post management screen

	if ( !function_exists('AddThumbColumn') && function_exists('add_theme_support') ) {
	
	    function AddThumbColumn($cols) {
	        $cols['thumbnail'] = __('Featured Image','savior');
	        return $cols;
	    }
	    function AddThumbValue($column_name, $post_id) {
	        if ( 'thumbnail' == $column_name ) {
	        
	        	if (has_post_thumbnail( $post_id )) :
					$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'gallery-small' );
					if (is_array($image_url)) { $image_url = $image_url[0]; }
				endif;
	        
	            if ( isset($image_url) && $image_url ) {
	                echo '<img style="border-radius:3px; margin:5px 0;" src="'.$image_url.'" width="100" />';
	            } else {
	                echo __('None','savior');
	            }
	            
	        }
	    }
	    
	    // for posts
	    add_filter( 'manage_posts_columns', 'AddThumbColumn' );
	    add_action( 'manage_posts_custom_column', 'AddThumbValue', 10, 2 );
	    
	    // for pages
	    add_filter( 'manage_pages_columns', 'AddThumbColumn' );
	    add_action( 'manage_pages_custom_column', 'AddThumbValue', 10, 2 );
	    
	}

// End Thumbnails
// ------------------------------------------------------------



// ------------------------------------------------------------
// Convert Youtube/Vimeo Links to iFrames

	function video_link_to_iframe($video_link = '',$w = 940,$h = 529,$full_iframe = true){
		$vimeo = strpos($video_link,'vimeo');
		$youtube_normal = strpos($video_link,'youtube');
		$youtube_short = strpos($video_link,'youtu.be');
										
		if ($youtube_normal != false){
			$video_link = str_replace(array('www.','http://youtube.com/watch?v=','https://youtube.com/watch?v='),'',$video_link);
			$video_link = explode('&',$video_link);
			$video_link = $video_link[0];
			if ($full_iframe){
				$video_string = '<iframe class="vid-frame" width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.$video_link.'?rel=0&amp;wmode=transparent" frameborder="0"></iframe>';
			} else {
				$video_string = 'http://www.youtube.com/embed/'.$video_link.'?rel=0&amp;wmode=transparent&amp;autoplay=1';
			}
		} else if ($youtube_short != false){
			$video_link = str_replace(array('www.','http://youtu.be/','https://youtu.be/'),'',$video_link);
			$video_link = explode('&',$video_link);
			$video_link = $video_link[0];
			if ($full_iframe){
				$video_string = '<iframe class="vid-frame" width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.$video_link.'?rel=0&amp;wmode=transparent" frameborder="0"></iframe>';
			} else {
				$video_string = 'http://www.youtube.com/embed/'.$video_link.'?rel=0&amp;wmode=transparent&amp;autoplay=1';
			}	
		} else if ($vimeo != false){
			$video_link = str_replace(array('www.','http://vimeo.com/','https://vimeo.com/'),'',$video_link);
			if ($full_iframe){
				$video_string = '<iframe class="vid-frame" src="http://player.vimeo.com/video/'.$video_link.'?portrait=0" width="'.$w.'" height="'.$h.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			} else {
				$video_string = 'http://player.vimeo.com/video/'.$video_link.'?portrait=0&amp;autoplay=1';
			}
		} else {
			$video_string = '';
		}
		return $video_string;
	}

// End Convert Youtube/Vimeo Links
// ------------------------------------------------------------



// ------------------------------------------------------------
// Gallery Functions

	function js_display_gallery_item($post_thumbnail = '',$image_title = '',$post_link = '',$echo = true,$right = false,$post_id = ''){
	
		$attachments = get_children(array('post_parent'=>$post_id));
		$nbImg = count($attachments);
	
		$gallery_content = '';
		$gallery_content .= '<a';
		if ($right == true) { $gallery_content .= ' class="right"'; }
		$gallery_content .= ' title="'.$image_title.'" href="'.$post_link.'">';
		$gallery_content .= '<img alt="'.$image_title.'" src="'.$post_thumbnail.'" />';
		$gallery_content .= '<span class="img-title">'.$image_title.'<span class="cap"></span></span>';
		$gallery_content .= '<span class="img-cap"></span>';
		$gallery_content .= '<span class="count">'.$nbImg.'</span>';
		$gallery_content .= '</a>';
		
		if ($echo) { echo $gallery_content; } else { return $gallery_content; }
	}
	
	function js_display_gallery_photo($full_image_src = '',$image_caption = '',$post_thumbnail = '',$size = 'medium', $echo = true, $right = false, $last = false){
	
		$gallery_content = '';
		
		$gallery_content .= '<figure class="image '.$size.($last ? ' last' : '').'">';
			$gallery_content .= '<a rel="gallery" title="'.$image_caption.'" href="'.$full_image_src.'" class="fancybox"><img src="'.$post_thumbnail.'" alt="" /><span class="plus"></span></a>';
			$gallery_content .= '<figcaption>'.$image_caption.'</figcaption>';
		$gallery_content .= '</figure>';
		
		if ($echo) { echo $gallery_content; } else { return $gallery_content; }
	}

// End Gallery Functions
// ------------------------------------------------------------



// ------------------------------------------------------------
// Pagination

	function js_get_pagination($args = null) {
		global $wp_query;
		
		$total_pages = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		
		if ($total_pages > 1){
		
			echo '<div id="pagination">';
				echo paginate_links( array(
					'base' => @add_query_arg('paged','%#%'),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'type' => 'list',
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
				));
			echo '</div>';
		
		}
		
	}

// End Pagination
// ------------------------------------------------------------



// ------------------------------------------------------------
// Top/Bottom Bar Content

	function display_top_right_content(){
		$top_right_content_type = (of_get_option('js_top_right_content_type') ? of_get_option('js_top_right_content_type') : 'search');
		switch($top_right_content_type){
		
			case 'search' :
				echo '<form action="'.site_url().'" method="get" id="search-form">';
				echo '<input name="s" type="text" class="field" placeholder="Search..." />';
				echo '<input type="submit" class="submit" value="GO" />';
				echo '</form>';
				break;
				
			case 'social' :
				js_social_icons();
				break;
				
			case 'text' :
				echo '<ul class="right">';
				echo '<li>'.(of_get_option('js_top_right_text') ? of_get_option('js_top_right_text') : '').'</li>';
				echo '</ul>';
				break;
				
			case 'woocommerce' :
				global $woocommerce;
				if ($woocommerce):
				?><ul class="right">
				<li><a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a></li>
				</ul><?php
				endif;
				break;
				
		}
	}
	
	function display_top_left_content(){
		echo '<ul>';
		echo '<li>'.(of_get_option('js_top_left_text') ? of_get_option('js_top_left_text') : '').'</li>';
		echo '</ul>';	
	}
	
	function display_bottom_right_content(){
		$top_right_content_type = (of_get_option('js_bottom_right_content_type') ? of_get_option('js_bottom_right_content_type') : 'social');
		switch($top_right_content_type){
		
			case 'social' :
				js_social_icons();
				break;
				
			case 'text' :
				echo '<p>'.(of_get_option('js_bottom_right_text') ? str_replace('[year]',date('Y'),of_get_option('js_bottom_right_text')) : '').'</p>';
				break;
				
		}
	}
	
	function display_bottom_left_content(){
		echo '<p>'.(of_get_option('js_bottom_left_text') ? nl2br(str_replace('[year]',date('Y'),of_get_option('js_bottom_left_text'))) : '').'</p>';
	}

// End Top/Bottom Bar Content
// ------------------------------------------------------------



// ------------------------------------------------------------
// Social Icons

	function js_social_icons(){
		
		if (of_get_option('js_social_icon_facebook') || of_get_option('js_social_icon_twitter') || of_get_option('js_social_icon_linkedin') || of_get_option('js_social_icon_vimeo') || of_get_option('js_social_icon_youtube') || of_get_option('js_social_icon_rss')):
			echo '<ul class="socials right">';
				echo (of_get_option('js_social_icon_facebook') ? '<li class="facebook"><a href="'.of_get_option('js_social_icon_facebook').'">Facebook</a></li>' : '');
				echo (of_get_option('js_social_icon_twitter') ? '<li class="twitter"><a href="'.of_get_option('js_social_icon_twitter').'">Twitter</a></li>' : '');
				echo (of_get_option('js_social_icon_linkedin') ? '<li class="linkedin"><a href="'.of_get_option('js_social_icon_linkedin').'">LinkedIn</a></li>' : '');
				echo (of_get_option('js_social_icon_vimeo') ? '<li class="vimeo"><a href="'.of_get_option('js_social_icon_vimeo').'">Vimeo</a></li>' : '');
				echo (of_get_option('js_social_icon_youtube') ? '<li class="youtube"><a href="'.of_get_option('js_social_icon_youtube').'">YouTube</a></li>' : '');
				echo (of_get_option('js_social_icon_rss') ? '<li class="rss"><a href="'.of_get_option('js_social_icon_rss').'">Feed</a></li>' : '');
			echo '</ul>';
		endif;
	
	}
	
	function js_social_buttons(){
	
		$hide_facebook = of_get_option('js_hide_facebook_like');
		$hide_twitter = of_get_option('js_hide_twitter_tweet');
		$hide_google = of_get_option('js_hide_google_plus');
	
		if (!$hide_google || !$hide_twitter || !$hide_facebook) {
	
		?><div class="social-buttons">
								
			<?php if (!$hide_google){ ?>
			<!-- Google +1 -->
			<div class="google-plusone"><div class="g-plusone" data-size="medium"></div></div>
			<script src="<?php echo get_template_directory_uri(); ?>/js/google_plusone_script.js" type="text/javascript"></script>
			<?php } ?>
			
			<?php if (!$hide_twitter){ ?>
			<!-- Twitter Tweet -->
			<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-via="">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
			<?php } ?>
			
			<?php if (!$hide_facebook){ ?>
			<!-- Facebook Like -->
			<div id="fb-root"></div><script src="<?php echo get_template_directory_uri(); ?>/js/fb_like_script.js" type="text/javascript"></script>
			<div class="fb-like" data-send="false" data-width="380" data-show-faces="false"></div>
			<?php } ?>
			
			<div class="clearboth"></div>
			
		</div><?php
		
		}
	
	}

// End Social Icons
// ------------------------------------------------------------



// ------------------------------------------------------------
// Event Functions

	function get_upcoming_events($amount = 1,$categories = false){
		
		global $aec;
	
		$excluded = false;
		$limit = false;
		$whitelabel = false;
		$start = date('Y-m-d',strtotime('now'));
		$end = date('Y-m-d', strtotime('+20 year'));
		
		$event = $aec->db_query_events($start, $end, $categories, $excluded, $limit);
		$event = $aec->process_events($event, $start, $end, true);
		
		if (!empty($event)){
			usort($event, array($aec, 'array_compare_order'));
			$rows = $aec->convert_array_to_object($event);
		} else {
			return false;
		}
		
		if ($amount == 1):
			foreach($rows as $item):
				
				$start_date_compare = date('Ymd',strtotime($item->start));
				$today = strftime('%Y%m%d',strtotime('now'));
				
				if ($start_date_compare == $today){
					$start_time = date('Gi',strtotime($item->start));
					$current_time = strftime('%H%M');
					if ($start_time > $current_time){
						return $item;
					}
				} else {
					
					return $item;
				
				}
				
			endforeach;
		else :
			$events = array();
			$temp_count = 0;
			foreach($rows as $item):
			
				$event = $aec->db_query_event($item->id);
			
				if ($temp_count == $amount): break; endif;
				$temp_count++;
				$events[$temp_count]['id'] = $event->id;
				$events[$temp_count]['title'] = $event->title;
				if (isset($item->allDay)) $events[$temp_count]['allday'] = $item->allDay;
				$events[$temp_count]['start'] = $item->start;
				$events[$temp_count]['end'] = $item->end;
				$events[$temp_count]['venue'] = $event->venue;
				
			endforeach;
			return $events;
		endif;
	}
	
	function featured_event($featured_event){
	
		global $aec;
		
		$start = date('Y-m-d');
		$end = date('Y-m-d', strtotime(date("Y-m-d", strtotime($start)) . "+1 year"));
		
		$events	= $aec->db_query_events($start, $end, false,false,false);
		$events = $aec->process_events($events, $start, $end, true);
		
		if (!empty($events)){
			foreach($events as $event){
			
				if ($event['id'] == $featured_event){
					return $event;
				}
				
			}
		} else {
			return false;
		}
		
	}
	
	function single_event_display($event){
		$start_date = (isset($event['start']) ? strtotime($event['start']) : '');
		$end_date = (isset($event['end']) ? strtotime($event['end']) : '');
		$start_date_local = (isset($event['start']) ? date('Y-m-d H:i:s',strtotime($event['start'])) : '');
		$end_date_local = (isset($event['end']) ? date('Y-m-d H:i:s',strtotime($event['end'])) : '');
		$title = (isset($event['title']) ? stripslashes($event['title']) : '');
		$venue = (isset($event['venue']) ? stripslashes($event['venue']) : '');
		$allday = (isset($event['allday']) ? $event['allday'] : '');
		
		$start_date_compare = date('Ymd',$start_date);
		$today = strftime('%Y%m%d',strtotime('now'));
		
		if (!$allday && $start_date_compare == $today){
			$start_time = date('Gi',$start_date);
			$end_time = date('Gi',$end_date);
			$current_time = strftime('%H%M');
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
		</li><?php
	}
	
	function events_dropdown_data($aec){
	
		$categories	= false;
		$excluded = false;
		$limit = false;
		$whitelabel = true;
		$start = date('Y-m-d');
		$end = date('Y-m-d', strtotime(date("Y-m-d", strtotime($start)) . "+1 year"));
		
		$events	= $aec->db_query_events($start, $end, $categories, $excluded, $limit);
		$events = $aec->process_events($events, $start, $end, true);
		if (!$events) {
			return array();
		}
		$temp_count = 0;
		$ids_added = array();
		
		$select_data[0] = 'No event countdown';
		$select_data['next'] = '[Show the next upcoming event]';
		
		foreach($events as $event){
		
			if (!in_array($event['id'], $ids_added)):
				$ids_added[] = $event['id'];
				$select_data[$event['id']] = $event['title'];
			endif;
			
		}
		
		return $select_data;
		
	}
	
	function js_countdown_block(){
		
		$current_date = date(current_time('mysql'));
		$current_timestamp = strtotime($current_date) * 1000;
				
		$all_posts = array(
			'post_type' => 'event-items',
		    'posts_per_page' => 1,
		    'orderby' => 'meta_value',
		    'meta_key' => '_start_date',
		    'order' => 'ASC',
		);
		
		query_events(false,$all_posts);
			
		if ( have_posts() ) : while ( have_posts() ) : the_post();
		
			global $post;
		
			$start_date = strtotime(get_post_meta($post->ID,'_start_date_visual',true)); ?>
			
			<section id="countdown">
				<h2><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo substr(get_the_title($post->ID),0,45); if (strlen(get_the_title($post->ID)) > 45){ echo '...'; } ?></a></h2>
				<h3><?php echo date('F j, Y G i Z',$start_date); ?></h3>
			</section>
		
		<?php endwhile; endif; wp_reset_query();
		
	}

// End Event Functions
// ------------------------------------------------------------



// ------------------------------------------------------------
// Breadcrumb Display

	function js_breadcrumbs($post_id = ''){
	
		$hide_breadcrumbs = false;
	
		if (is_page()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_pages');
		} else if (is_search()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_search');
		} else if ('gallery-items' == get_post_type()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_galleries');
		} else if ('video-items' == get_post_type()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_videos');
		} else if ('audio-items' == get_post_type()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_audio');
		} else if (is_single()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_posts');
		}
		
		if ($hide_breadcrumbs != 1){
	
			$breadcrumbs = '<p id="breadcrumbs"><a href="'.home_url().'">Home</a>';
			
			if (is_page()){
			
				$ancestors = get_post_ancestors($post_id);
				$ancestors = array_reverse($ancestors);
				if (!empty($ancestors)){
					foreach($ancestors as $page_id){
						$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.get_permalink($page_id).'">'.get_the_title($page_id).'</a>';
					}
				}
			
			} else if (is_search()){
			
				$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;Search Results';
			
			} else if ('gallery-items' == get_post_type()){
			
				if (of_get_option('js_default_galleries_breadcrumb')){
					if (!is_tax()){
						$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.of_get_option('js_default_galleries_breadcrumb').'">'.(of_get_option('js_default_galleries_title') ? of_get_option('js_default_galleries_title') : 'Galleries').'</a>';
					}
				} else {
					if (is_tax()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.home_url().'/galleries/">Galleries</a>'; } else
					if (is_archive()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;Galleries'; } else {
					$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.home_url().'/galleries/">Galleries</a>'; }
				}
			
			} else if ('video-items' == get_post_type()){
			
				if (is_tax()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.home_url().'/videos/">Videos</a>'; } else
				if (is_archive()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;Videos'; } else {
				$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.home_url().'/videos/">Videos</a>'; }
			
			} else if ('audio-items' == get_post_type()){
			
				if (is_tax()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.home_url().'/audio/">Audio</a>'; } else
				if (is_archive()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;Audio'; } else {
				$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.home_url().'/audio/">Audio</a>'; }
			
			} else if (is_single()){
				
				$categories = get_the_category();
				$cat_name = $categories[0]->cat_name;
				$cat_link = get_category_link($categories[0]->cat_ID);
		
				$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.$cat_link.'">'.$cat_name.'</a>';
				
			}
			
			if (!is_tax() && !is_archive()){
			
				$original_title = get_the_title($post_id);
				$shortened_title = substr(get_the_title($post_id), 0, 75);
				
				$orig_length = strlen($original_title);
				$new_length = strlen($shortened_title);
				
				$dots = ''; if ($new_length < $orig_length) { $dots = '...'; }
				
				$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;'.$shortened_title.$dots.'</p>';
				
			} else if (is_tax()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;'.single_cat_title('',false).'</p>'; }
			
			echo $breadcrumbs;
			
		}
		
	}

// End Breadcrumb Display
// ------------------------------------------------------------



// ------------------------------------------------------------
// Misc Functions

	function add_admin_menu_separator($position) {
		global $menu;
		$index = 0;
		if ($menu) {
			foreach($menu as $offset => $section) {
				if (substr($section[2],0,9)=='separator')
					$index++;
				if ($offset>=$position) {
					$menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
					break;
				}
			}
		}
	}

	function main_menu_message(){ echo '<span style="top:0; display:block; position:relative; text-align:right; font-size:15px; color:#fff;">Please <a style="color:#c86300;" href="'.home_url().'/wp-admin/nav-menus.php">create and set a menu</a> for the main navigation.</span>'; }
	
	// Fix <p>'s and <br>'s from showing up around shortcodes.
	add_filter('the_content', 'js_empty_paragraph_fix');
	function js_empty_paragraph_fix($content)
	{   
	    $array = array ( '<p>[' => '[', ']</p>' => ']', ']<br />' => ']' );
	    $content = strtr($content, $array);
	    return $content;
	}
	
	function custom_excerpt($text) {
		$text = str_replace('[...]', '...', $text);
		return $text;
	}
	add_filter('get_the_excerpt', 'custom_excerpt');
	
	function js_char_shortalize($text, $length = 180, $append = '...') {
		$new_text = substr($text, 0, $length);
		if (strlen($text) > $length) {
			$new_text .= '...';
		}
		return $new_text;
	}
	
	function getRelativeTime($date,$hide_date = false) {

		$date = strtotime($date);
		$diff = time() - $date;
			
		if ($diff<60)
			return "<b>".$diff . " second" . plural($diff) . " ago</b>";
		$diff = round($diff/60);
		if ($diff<60)
			return "<b>".$diff . " minute" . plural($diff) . " ago</b>";
		$diff = round($diff/60);
		if ($diff<24)
			return "<b>".$diff . " hour" . plural($diff) . " ago</b>";
		$diff = round($diff/24);
		if ($diff<7){
			$display = "<b>".$diff . " day" . plural($diff) . " ago</b>";
			if (!$hide_date){ $display .= " on <b>".date('F j, Y', $date)."</b> at <b>".date('g:ia', $date)."</b>"; }
			return $display;
		}
		$diff = round($diff/7);
		if ($diff<4){
			$display = "<b>".$diff . " week" . plural($diff) . " ago</b>";
			if (!$hide_date){ $display .= " on <b>".date('F j, Y', $date)."</b> at <b>".date('g:ia', $date)."</b>"; }
			return $display;
		}
	
		return "at <b>" .date('g:i'). " on " . date("F j, Y", $date)."</b>";
		
	}
	
	function makeClickableLinks($text) {

		$text = preg_replace(
		    '/(^|[^"])(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i',
		    '\\1<a href="\\2" target="_blank">\\2</a>', 
		    $text
		);
		
		return $text;
		
	}
	
	function plural($num) {
		if ($num != 1)
			return "s";
	}
	
	class SaviorCustomNavigation extends Walker_Nav_Menu {
		
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul>\n";
		}
		
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}
	
	}
	
	function get_page_ancestor($page_id) {
	    $page_obj = get_page($page_id);
	    while($page_obj->post_parent!=0) {
	        $page_obj = get_page($page_obj->post_parent);
	    }
	    return get_page($page_obj->ID);
	}

// End Misc Functions
// ------------------------------------------------------------

?>