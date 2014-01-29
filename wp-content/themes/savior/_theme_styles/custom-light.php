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
body, .co-block p, .widget h4, .widget p { color:#<?php echo $text_color; ?>; }

h1,h2,h4,h5,h6,
#header nav,
#slider h3,
#countdown h2,
.widget .events .date-area,
.button-large,
.button-mini,
.button-small,
.gform_button,
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
#header nav li a:hover,
article h2,
.events a:hover h5,
.tweet_list .tweet_text .at,
#footer .bottom p span
{ color: #<?php echo $color; ?>; }

#footer
{ border-color: #<?php echo $color; ?>; }

#header nav li + li
{ border-color: rgba(0,0,0,0.15); }

article#content { border-top: 1px solid rgba(0,0,0,0.1); }

#header nav li.custom a,
.button-mini, #countdown,
.button-large,
.gform_button,
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
#footer .button-large, #footer .button-small, #footer .button-mini,
.gform_wrapper .gform_footer .gform_button,
.widget-button,
#full-slider-behind li .button-mini:hover,
#full-slider li .button-mini:hover,
#content .cta { background-color: #<?php echo $color; ?>; }

#content .cta, .button-large, .gform_button, .gform_button:hover, .button-large:hover, .widget .events .date-area, .widget .events li > a:hover .date-area, .button-small, .button-small:hover,
#footer .button-large, #footer .button-small, #footer .button-mini
{ border-bottom-color: rgb(<?php echo $rgb_dark; ?>); }

.widget-button:hover { background-color:rgb(<?php echo $rgb_dark; ?>); }

/* Other colors */

#search-form .field,
#search-form .submit
{ background:#fff; }

#header .top, #footer .bottom { background:#f5f5f5; }

#footer .button-large, #footer .button-small, #footer .button-mini,
#footer .button-large:hover, #footer .button-small:hover, #footer .button-mini:hover,
.gform_button:hover {
color:#fff !important; }

#search-form .field:focus
{ background: #eee; }

h6, .tweet_time a, article blockquote 
{ color: #a7a7a7; }

footer h6, footer .tweet_time a, footer article blockquote 
{ color: rgba(0,0,0,0.5); }

#footer h4 { border-bottom:1px solid rgba(0,0,0,0.2); }

#header .top li,
.bottom p a,
#header .top li a,
#header nav a,
#slider h3,
#slider p,
#footer h4,
#footer .widget p,
#footer .tweet_text,
#footer .bottom p,
#full-slider h3,
#full-slider p,
#full-slider-behind h3,
#full-slider-behind p,
#aec-modal .maplink,
footer .events h5,
#footer .gform_wrapper .top_label .gfield_label
{ color: #000; }

#footer a:hover { color:#000 !important; }

#countdown *,
#header nav li.custom a,
#header nav li.custom a:hover,
#search-form .submit:hover,
.events li > a:hover .date-area,
#full-slider-behind h3 span,
#full-slider h3 span
{ color:#fff; }

article .image 
{ color: #888; }

#full-slider-behind .text p span,
#full-slider .text p span { background-image: url(images/bg-text-light.png); }

/* Image Changes */
#header nav li.has-dd { background-image:url('images/dd-indicator-light.png'); }
#full-slider .line { background-image: url(images/slider3-line-light.png); }
#slider .prevArrow,
#slider .nextArrow,
#full-slider .prev,
#full-slider .next,
#full-slider-behind .prev,
#full-slider-behind .next { background-color:#000; background-image:url(images/slider3-arrows-light.png); }
ul.socials a { background-image: url(images/socials-light.png); }
#full-slider p span,
#full-slider-behind p span { background-image:url('images/bg-text-light.png'); }
#footer .prev, #footer .next { background-image: url('images/arrows-vertical.png'); }

@media only screen and (max-width: 1000px) {
	#full-slider-behind .text p, #full-slider .text p { background:rgba(255,255,255,0.6); }
	#full-slider-behind .text p span, #full-slider .text p span { background:none; }
}