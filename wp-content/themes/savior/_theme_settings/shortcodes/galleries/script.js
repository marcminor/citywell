// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.js_galleries', {
	
		init : function(ed, url) {  
            ed.addButton('js_galleries_button', {  
                title : 'Add Gallery',  
                image : url+'/icon_galleries.png',  
                onclick : function() {
					// triggers the thickbox
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Add Gallery', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=js_galleries-form' );
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;  
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_galleries', tinymce.plugins.js_galleries);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="js_galleries-form"><div class="shortcode-form">\
			<h2>Add Gallery</h2>\
			<table id="js_galleries-table" class="form-table">\
			<tr>\
				<th><label for="js_galleries-size">Thumbnail Size</label></th>\
				<td><select name="size" id="js_galleries-size">\
					<option value="thumbnail">Small</option>\
					<option value="medium">Medium</option>\
				</select><br />\
				<small>Specify the image size to use for the thumbnail display.</small></td>\
			</tr>\
			<tr>\
				<th><label>Hide the featured image?</label></th>\
				<td><input type="checkbox" name="hide_featured" id="js_galleries-hide_featured" value="1" /> <label for="js_galleries-hide_featured">Hide Featured Image</label><br />\
				<small>Check this if you don\'t want the featured image to show up in the gallery.</small>\
			</tr>\
			<tr>\
				<th><label>Hide the captions?</label></th>\
				<td><input type="checkbox" name="hide_captions" id="js_galleries-hide_captions" value="1" /> <label for="js_galleries-hide_captions">Hide Captions</label><br />\
				<small>Check this if you don\'t want the captions to show up in the gallery.</small>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="js_galleries-submit" class="button-primary" value="Add Gallery" name="submit" />\
		</p>\
		</div></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#js_galleries-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'size'       	: '',
				'hide_featured'	: '',
				'hide_captions' : ''
				};
			var shortcode = '[display-gallery';
			
			for( var index in options) {
				var currentInput = table.find('#js_galleries-' + index);
				var type = currentInput.attr('type');
				if (type == 'checkbox' || type == 'radio'){
					if (currentInput.is(':checked')){
						var value = currentInput.val();
					} else {
						var value = '';
					}
				} else {
					var value = currentInput.val();
				}
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()