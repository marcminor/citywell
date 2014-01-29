var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var player_id = 0;

AudioPlayer.setup(templateDir+'/media/player.swf', {  
	width: '100%',
	transparentpagebg: 'yes',
	bg: 'ffffff',
	leftbg: 'ffffff',
	lefticon: customColor,
	voltrack: 'ffffff',
	volslider: customColor,
	rightbg: customColor,
	rightbghover: customColor,
	righticon: 'ffffff',
	righticonhover: 'ffffff',
	loader: customColor,
	track: 'ffffff',
	tracker: 'dedede',
	border: 'ffffff'
});  

jQuery(document).ready(function($) {
	$.do_placeholders();
	
	if($('nav > ul > li > ul').length) {
        $('nav > ul > li > ul').each(function() {
            
            $(this).parent().addClass('has-dd');
            $(this).wrap('<div class="dd" />').parent().prepend('<span class="arrow" />');
            
            if($(this).find('ul').length) {
                $(this).find('ul > li:first').addClass('first');
                $(this).find('ul > li:last').addClass('last');
            }
            $(this).show();
        });
    }
    
    if ($('.mobile-nav-toggle').length) {
		$('.mobile-nav-toggle').click(function(){
			$(this).toggleClass('active');
			if($(this).hasClass('active')){ $(this).html('&times;'); } else { $(this).html('+'); }
			$('#mobile-nav > ul').slideToggle('fast');
		});
	}

	$('.dd').animate({opacity:0},0);

    $('nav > ul > li').on('mouseenter', function() {
    	if($(this).find('.dd').length) {
    		if($.browser.msie && $.browser.version < 9) {
                $(this).find('.dd').show().animate({opacity:1},0);
            } else {
                $(this).find('.dd').show().stop().animate({opacity:1,top:25},200,'easeOutQuad');
            }
    	}
    }).on('mouseleave', function() {
    	if($(this).find('.dd').length) {
    		if($.browser.msie && $.browser.version < 9) {
                $(this).find('.dd').animate({opacity:0},0,function(){
                	$(this).hide();
                });
            } else {
                $(this).find('.dd').stop().animate({opacity:0,top:20},200,'easeInQuad',function(){
                	$(this).hide();
                });
            }
    	}
    });

	$(document).on('click', 'a.play', function() {
		create_player($(this));
		return false;
	});

	if($('#slider').length) {
		$('#slider .shell').oneByOne({
			className: 'oneByOne',
			easeType: 'fadeInLeft',
			pauseByHover: true,
			enableDrag: false,
			showArrow: true,		
			showButton: false,
			slideShow: slider_autocycle,  	
			slideShowDelay: slider_interval
		});
	}
	
	if($('.gallery').length) {
		$('.gallery a').fancybox();
	}
	
	if (!slider_autocycle) { var full_interval = false; } else { var full_interval = slider_interval; }

	if($('#full-slider').length) {
		
		$(window).on('resize', function() {
			fullSliderAdjust();
		}).resize();
		
		

		$('#full-slider .container ul').carouFredSel({
			width: "100%",
			responsive: true,
			items: {
				visible: 1,
				width: 1440,
				height: '66%'
			},
			align: false,
			scroll: {
				easing: "easeInOutExpo",
				duration: slider_speed,
				pauseOnHover: true
			},
			auto: full_interval,
			prev: "#full-slider .prev",
			next: "#full-slider .next",
			onCreate: function(){ fullSliderAdjust(); }
		});
		
	}

	if($('#full-slider-behind').length) {
		
		$(window).on('resize', function() {
			fullSliderAdjust();
		}).resize();

		$('#full-slider-behind .container ul').carouFredSel({
			width: "100%",
			responsive: true,
			items: {
				visible: 1,
				width: 1440,
				height: '66%'
			},
			align: false,
			scroll: {
				easing: "easeInOutExpo",
				duration: slider_speed,
				pauseOnHover: true
			},
			auto: full_interval,
			prev: "#full-slider-behind .prev",
			next: "#full-slider-behind .next",
			onCreate: function(){ fullSliderAdjust(); }
		});
	}

	if($('#countdown').length) {
	
		var austDay = new Date();
	    var date_str = $('#countdown .countdown span').text().replace(',', '').split(' ');
	
	    var month_str = date_str[0];
	    for(i=0;i<months.length;i++) {
	        if(months[i] == month_str) {
	            var austMonth = i;
	        }
	    }
	    
	    var austDate = parseInt(date_str[1]);
	    var austYear = parseInt(date_str[2]);
	    var austHours = parseInt(date_str[3]);
	    var austMinutes = parseInt(date_str[4]);
	    var austTimeZone = parseInt(date_str[5]);
	    var austTimeZone = austTimeZone / 60 / 60;
	
		austDay = new Date(austYear, austMonth, austDate, austHours, austMinutes);
		
		$('#countdown .countdown span').countdown({until: austDay, timezone: austTimeZone, layout: '{dn} {dl}, {hn} {hl}, {mn} {ml} &amp; {sn} {sl}'});
		$('#countdown .countdown').fadeIn('slow')
		
	}

	if($('.widget .events').not('.sc').length) {
		$('.widget .events').not('.sc').each(function(){
		
			var show = parseInt($(this).attr('rel'));
			
			$(this).find('ul').carouFredSel({
				direction: 'up',
				width: "100%",
				height: 'variable',
				circular: false,
				infinite: false,
				items: {
					height: 'variable',
					visible: show
				},
				scroll: {
					items: 1,
					easing: 'easeInOutExpo'
				},
				auto: false,
				prev: $(this).parent().find('.prev'),
				next: $(this).parent().find('.next')
			});
		});
	}

	if($('.recent').length) {
		$('.recent').each(function(){
			
			var show = parseInt($(this).attr('rel'));
		
			$(this).find('ul').carouFredSel({
				direction: 'up',
				width: "100%",
				height: 'variable',
				circular: false,
				infinite: false,
				items: {
					height: 'variable',
					visible: show
				},
				scroll: {
					items: 1,
					easing: 'easeInOutExpo'
				},
				auto: false,
				prev: $(this).parent().find('.prev'),
				next: $(this).parent().find('.next')
			});
		});
	}

	if($('.sermons-widget').length) {
		$('.sermons-widget').each(function(){
		
			var show = parseInt($(this).attr('rel'));
		
			$(this).find('ul').carouFredSel({
				direction: 'up',
				width: "100%",
				height: 'variable',
				circular: false,
				infinite: false,
				items: {
					height: 'variable',
					visible: show
				},
				scroll: {
					items: 1,
					easing: 'easeInOutExpo',
					onBefore	: function() {
						$(this).find('object').remove();
						$(this).find('.button-small').fadeIn('normal');
					}
				},
				auto: false,
				prev: $(this).parent().find('.prev'),
				next: $(this).parent().find('.next')
			});
		
		});
	}

	if($('.tweets-widget').length) {
		$('.tweets-widget').each(function(){
		
			var show = parseInt($(this).attr('rel'));
		
			var thisWidget = $(this);
			var twitterID = $(this).find('.tweets-container').attr('id');
			twitterUser = twitterID.split('-');
			twitterUser = twitterUser[0];
			var tweetCount = $(this).find('.tweets-container').html();
			
			/*thisWidget.find('#'+twitterID).tweet({
				username: twitterUser,
				avatar_size: 0,
				count: tweetCount
			}).on('loaded', function() {*/
				$('.tweets-container').show();
				thisWidget.find('ul').carouFredSel({
					direction: 'up',
					width: "100%",
					height: 'variable',
					circular: false,
					infinite: false,
					items: {
						height: 'variable',
						visible: show
					},
					scroll: {
						items: 1,
						easing: 'easeInOutExpo'
					},
					auto: false,
					prev: $(this).parent().find('.prev'),
					next: $(this).parent().find('.next')
				});
			//})
			
		});
	}
	
	if($('.facebook-widget').length) {
		$('.facebook-widget').each(function(){
		
			var show = parseInt($(this).attr('rel'));
		
			$(this).find('ul').carouFredSel({
				direction: 'up',
				width: "100%",
				height: 'variable',
				circular: false,
				infinite: false,
				items: {
					height: 'variable',
					visible: show
				},
				scroll: {
					items: 1,
					easing: 'easeInOutExpo',
					onBefore	: function() {
						$(this).find('object').remove();
						$(this).find('.button-small').fadeIn('normal');
					}
				},
				auto: false,
				prev: $(this).parent().find('.prev'),
				next: $(this).parent().find('.next')
			});
			
		});
	}
	
});

function fullSliderAdjust(){
	if (jQuery('#full-slider').length){
		var imgElem = jQuery('#full-slider').find('img');
		var imgWidth = imgElem.width();
		var this_half = 0 - (imgElem.width()/2);
		imgElem.css({
			marginLeft: this_half
		});
	}
	if (jQuery('#full-slider-behind').length){
		var imgElem = jQuery('#full-slider-behind').find('img');
		var this_half = 0 - (imgElem.width()/2);
		imgElem.css({
			marginLeft: this_half
		});
	}
}

function create_player(element) {
	var player_container;
	var file_src = element.attr('data-src');
	var sermonWidget = jQuery('.sermons-widget');
	var n = navigator.userAgent;
	
	jQuery('.audio-player-container').each(function() {
		jQuery(this).siblings('.play').show();
		jQuery(this).remove();
	});

	player_container = jQuery('<div id="audio_player_' + player_id + '" class="audio-player-container" />')

	sermonWidget.find('object').remove();
	sermonWidget.find('.button-small').fadeIn('normal');
	element.after(player_container).hide();

	if( n.indexOf('iPhone') != -1 || n.indexOf('iPad') != -1 || n.indexOf('Android') != -1 || typeof(window.debuggingA) != 'undefined' ) {
		jQuery("#audio_player_" + player_id).append('<audio src="' + file_src + '" controls="controls" style="width:100%" />');
	} else {
		AudioPlayer.embed("audio_player_" + player_id, {
			soundFile: file_src,
			autostart: 'yes',
			animation: 'yes'
		});		
	}


	player_id++;
}