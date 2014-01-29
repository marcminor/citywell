<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
	
	<?php global $template_dir;
	$template_dir = get_template_directory_uri(); ?>

	<title><?php wp_title('&mdash;', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>">
	
	<!-- Apple iOS Settings -->
	<meta name="viewport" content="width=device-width, minimum-scale=1" />
	
	<?php if (of_get_option('js_favicon')){ ?>
		<!-- The Favicon, change this to whatever you'd like -->
		<link rel="shortcut icon" href="<?php echo of_get_option('js_favicon'); ?>" />
	<?php }
	
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head();
	
	$custom_logo = of_get_option('js_logo');
	$logo_width = of_get_option('js_logo_width');
	$logo_height = of_get_option('js_logo_height');
	$footer_text_style = of_get_option('js_footer_text_style');
	
	$header_bg_color = (of_get_option('js_header_background_color') ? of_get_option('js_header_background_color') : '#603C25');
	$header_bg_image = (of_get_option('js_header_background_image') ? of_get_option('js_header_background_image') : false);
	$header_bg_align = (of_get_option('js_header_background_image_alignment') ? of_get_option('js_header_background_image_alignment') : 'top center');
	$header_bg_repeat = (of_get_option('js_header_background_image_repeat') ? of_get_option('js_header_background_image_repeat') : 'repeat');
	$header_bg_disabled = (of_get_option('js_header_bg_disabled') ? true : false);
	
	$footer_bg_color = (of_get_option('js_footer_background_color') ? of_get_option('js_footer_background_color') : '#333333');
	$footer_bg_image = (of_get_option('js_footer_background_image') ? of_get_option('js_footer_background_image') : false);
	$footer_bg_align = (of_get_option('js_footer_background_image_alignment') ? of_get_option('js_footer_background_image_alignment') : 'top center');
	$footer_bg_repeat = (of_get_option('js_footer_background_image_repeat') ? of_get_option('js_footer_background_image_repeat') : 'repeat');
	$footer_bg_disabled = (of_get_option('js_footer_bg_disabled') ? true : false);
	
	if ($custom_logo || $footer_bg_image || $footer_bg_color || $header_bg_image || $header_bg_color){ echo '<style type="text/css">'; }
	if ($custom_logo){ echo '#logo a { background: url(\''.$custom_logo.'\') left center no-repeat !important; }'; }
	
	if ($logo_width){ echo '#logo a { width:'.$logo_width.'px; }'; }
	if ($logo_height){ echo '#logo a { height:'.$logo_height.'px; }'; }
	
	if ($header_bg_color || $header_bg_image){
		if ($header_bg_color && !$header_bg_image){
			echo 'header { background: '.$header_bg_color.'; }';
		} else if ($header_bg_image && !$header_bg_color){
			echo 'header { background: url(\''.$header_bg_image.'\')'.($header_bg_align ? ' '.$header_bg_align : '').($header_bg_repeat ? ' '.$header_bg_repeat : '').'; }';
		} else {
			echo 'header { background: '.$header_bg_color.' url(\''.$header_bg_image.'\')'.($header_bg_align ? ' '.$header_bg_align : '').($header_bg_repeat ? ' '.$header_bg_repeat : '').'; }';
		}
		
		if ($header_bg_disabled){
			echo 'header { background-image:none; }';
		}
	}
	
	if ($footer_bg_color || $footer_bg_image){
		if ($footer_bg_color && !$footer_bg_image){
			echo 'footer { background-color: '.$footer_bg_color.'; }';
		} else if ($footer_bg_image && !$footer_bg_color){
			echo 'footer { background-image: url(\''.$footer_bg_image.'\')'.($footer_bg_align ? ' '.$footer_bg_align : '').($footer_bg_repeat ? ' '.$footer_bg_repeat : '').'; }';
		} else {
			echo 'footer { background: '.$footer_bg_color.' url(\''.$footer_bg_image.'\')'.($footer_bg_align ? ' '.$footer_bg_align : '').($footer_bg_repeat ? ' '.$footer_bg_repeat : '').'; }';
		}
		
		if ($footer_bg_disabled){
			echo 'footer { background-image:none; }';
		}
	}
	
	if ($custom_logo || $footer_bg_image || $footer_bg_color || $header_bg_image || $header_bg_color){ echo '</style>'; }
	
	$google_analytics = of_get_option('js_google_analytics');
	if ($google_analytics) {
		echo $google_analytics;
	}
	
	$custom_css = of_get_option('js_custom_css');
	if ($custom_css) {
		echo '<style type="text/css">'.$custom_css.'</style>';
	} ?>
	
</head>
<body <?php body_class(); ?>>
	
	<?php
	$mobile_nav_toggle_class = 'toggle-shell';
	
	if ($post) {
	
		// Set up <header> classes
		$slider_choice = get_post_meta($post->ID, '_slider_choice', true);
		$top_bar_disabled = of_get_option('js_top_bar_disabled');
		$header_classes = array();
		
		if ($slider_choice){
			$slider_type = get_post_meta($slider_choice, '_slider_type', true);
			$header_classes[] = 'has-slider';
		}
		if ($top_bar_disabled){
			$header_classes[] = 'no-top-bar';
		}
		if (isset($slider_type) && $slider_type == 'one-by-one'){
			$header_classes[] = 'type-oneByOne';
		}
		if (isset($slider_type) && $slider_type == 'behind-header'){
			$header_classes[] = 'type-behind';
			$mobile_nav_toggle_class .= ' abs-slider';
		}
	}

	$header_classes = (!empty($header_classes)) ? ' class="'.implode(' ',$header_classes).'"' : '';
	
	?>
	
	<div id="mobile-nav">
		<?php  // Display Mobile Menu
		$saviorWalker = new SaviorCustomNavigation();
		wp_nav_menu(array('container' => false, 'theme_location' => 'main-menu', 'fallback_cb' => 'main_menu_message', 'walker' => $saviorWalker));
		?>
	</div>
	
	<div class="<?php echo $mobile_nav_toggle_class ?>"><a class="mobile-nav-toggle">+</a></div>

	<header id="header"<?php echo $header_classes ?>>
		<div class="shell">
		
			<h1 id="logo"><a href="<?php echo home_url(); ?>" class="notext"><?php bloginfo('name'); ?></a></h1>

			<nav>
				<?php // Display Main Menu
				wp_nav_menu(array('container' => false, 'theme_location' => 'main-menu', 'fallback_cb' => 'main_menu_message', 'walker' => $saviorWalker));
				?>
			</nav>
				
		</div>
		
		<?php if (!of_get_option('js_top_bar_disabled')): ?>
		<div class="top">
			<div class="shell">
			
				<!-- Top Right Content -->
				<div class="right"><?php display_top_right_content(); ?></div>
				
				<!-- Top Left Content -->
				<?php display_top_left_content(); ?>
				
			</div>
		</div>
		<?php endif;