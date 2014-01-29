<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = wp_get_theme();
	$themename = $themename['Name'];
	
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
	
}

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {
	
	jQuery( ".homepageBlockBuilder" ).sortable({
		items: "div:not(.no-sorting)",
		create: function() {
			
			jQuery('input#js_homepage_block_order').val();
			
			var sortOrder = jQuery( ".homepageBlockBuilder" ).sortable("serialize");
			sortOrder = sortOrder.split('&');
			var newArray = new Array();
			for (var i = 0; i < sortOrder.length; i++) {
			    var currentItem = sortOrder[i];
			    currentItem = currentItem.split('=');
			    currentItem = currentItem[1];
			    newArray.push(currentItem);
			}
			
			var sortList = newArray.join(",")
		},
		update: function() {
			var sortOrder = jQuery( ".homepageBlockBuilder" ).sortable("serialize");
			sortOrder = sortOrder.split('&');
			var newArray = new Array();
			for (var i = 0; i < sortOrder.length; i++) {
			    var currentItem = sortOrder[i];
			    currentItem = currentItem.split('=');
			    currentItem = currentItem[1];
			    newArray.push(currentItem);
			}
			
			var sortList = newArray.join(",")
			jQuery('input#js_homepage_block_order').val(sortList);
        }
	}).disableSelection();
	
	// Hide/Show Homepage Blocks
	jQuery('#savior-js_homepage_blocks-js_homepage_slider').change(function() {
		var thisValue = jQuery(this).attr('checked');
		if (thisValue == 'checked'){
			jQuery('#of-option-homepageslider-tab').parent().slideUp();
			jQuery('.savior-js_homepage_blocks-js_homepage_slider').css({'background':'#f5f5f5','color':'#ccc'});
		} else {
			jQuery('#of-option-homepageslider-tab').parent().slideDown();
			jQuery('.savior-js_homepage_blocks-js_homepage_slider').css({'background':'#eee','color':'#333'});
		}
	});
	
	jQuery('#savior-js_homepage_blocks-js_homepage_introblock').change(function() {
		var thisValue = jQuery(this).attr('checked');
		if (thisValue == 'checked'){
			jQuery('#of-option-homepageintroblock-tab').parent().slideUp();
			jQuery('.savior-js_homepage_blocks-js_homepage_introblock').css({'background':'#f5f5f5','color':'#ccc'});
		} else {
			jQuery('#of-option-homepageintroblock-tab').parent().slideDown();
			jQuery('.savior-js_homepage_blocks-js_homepage_introblock').css({'background':'#eee','color':'#333'});
		}
	});
	
	jQuery('#savior-js_homepage_blocks-js_footer_mapblock').change(function() {
		var thisValue = jQuery(this).attr('checked');
		if (thisValue == 'checked'){
			jQuery('.savior-js_homepage_blocks-js_footer_mapblock').css({'background':'#f5f5f5','color':'#ccc'});
		} else {
			jQuery('.savior-js_homepage_blocks-js_footer_mapblock').css({'background':'#eee','color':'#333'});
		}
	});
	
	jQuery('#savior-js_homepage_blocks-js_event_countdown').change(function() {
		var thisValue = jQuery(this).attr('checked');
		if (thisValue == 'checked'){
			jQuery('.savior-js_homepage_blocks-js_event_countdown').css({'background':'#f5f5f5','color':'#ccc'});
		} else {
			jQuery('.savior-js_homepage_blocks-js_event_countdown').css({'background':'#eee','color':'#333'});
		}
	});
	
	var thisValue = jQuery('#savior-js_homepage_blocks-js_homepage_slider').attr('checked');
	if (thisValue == 'checked'){
		jQuery('#of-option-homepageslider-tab').parent().hide();
		jQuery('.savior-js_homepage_blocks-js_homepage_slider').css({'background':'#f5f5f5','color':'#ccc'});
	} else {
		jQuery('#of-option-homepageslider-tab').parent().show();
		jQuery('.savior-js_homepage_blocks-js_homepage_slider').css({'background':'#eee','color':'#333'});
	}
	
	var thisValue = jQuery('#savior-js_homepage_blocks-js_homepage_introblock').attr('checked');
	if (thisValue == 'checked'){
		jQuery('#of-option-homepageintroblock-tab').parent().hide();
		jQuery('.savior-js_homepage_blocks-js_homepage_introblock').css({'background':'#f5f5f5','color':'#ccc'});
	} else {
		jQuery('#of-option-homepageintroblock-tab').parent().show();
		jQuery('.savior-js_homepage_blocks-js_homepage_introblock').css({'background':'#eee','color':'#333'});
	}
	
	var thisValue = jQuery('#savior-js_homepage_blocks-js_footer_mapblock').attr('checked');
	if (thisValue == 'checked'){
		jQuery('.savior-js_homepage_blocks-js_footer_mapblock').css({'background':'#f5f5f5','color':'#ccc'});
	} else {
		jQuery('.savior-js_homepage_blocks-js_footer_mapblock').css({'background':'#eee','color':'#333'});
	}
	
	var thisValue = jQuery('#savior-js_homepage_blocks-js_event_countdown').attr('checked');
	if (thisValue == 'checked'){
		jQuery('.savior-js_homepage_blocks-js_event_countdown').css({'background':'#f5f5f5','color':'#ccc'});
	} else {
		jQuery('.savior-js_homepage_blocks-js_event_countdown').css({'background':'#eee','color':'#333'});
	}
	// END Hide/Show Homepage Blocks
	
});
</script>

<?php }

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {

	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	$options_categories[0] = __('All','savior');
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the Gallery Item categories into an array
	$gallery_categories = array();  
	$gallery_categories_obj = get_categories(array('taxonomy' => 'galleries'));
	$gallery_categories[0] = __('All','savior');
	foreach ($gallery_categories_obj as $gallery_category) {
		$gallery_categories[$gallery_category->cat_ID] = $gallery_category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __('None','savior');
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
	
	// Pull all the pages into an array
	$options_normal_pages = array();  
	$options_normal_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_normal_pages[''] = __('None','savior');
	foreach ($options_normal_pages_obj as $normal_page) {
		$template_name = get_post_meta( $normal_page->ID, '_wp_page_template', true );
		if ($template_name == 'default' || $template_name == 'page-full.php' || $template_name == 'page-leftsidebar.php'){
    		$options_normal_pages[$normal_page->ID] = $normal_page->post_title;
    	}
	}
	
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/_theme_settings/images/';
		
	$options = array();

	
	$options[] = array( "name" => __("General Styling","savior"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Logo Replacement","savior"),
						"desc" => __("Upload your own logo. Our recommendation is to keep it at 300px x 109px or smaller.","savior"),
						"id" => "js_logo",
						"type" => "upload");
	
	$options[] = array( "name" => __("Logo Width (optional)","savior"),
						"desc" => __("The default width for logos is \"174\". You can change this here by entering a new width.","savior"),
						"id" => "js_logo_width",
						"std" => "174",
						"type" => "text");					
	
	$options[] = array( "name" => __("Logo Height (optional)","savior"),
						"desc" => __("The default height for logos is \"109\". You can change this here by entering a new height.","savior"),
						"id" => "js_logo_height",
						"std" => "109",
						"type" => "text");
						
	$option_array = array('default' => 'Default', 'light' => "Light");
		
	$options[] = array( "name" => __("Overall Style","savior"),
						"desc" => '',
						"id" => "js_overall_style",
						"std" => 'default',
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Main Color","savior"),
						"desc" => __("You can change the custom color. (default is #c86300)","savior"),
						"id" => "js_highlight_color",
						"std" => "#c86300",
						"type" => "color");
						
	$options[] = array( "name" => __("Main Background Color","savior"),
						"desc" => __("You can change the main background color. (default is #ffffff)","savior"),
						"id" => "js_main_bg_color",
						"std" => "#ffffff",
						"type" => "color");
						
	$options[] = array( "name" => __("Main Text Color","savior"),
						"desc" => __("You can change the main text color. (default is #333333)","savior"),
						"id" => "js_text_color",
						"std" => "#333333",
						"type" => "color");
						
	$options[] = array( "name" => __("Favicon Replacement","savior"),
						"desc" => __("Upload your own favicon. Be sure it's a 16px x 16px \"ico\" or \"png\" file.","savior"),
						"id" => "js_favicon",
						"type" => "upload");
	
	$option_array = array('no' => "No",'yes' => "Yes");
						
	$options[] = array( "name" => __("Disable Responsiveness?","savior"),
						"desc" => __("You can optionally turn off the mobile responsiveness.","savior"),
						"id" => "js_responsive_disabled",
						"std" => 'no',
						"type" => "radio",
						"options" => $option_array);
	
	
	
	
	$options[] = array( "name" => __("Header","savior"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Header Background Color","savior"),
						"desc" => __("You can change the custom background color. (default is #603C25)","savior"),
						"id" => "js_header_background_color",
						"std" => "#603C25",
						"type" => "color");
	
	$options[] = array( "name" => __("Header Background Image","savior"),
						"desc" => __("Upload your own background image.","savior"),
						"id" => "js_header_background_image",
						"type" => "upload");
												
	$option_array = array('top left' => "Top Left", 'top center' => "Top Center", 'top right' => "Top Right", 'bottom left' => "Bottom Left", 'bottom center' => "Bottom Center", 'bottom right' => "Bottom Right", 'center center' => "Center Center");
		
	$options[] = array( "name" => __("Background Image Alignment","savior"),
						"desc" => '',
						"id" => "js_header_background_image_alignment",
						"std" => false,
						"type" => "radio",
						"options" => $option_array);
						
	$option_array = array('no-repeat' => 'No Repeat', 'repeat-x' => "Repeat-X", 'repeat-y' => "Repeat-Y", 'repeat' => "Repeat");
		
	$options[] = array( "name" => __("Background Repeat?","savior"),
						"desc" => '',
						"id" => "js_header_background_image_repeat",
						"std" => false,
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Disable the Header Image (just use the background color)?","savior"),
						"desc" => '',
						"id" => "js_header_bg_disabled",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
	$options[] = array( "name" => __("Top Left Text","savior"),
						"desc" => __("You can use &lt;span&gt; tags to colorize &amp; bold specific text.","savior"),
						"id" => "js_top_left_text",
						"std" => "<span>Phone:</span> (123) 456-7890 // <span>Address:</span> 555 Main Road, Cityname, ST 01234",
						"type" => "textarea");
	
	global $woocommerce;
	$option_array = array('search' => "Search Box",'social' => "Social Icons",'text' => "Text");
	if ($woocommerce): $option_array['woocommerce'] = 'WooCommerce Cart'; endif;
		
	$options[] = array( "name" => __("Top Bar &mdash; Right Content Type","savior"),
						"desc" => __("Choose the type of content you want to display on the right side of the top bar.","savior"),
						"id" => "js_top_right_content_type",
						"std" => "search",
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Top Right Text (if selected above)","savior"),
						"desc" => __("You can use &lt;span&gt; tags to colorize &amp; bold specific text.","savior"),
						"id" => "js_top_right_text",
						"std" => "<span>Custom Text:</span> Feel free to add anything here.",
						"type" => "textarea");
						
	$options[] = array( "name" => __("Disable the Top Bar?","savior"),
						"desc" => '',
						"id" => "js_top_bar_disabled",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
		
						
	
	
	$options[] = array( "name" => __("Slider Styling","savior"),
						"type" => "heading");
						
	$option_array = array('floating' => 'Floating Text', 'boxed-black' => "Boxed Text on Black", 'boxed-white' => "Boxed Text on White");
		
	$options[] = array( "name" => __("Full Width Slider Styling","savior"),
						"desc" => '',
						"id" => "js_fullwidth_slider_styling",
						"std" => 'floating',
						"type" => "radio",
						"options" => $option_array);
						
						
	
	
	$options[] = array( "name" => __("Custom Fonts","savior"),
						"type" => "heading");
	
	$options[] = array( "name" => __("Choose a font from the entire Google Library:","savior"),
						"desc" => '',
						"id" => "js_custom_font",
						"std" => "Roboto",
						"type" => "select",
						"options" => array(
							'' => 'Choose a font to override the above...',
							'Aclonica' => 'Aclonica',
							'Allan' => 'Allan',
							'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope',
							'Anonymous+Pro' => 'Anonymous Pro',
							'Allerta+Stencil' => 'Allerta Stencil',
							'Allerta' => 'Allerta',
							'Amaranth' => 'Amaranth',
							'Anton' => 'Anton',
							'Architects+Daughter' => 'Architects Daughter',
							'Arimo' => 'Arimo',
							'Artifika' => 'Artifika',
							'Arvo' => 'Arvo',
							'Asset' => 'Asset',
							'Astloch' => 'Astloch',
							'Average+Sans' => 'Average Sans',
							'Bangers' => 'Bangers',
							'Bentham' => 'Bentham',
							'Bevan' => 'Bevan',
							'Bigshot+One' => 'Bigshot One',
							'Bowlby+One' => 'Bowlby One',
							'Bowlby+One+SC' => 'Bowlby One SC',
							'Brawler' => 'Brawler ',
							'Buda:300' => 'Buda',
							'Cabin' => 'Cabin',
							'Calligraffitti' => 'Calligraffitti',
							'Candal' => 'Candal',
							'Cantarell' => 'Cantarell',
							'Cardo' => 'Cardo',
							'Carter One' => 'Carter One',
							'Caudex' => 'Caudex',
							'Cedarville+Cursive' => 'Cedarville Cursive',
							'Cherry+Cream+Soda' => 'Cherry Cream Soda',
							'Chewy' => 'Chewy',
							'Coda' => 'Coda',
							'Coming+Soon' => 'Coming Soon',
							'Copse' => 'Copse',
							'Corben:700' => 'Corben',
							'Cousine' => 'Cousine',
							'Covered+By+Your+Grace' => 'Covered By Your Grace',
							'Crafty+Girls' => 'Crafty Girls',
							'Crimson+Text' => 'Crimson Text',
							'Crushed' => 'Crushed',
							'Cuprum' => 'Cuprum',
							'Damion' => 'Damion',
							'Dancing+Script' => 'Dancing Script',
							'Dawning+of+a+New+Day' => 'Dawning of a New Day',
							'Didact+Gothic' => 'Didact Gothic',
							'Droid+Sans' => 'Droid Sans',
							'Droid+Sans+Mono' => 'Droid Sans Mono',
							'Droid+Serif' => 'Droid Serif',
							'EB+Garamond' => 'EB Garamond',
							'Expletus+Sans' => 'Expletus Sans',
							'Fontdiner+Swanky' => 'Fontdiner Swanky',
							'Forum' => 'Forum',
							'Francois+One' => 'Francois One',
							'Geo' => 'Geo',
							'Give+You+Glory' => 'Give You Glory',
							'Goblin+One' => 'Goblin One',
							'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911',
							'Gravitas+One' => 'Gravitas One',
							'Gruppo' => 'Gruppo',
							'Hammersmith+One' => 'Hammersmith One',
							'Holtwood+One+SC' => 'Holtwood One SC',
							'Homemade+Apple' => 'Homemade Apple',
							'Inconsolata' => 'Inconsolata',
							'Indie+Flower' => 'Indie Flower',
							'IM+Fell+DW+Pica' => 'IM Fell DW Pica',
							'IM+Fell+DW+Pica+SC' => 'IM Fell DW Pica SC',
							'IM+Fell+Double+Pica' => 'IM Fell Double Pica',
							'IM+Fell+Double+Pica+SC' => 'IM Fell Double Pica SC',
							'IM+Fell+English' => 'IM Fell English',
							'IM+Fell+English+SC' => 'IM Fell English SC',
							'IM+Fell+French+Canon' => 'IM Fell French Canon',
							'IM+Fell+French+Canon+SC' => 'IM Fell French Canon SC',
							'IM+Fell+Great+Primer' => 'IM Fell Great Primer',
							'IM+Fell+Great+Primer+SC' => 'IM Fell Great Primer SC',
							'Irish+Grover' => 'Irish Grover',
							'Irish+Growler' => 'Irish Growler',
							'Istok+Web' => 'Istok Web',
							'Josefin+Sans' => 'Josefin Sans Regular 400',
							'Josefin+Slab' => 'Josefin Slab Regular 400',
							'Judson' => 'Judson',
							'Jura' => ' Jura Regular',
							'Jura:500' => ' Jura 500',
							'Jura:600' => ' Jura 600',
							'Just+Another+Hand' => 'Just Another Hand',
							'Just+Me+Again+Down+Here' => 'Just Me Again Down Here',
							'Kameron' => 'Kameron',
							'Kenia' => 'Kenia',
							'Kranky' => 'Kranky',
							'Kreon' => 'Kreon',
							'Kristi' => 'Kristi',
							'La+Belle+Aurore' => 'La Belle Aurore',
							'Lato:100' => 'Lato 100',
							'Lato:100italic' => 'Lato 100 (plus italic)',
							'Lato:300' => 'Lato Light 300',
							'Lato' => 'Lato',
							'Lato:bold' => 'Lato Bold 700',
							'Lato:900' => 'Lato 900',
							'League+Script' => 'League Script',
							'Lekton' => ' Lekton ',
							'Limelight' => ' Limelight ',
							'Lobster' => 'Lobster',
							'Lobster Two' => 'Lobster Two',
							'Lora' => 'Lora',
							'Love+Ya+Like+A+Sister' => 'Love Ya Like A Sister',
							'Loved+by+the+King' => 'Loved by the King',
							'Luckiest+Guy' => 'Luckiest Guy',
							'Maiden+Orange' => 'Maiden Orange',
							'Mako' => 'Mako',
							'Maven+Pro' => ' Maven Pro',
							'Maven+Pro:500' => ' Maven Pro 500',
							'Maven+Pro:700' => ' Maven Pro 700',
							'Maven+Pro:900' => ' Maven Pro 900',
							'Meddon' => 'Meddon',
							'MedievalSharp' => 'MedievalSharp',
							'Megrim' => 'Megrim',
							'Merriweather' => 'Merriweather',
							'Metrophobic' => 'Metrophobic',
							'Michroma' => 'Michroma',
							'Miltonian Tattoo' => 'Miltonian Tattoo',
							'Miltonian' => 'Miltonian',
							'Modern Antiqua' => 'Modern Antiqua',
							'Monofett' => 'Monofett',
							'Molengo' => 'Molengo',
							'Mountains of Christmas' => 'Mountains of Christmas',
							'Muli:300' => 'Muli Light',
							'Muli' => 'Muli Regular',
							'Neucha' => 'Neucha',
							'Neuton' => 'Neuton',
							'News+Cycle' => 'News Cycle',
							'Nixie+One' => 'Nixie One',
							'Nobile' => 'Nobile',
							'Nova+Cut' => 'Nova Cut',
							'Nova+Flat' => 'Nova Flat',
							'Nova+Mono' => 'Nova Mono',
							'Nova+Oval' => 'Nova Oval',
							'Nova+Round' => 'Nova Round',
							'Nova+Script' => 'Nova Script',
							'Nova+Slim' => 'Nova Slim',
							'Nova+Square' => 'Nova Square',
							'Nunito:light' => ' Nunito Light',
							'Nunito' => ' Nunito Regular',
							'OFL+Sorts+Mill+Goudy+TT' => 'OFL Sorts Mill Goudy TT',
							'Old+Standard+TT' => 'Old Standard TT',
							'Open+Sans' => 'Open Sans',
							'Orbitron' => 'Orbitron',
							'Oswald' => 'Oswald',
							'Over+the+Rainbow' => 'Over the Rainbow',
							'Reenie+Beanie' => 'Reenie Beanie',
							'Pacifico' => 'Pacifico',
							'Patrick+Hand' => 'Patrick Hand',
							'Paytone+One' => 'Paytone One',
							'Permanent+Marker' => 'Permanent Marker',
							'Philosopher' => 'Philosopher',
							'Play' => 'Play',
							'Playfair+Display' => ' Playfair Display ',
							'Podkova' => ' Podkova ',
							'PT+Sans' => 'PT Sans',
							'PT+Sans+Narrow' => 'PT Sans Narrow',
							'PT+Sans+Narrow:regular,bold' => 'PT Sans Narrow (plus bold)',
							'PT+Serif' => 'PT Serif',
							'PT+Serif Caption' => 'PT Serif Caption',
							'Puritan' => 'Puritan',
							'Quattrocento' => 'Quattrocento',
							'Quattrocento+Sans' => 'Quattrocento Sans',
							'Radley' => 'Radley',
							'Raleway:100' => 'Raleway',
							'Redressed' => 'Redressed',
							'Roboto' => 'Roboto',
							'Roboto+Condensed' => 'Roboto Condensed',
							'Rock+Salt' => 'Rock Salt',
							'Rokkitt' => 'Rokkitt',
							'Ruslan+Display' => 'Ruslan Display',
							'Sanchez' => 'Sanchez',
							'Schoolbell' => 'Schoolbell',
							'Shadows+Into+Light' => 'Shadows Into Light',
							'Shanti' => 'Shanti',
							'Sigmar+One' => 'Sigmar One',
							'Six+Caps' => 'Six Caps',
							'Slackey' => 'Slackey',
							'Smythe' => 'Smythe',
							'Sniglet:800' => 'Sniglet',
							'Special+Elite' => 'Special Elite',
							'Stardos+Stencil' => 'Stardos Stencil',
							'Strait' => 'Strait',
							'Sue+Ellen+Francisco' => 'Sue Ellen Francisco',
							'Sunshiney' => 'Sunshiney',
							'Swanky+and+Moo+Moo' => 'Swanky and Moo Moo',
							'Syncopate' => 'Syncopate',
							'Tangerine' => 'Tangerine',
							'Tenor+Sans' => ' Tenor Sans ',
							'Terminal+Dosis+Light' => 'Terminal Dosis Light',
							'The+Girl+Next+Door' => 'The Girl Next Door',
							'Tinos' => 'Tinos',
							'Ubuntu' => 'Ubuntu',
							'Ultra' => 'Ultra',
							'Unkempt' => 'Unkempt',
							'UnifrakturCook:bold' => 'UnifrakturCook',
							'UnifrakturMaguntia' => 'UnifrakturMaguntia',
							'Varela' => 'Varela',
							'Varela Round' => 'Varela Round',
							'Vibur' => 'Vibur',
							'Vollkorn' => 'Vollkorn',
							'VT323' => 'VT323',
							'Waiting+for+the+Sunrise' => 'Waiting for the Sunrise',
							'Wallpoet' => 'Wallpoet',
							'Walter+Turncoat' => 'Walter Turncoat',
							'Wire+One' => 'Wire One',
							'Yanone+Kaffeesatz' => 'Yanone Kaffeesatz',
							'Yanone+Kaffeesatz:300' => 'Yanone Kaffeesatz:300',
							'Yanone+Kaffeesatz:400' => 'Yanone Kaffeesatz:400',
							'Yanone+Kaffeesatz:700' => 'Yanone Kaffeesatz:700',
							'Yeseva+One' => 'Yeseva One',
							'Zeyada' => 'Zeyada')
						);	
	
	$options[] = array( "name" => __("Font preview (save to refresh the preview):","savior"),
						"id" => "js_font_preview",
						"type" => "custom_font_preview");
			
	$options[] = array( "name" => __("Comment Disabling","savior"),
						"type" => "heading");
			
	$option_array = array('yes' => "Yes",'no' => "No");
		
	$options[] = array( "name" => __("Disable comments on pages?","savior"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all pages.","savior"),
						"id" => "js_disable_page_comments",
						"std" => true,
						"type" => "radio",
						"options" => $option_array);
		
	$options[] = array( "name" => __("Disable comments on posts?","savior"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all posts.","savior"),
						"id" => "js_disable_post_comments",
						"std" => false,
						"type" => "radio",
						"options" => $option_array);
		
	$options[] = array( "name" => __("Disable comments on photo galleries?","savior"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all gallery posts.","savior"),
						"id" => "js_disable_gallery_comments",
						"std" => true,
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Disable comments on video posts?","savior"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all video posts.","savior"),
						"id" => "js_disable_video_comments",
						"std" => true,
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Disable comments on audio posts?","savior"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all audio posts.","savior"),
						"id" => "js_disable_audio_comments",
						"std" => true,
						"type" => "radio",
						"options" => $option_array);


	
	$options[] = array( "name" => __("Social Settings","savior"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Facebook","savior"),
						"desc" => __("Paste your Facebook profile or page URL here.","savior"),
						"id" => "js_social_icon_facebook",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("Twitter","savior"),
						"desc" => __("Paste your Twitter profile URL here.","savior"),
						"id" => "js_social_icon_twitter",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("LinkedIn","savior"),
						"desc" => __("Paste your LinkedIn profile URL here.","savior"),
						"id" => "js_social_icon_linkedin",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("Youtube","savior"),
						"desc" => __("Paste your Youtube profile URL here.","savior"),
						"id" => "js_social_icon_youtube",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("Vimeo","savior"),
						"desc" => __("Paste your Vimeo profile URL here.","savior"),
						"id" => "js_social_icon_vimeo",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("RSS Feed","savior"),
						"desc" => __("Paste your RSS Feed URL here.","savior"),
						"id" => "js_social_icon_rss",
						"std" => "",
						"type" => "text");

	
	
	
	$options[] = array( "name" => __("Twitter Settings","savior"),
						"type" => "heading");

	$info = <<<HTML
<p><strong>Twitter API requires a Twitter application for communication with 3rd party sites. Here are the steps for creating and setting up a Twitter application:</strong></p>
<ol>
	<li>Go to <a href="https://dev.twitter.com/apps/new" target="_blank">https://dev.twitter.com/apps/new</a> and log in, if necessary</li>
	<li>Supply the necessary required fields, accept the TOS, and solve the CAPTCHA. Callback URL field may be left empty</li>
	<li>Submit the form</li>
	<li>On the next screen scroll down to "Your access token" section and click the "Create my access token" button</li>
	<li>Copy the following fields: Access token, Access token secret, Consumer key, Consumer secret to the (below|above) fields</li>
</ol>
HTML;

	$options[] = array( "name" => __( "Instructions", "savior" ),
						"desc" => __( $info, "savior" ),
						"type" => "info" );
												
	$options[] = array( "name" => "Twitter Oauth Access Token",
						"type" => "text",
						"id"   => "twitter_oauth_access_token",
						"std"  => "" );

	$options[] = array( "name" => "Twitter Oauth Access Token Secret",
						"type" => "text",
						"id"   => "twitter_oauth_access_token_secret",
						"std"  => "" );

	$options[] = array( "name" => "Twitter Consumer Key",
						"type" => "text",
						"id"   => "twitter_consumer_key",
						"std"  => "" );

	$options[] = array( "name" => "Twitter Consumer Secret",
						"type" => "text",
						"id"   => "twitter_consumer_secret",
						"std"  => "" );
						
						
						
						
	$options[] = array( "name" => __("Facebook Settings","savior"),
						"type" => "heading");

	$info = <<<HTML
<p><strong>All of the Facebook functionality in this theme requires a Facebook application for communication with 3rd party sites. Here are the steps for creating and setting up a Facebook application:</strong></p>
<ol>
	<li>Go to <a href="https://developers.facebook.com/apps/?action=create" target="_blank">https://developers.facebook.com/apps/?action=create</a> and log in, if necessary.</li>
	<li>Supply the necessary required fields, and solve the CAPTCHA.</li>
	<li>Submit the form</li>
	<li>On the next screen scroll down to "Your access token" section and click the "Create my access token" button.</li>
	<li>Copy the App ID and App Secret Secret to the fields below.</li>
</ol>
HTML;

	$options[] = array( "name" => __( "Instructions", "savior" ),
						"desc" => __( $info, "savior" ),
						"type" => "info" );
												
	$options[] = array( "name" => "Facebook App ID",
						"type" => "text",
						"id"   => "facebook_app_id",
						"std"  => "" );

	$options[] = array( "name" => "Facebook App Secret",
						"type" => "text",
						"id"   => "facebook_app_secret",
						"std"  => "" );
						
						
				
						
	$options[] = array( "name" => __("Localization","savior"),
						"type" => "heading");
						
	$option_array = array(
		"12h" => __("12-Hour Format (am/pm)","savior"),
		"24h" => __("24-Hour Format","savior"));

	$options[] = array( "name" => __("Time Format","savior"),
						"desc" => __("Choose time format.","savior"),
						"id" => "js_time_format",
						"std" => "12h",
						"type" => "select",
						"options" => $option_array);
						
	$option_array = array(
		"english" => __("English","savior"),
		"german" => __("Deutsch (German)","savior"),
		"spanish" => __("Espanol (Spanish)","savior"),
		"french" => __("Francais (French)","savior"),
		"italian" => __("Italiano (Italian)","savior"));

	$options[] = array( "name" => __("Event Countdown Language","savior"),
						"desc" => __("Choose a language for the countdown timer.","savior"),
						"id" => "js_countdown_language",
						"std" => "english",
						"type" => "select",
						"options" => $option_array);
						
						
						
	$options[] = array( "name" => __("Footer","savior"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Footer Background Color","savior"),
						"desc" => __("You can change the custom background color. (default is #333333)","savior"),
						"id" => "js_footer_background_color",
						"std" => "#333333",
						"type" => "color");
	
	$options[] = array( "name" => __("Footer Background Image","savior"),
						"desc" => __("Upload your own background image.","savior"),
						"id" => "js_footer_background_image",
						"type" => "upload");
						
	$option_array = array(
		'one'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_one.png',
		'two'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_two.png',
		'three'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_three.png'
	);
		
	$options[] = array( "name" => __("Widget Layout","savior"),
						"desc" => __("Choose the widget layout you want to use in the footer.","savior"),
						"id" => "js_footer_widget_layout",
						"std" => "three",
						"type" => "images",
						"options" => $option_array);
												
	$option_array = array('top left' => "Top Left", 'top center' => "Top Center", 'top right' => "Top Right", 'bottom left' => "Bottom Left", 'bottom center' => "Bottom Center", 'bottom right' => "Bottom Right", 'center center' => "Center Center");
		
	$options[] = array( "name" => __("Footer Background Image Alignment","savior"),
						"desc" => '',
						"id" => "js_footer_background_image_alignment",
						"std" => false,
						"type" => "radio",
						"options" => $option_array);
						
	$option_array = array('no-repeat' => 'No Repeat', 'repeat-x' => "Repeat-X", 'repeat-y' => "Repeat-Y", 'repeat' => "Repeat");
		
	$options[] = array( "name" => __("Footer Background Repeat?","savior"),
						"desc" => '',
						"id" => "js_footer_background_image_repeat",
						"std" => false,
						"type" => "radio",
						"options" => $option_array);
	
	$options[] = array( "name" => __("Disable the Footer Image (just use the background color)?","savior"),
						"desc" => '',
						"id" => "js_footer_bg_disabled",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
	$options[] = array( "name" => __("Left Text","savior"),
						"desc" => __("You can use [year] to display the year.","savior"),
						"id" => "js_bottom_left_text",
						"std" => "Copyright &copy;2005-[year] Scheetz Designs. Put whatever you want in this spot!",
						"type" => "textarea");
	
	$option_array = array('social' => "Social Icons",'text' => "Text");
		
	$options[] = array( "name" => __("Right Content Type","savior"),
						"desc" => __("Choose the type of content you want to display on the right side of the footer.","savior"),
						"id" => "js_bottom_right_content_type",
						"std" => "search",
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Right Text (if selected above)","savior"),
						"desc" => __("You can use &lt;span&gt; tags to colorize &amp; bold specific text.","savior"),
						"id" => "js_bottom_right_text",
						"std" => "<span>Custom Text:</span> Feel free to add anything here.",
						"type" => "textarea");
						
	$options[] = array( "name" => __("Disable the Footer Bar?","savior"),
						"desc" => '',
						"id" => "js_bottom_bar_disabled",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
						
	$options[] = array( "name" => __("Breadcrumbs","savior"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Disable the Breadcrumbs on Pages?","savior"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_pages",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
	
	$options[] = array( "name" => __("Disable the Breadcrumbs on Posts?","savior"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_posts",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
	
	$options[] = array( "name" => __("Disable the Breadcrumbs on Search Results?","savior"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_search",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
											
	$options[] = array( "name" => __("Disable the Breadcrumbs on Audio Posts?","savior"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_audio",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');	
						
	$options[] = array( "name" => __("Disable the Breadcrumbs on Videos?","savior"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_videos",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
	
	$options[] = array( "name" => __("Disable the Breadcrumbs on Galleries?","savior"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_galleries",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
	$options[] = array( "name" => __("Breadcrumb Link for \"Galleries\" Page","savior"),
						"desc" => "By default this is the <a href=\"".site_url()."/galleries/\">Galleries Archive</a>, paste a link here to replace it.",
						"id" => "js_default_galleries_breadcrumb",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("Breadcrumb Title for \"Galleries\" Page","savior"),
						"desc" => "By default this is \"Galleries\", but you can put whatever you want here to replace it.",
						"id" => "js_default_galleries_title",
						"std" => "",
						"type" => "text");
						
							
	
	$options[] = array( "name" => __("Other Options","savior"),
						"type" => "heading");
					
	$options[] = array( "name" => __("404 Page Content","savior"),
						"desc" => __("This is what will show up on the 404 page. HTML Allowed.","savior"),
						"id" => "js_404_content",
						"std" => "<p>".__("Sorry, the page cannot be found.","savior")."</p>",
						"type" => "textarea");
						
	$options[] = array( "name" => __("Google Analytics Code","savior"),
						"desc" => __("Enter your code, this shows up right above the </head> tag.","savior"),
						"id" => "js_google_analytics",
						"std" => "",
						"type" => "textarea");
						
	$options[] = array( "name" => __("Custom CSS Code","savior"),
						"desc" => __("Enter your own styles to overwrite whatever you need to.","savior"),
						"id" => "js_custom_css",
						"std" => "",
						"type" => "textarea");
	
	
		
	
			
	return $options;
}