<?php header("content-type: text/css");

$color = $_GET['color'];
$bg_color = $_GET['bg_color'];
$text_color = $_GET['text_color'];
$font = $_GET['font'];

function HexToRGB($hex) {
	$hex = str_replace("#", "", $hex);
	$color = array();
	
	if(strlen($hex) == 3) {
		$color['r'] = hexdec(substr($hex, 0, 1) . $r);
		$color['g'] = hexdec(substr($hex, 1, 1) . $g);
		$color['b'] = hexdec(substr($hex, 2, 1) . $b);
	}
	else if(strlen($hex) == 6) {
		$color['r'] = hexdec(substr($hex, 0, 2));
		$color['g'] = hexdec(substr($hex, 2, 2));
		$color['b'] = hexdec(substr($hex, 4, 2));
	}
	
	return $color;
}

$rgb = HexToRGB($color);
$rgb_dark = ($rgb['r'] - 45).','.($rgb['g'] - 45).','.($rgb['b'] - 45);

if (strstr($font,':')){
	$font = explode(':',$font);
	$font = $font[0];
}

if ($font != 'sans-serif'){ $font = "'".$font."'"; } ?>

body, #main { background-color:#<?php echo $bg_color; ?>; }

#full-slider .caption.boxed-white h3, #full-slider-behind .caption.boxed-white h3,
#full-slider .caption.boxed-white p, #full-slider-behind .caption.boxed-white p,
body, .co-block p, .widget h4, .widget p { color:#<?php echo $text_color; ?>; }

#full-slider .caption.boxed-white .button-mini:hover,
#full-slider-behind .caption.boxed-white .button-mini:hover { background:#<?php echo $text_color; ?>; }

h1,h2,h4,h5,h6,
#header nav,
#slider h3,
#countdown h2,
.widget .events .date-area,
.button-large,
.button-mini,
.gform_button,
.button-small,
.text-widget h4,
#full-slider-behind h3,
#full-slider h3,
.gform_wrapper .gform_footer .gform_button,
.widget-button,
#mobile-nav li a {
	font-family: <?php echo $font; ?>;
}

a,
#search-form .submit,
#header .top li span,
article h2,
.events a:hover h5,
#footer .button-large,
#footer .button-small,
#footer .button-mini,
#footer .gform_button,
.tweet_list .tweet_text .at,
#footer .bottom p span
{ color: #<?php echo $color; ?>; }

#footer
{ border-color: #<?php echo $color; ?>; }

#header nav li + li
{ border-color: rgba(255,255,255,0.15); }

#header nav li.custom a,
.button-mini, #countdown,
.button-large,
.events .date-area,
.button-small,
#full-slider h3 span,
#full-slider-behind h3 span,
#search-form .submit:hover,
#aec-modal .maplink,
body #aec-modal-container .aec-title,
#content .gallery-thumb span.photo-count,
#pagination li a,
#content .post-content a.more:hover,
#respond input#submit,
article#content ol.commentlist li.comment div.reply a,
.mobile-nav-toggle,
#mobile-nav > ul,
#header nav .dd li:hover > a,
.gform_wrapper .gform_footer .gform_button,
.widget-button,
#full-slider-behind li .button-mini:hover,
#full-slider li .button-mini:hover,
#full-slider .caption.boxed-white .button-mini,
#full-slider-behind .caption.boxed-white .button-mini,
#content .cta { background-color: #<?php echo $color; ?>; }

#content .cta, .button-large, .button-large:hover, .gform_button, .gform_button:hover, .widget .events .date-area, .widget .events li > a:hover .date-area, .button-small, .button-small:hover
{ border-bottom-color: rgb(<?php echo $rgb_dark; ?>); }

.widget-button:hover { background-color:rgb(<?php echo $rgb_dark; ?>); }


/* Other colors */

#header .top, #footer .bottom,
#search-form .field,
#search-form .submit
{ background:#000; }

#search-form .field:focus
{ background: #333; }

h6, .tweet_time a, article blockquote 
{ color: #a7a7a7; }

footer h6, footer .tweet_time a, footer article blockquote, footer span.tweet_time
{ color: rgba(255,255,255,0.5); }

#header .top li,
#search-form .field,
.bottom p a,
#header .top li a,
#header nav a,
#header nav li.custom a,
#header nav li.custom a:hover,
#slider h3,
#slider p,
#countdown *,
#footer h4,
#footer .widget p,
#footer .gform_wrapper .top_label .gfield_label,
#footer .widget .gform_wrapper span.gform_description,
#footer .tweet_text,
#footer .tweet_text,
#footer .bottom p,
#full-slider h3,
#full-slider p,
#full-slider-behind h3,
#full-slider-behind p,
#search-form .submit:hover,
#aec-modal .maplink,
.events li > a:hover .date-area,
footer .events h5
{ color: #fff; }

article .image 
{ color: #888; }

#footer .button-large, #footer .button-small, #footer .button-mini, #footer .gform_button
{ background-color: #fff; border-bottom-color: #a7a7a7; }

