(function($) {

	$.fn.upload_button = function() {
		return this.each(function(){
			var $btn     = $('.plupload-browse-button', this);
			var $bar     = $('.progressbar span', this);
			var $input   = $('.image-id', this);
			var $preview = $input.closest('li').find('.image-preview');

			var btn_id = 'plupload-browse-button' + Math.round((Math.random()  * 9999));
			$btn.attr('id', btn_id);

			var container_id = 'plupload-container-' + Math.round((Math.random()  * 9999));
			$('<div />').attr('id', container_id).hide().appendTo('body');

			var settings = $.parseJSON(cs_plupload_settings);

			settings = $.fn.extend(settings, {
				browse_button: btn_id,
				container: container_id
			});

			var uploader = new plupload.Uploader(settings);

			uploader.bind('FilesAdded', function(up, files) {
				setTimeout(function() {
					$bar.parent().show();
					uploader.start();
				}, 100);
			});

			uploader.bind('UploadProgress', function(up, file) {
				$bar.css({
					width: file.percent + '%'
				});
			});

			uploader.bind('FileUploaded', function(up, file, response) {
				$bar.css({ width: 0 }).parent().fadeOut();

				$input.val('');
				$preview.addClass('loading').find('img').remove();

				/* Send request for an attachment */
				var data =  {
						action: 'cs_img_add',
						image_name: file.name,
						post_id: $('[name=post_ID]').val()
					};

				$.post(ajaxurl, data, function(response) {
					var response = $.parseJSON(response);
					var $img = $('<img />');

					if(!response.success) {
						alert('Error: ' + response.error);
						return;
					}

					$img.appendTo($preview);

					$input.val(response.image_id);
					$img.load(function() {
						$(this).animate({
							opacity: 1
						}, 500, function() {
							$(this).parent().removeClass('loading');
						});
					});
					$img.css({ opacity: 0 }).attr('src', response[$img.is('.cparts img') ? 'small_thumb_path' : 'thumb_path']);
				});
			});

			uploader.bind('Error', function(up, e) {
				console.log(e);
			});

			uploader.init();			
		});
	}

	$.fn.custom_slider = function(o) {
		// Enable toggle-able boxes
		$('.sortable .toggle').die('click').live('click', function() {
			var $item = $(this).closest('li');
			var speed = 300;

			if( $(this).closest('li').is('.open') ) {
				var title = $item.find('.title-field:eq(0)').val();
				var type  = $item.is('.type-image') ? 'Image' : 'Text';
				var $heading = $item.children('.title-wrap').find('h4');

				$heading
					[title ? 'removeClass' : 'addClass']('inactive')
					.animate({
						marginTop: 0
					}, speed)
					.find('.title-text').text( title ? title : 'Adding a new ' + type + ' Block ...' );

				if( $heading.is('.overall') ) {
					$('.overall', $heading).remove();

					totalImages = $item.find('li.type-image:not(.prototype)').size();
					totalText   = $item.find('li.type-text:not(.prototype)').size();

					totalImages += totalImages == 1 ? ' Image' : ' Images';
					totalText += totalText == 1 ? ' Text Block' : ' Text Blocks';

					$heading.append('<span class="overall"> (' + totalImages + ', ' + totalText + ')</span>');					
				}

				$item.find('.content').slideUp(speed);

				$item.removeClass('open');
			} else {
				$item.addClass('open').siblings('.open').find('.toggle:eq(0)').click();				

				$item.children('.title-wrap').find('h4').animate({
					marginTop: -30
				}, speed).find();

				$item.children('.content').slideDown(speed);
			}

			return false;
		});

		// Removing a row
		$('.remove.notext').die('click').live('click', function() {
			var $list = $(this).closest('li').parent();

			$(this).closest('li').fadeOut(function() {
				$(this).remove();
				$list.trigger('order_changed');
			});

			return false;
		});

		return this.each(function() {
			var $sortable    = $(this).children('.sortable'),
				$add_btn     = $(this).children('.add').size() ? $(this).children('.add') : $(this).siblings('.obo-top-row').find('.add'),
				$order_field = $(this).children('.order-field'),
				$prototype   = $sortable.children('.prototype'),
				current_i    = $sortable.children().size() - $prototype.size();


			// Fixes the order field
			var fix_order = function() {
				var order = [];

				$sortable.children(':not(.prototype,.ui-sortable-placeholder)').each(function() {
					order.push($(this).attr('data-id'));
				});

				$order_field.val(order.join(','));
			}

			// Bind an event to the ul
			$sortable.bind('order_changed.cs', fix_order);

			// Make the boxes sortable
			$sortable.sortable({
				handle: '.drag:eq(0)',
				axis: 'y',
				stop: fix_order
			});

			// Adding a new row
			$add_btn.click(function() {
				var $my_prototype;

				if( $(this).is('.add-text') || $(this).is('.add-image') ) {
					$my_prototype = $prototype.filter('.type-' + ( $(this).is('.add-text') ? 'text' : 'image' ));
				} else {
					$my_prototype = $prototype;
				}

				var $new_row = $my_prototype.clone().removeClass('prototype');
				$prototype.eq(0).before($new_row);

				$new_row.find('input,textarea,select').each(function(){
					if(typeof($(this).attr('name')) == 'undefined') {
						return;
					}

					$(this).attr('name', $(this).attr('name').replace(o.name_placeholder, current_i));
				});

				$new_row.attr('data-id', current_i);

				current_i++;

				$new_row.find('.uploader:not(.prototype .uploader)').upload_button();

				$new_row.fadeIn(function() {
					$(this).find('.toggle:eq(0)').click();
				});

				fix_order();

				$new_row.find('.cslides').custom_slider({ name_placeholder: '%e%' })

				return false;
			});
		});
	}

	window.init_slider_settings = function(pt_name, slider_path) {
		var $type_switch = $('[name=slider_type]');
		var $default_box = $('#' + pt_name + '-default-box');
		var $custom_box  = $('#' + pt_name + '-obo-box');

		window.slider_path = slider_path;

		// The user should not be able to hide/show the meta boxes
		$('#' + pt_name + '-obo-box-hide, #' + pt_name + '-default-box-hide').parent().hide();

		// Show the appropriate box when needed
		$type_switch.change(function() {
			if(!$(this).is(':checked'))
				return;

			var custom = $(this).val() == 'one-by-one';

			if(custom) {
				$default_box.slideUp();
				$custom_box.slideDown();
			} else {
				$custom_box.slideUp();
				$default_box.slideDown();
			}
		});

		// Hide all boxes by default and show if checked
		if(!$type_switch.filter(':checked').size()) {
			$default_box.hide();
			$custom_box.hide();
		} else {
			$.fx.off = true;
			$type_switch.change();
			$.fx.off = false;
		}

		// Init the uploader
		$('.uploader:not(.prototype .uploader)').upload_button();

		// Init normal sliders
		$('.cslides:not(.cparts)').custom_slider({
			name_placeholder: '%d%'
		});

		// Init normal sliders
		$('.cparts:not(.prototype .cparts)').custom_slider({
			name_placeholder: '%e%'
		});
	}

})(jQuery);