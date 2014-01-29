// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.js_galleryPosts', {
	
		init : function(ed, url) {  
            ed.addButton('js_galleryPosts_button', {  
                title : 'List Gallery Posts',  
                image : url+'/icon_galleries.png',  
                onclick : function() {
					// triggers the thickbox
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'List Gallery Posts', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=js_galleryPosts-form' );
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;  
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_galleryPosts', tinymce.plugins.js_galleryPosts);
	
	// executes this when the DOM is ready
	jQuery(function(){
	
		var galleryCategoryOptions = '';
	
		for (var prop in galleryCategories) {
			if (galleryCategories.hasOwnProperty(prop)) { 
		    	galleryCategoryOptions += '<option value="'+prop+'">'+galleryCategories[prop]+'</option>';
		    }
		}
	
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="js_galleryPosts-form"><div class="shortcode-form">\
			<h2>Posts</h2>\
			<table id="js_galleryPosts-table" class="form-table">\
			<tr>\
				<th><label for="js_galleryPosts-category">Galleries Category</label></th>\
				<td><select name="category" id="js_galleryPosts-category">\
					<option value="">All Galleries</option>'+galleryCategoryOptions+'</select><br />\
				<small>Specify the category of posts to display.</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_galleryPosts-count">How many galleries to display?</label></th>\
				<td><input type="text" name="postCount" id="js_galleryPosts-count" value="0" /><br />\
				<small>How many galleries do you want to display? Leave as "0" to display all of them.</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_galleryPosts-orderby">Gallery Order</label></th>\
				<td><select name="orderby" id="js_galleryPosts-orderby">\
					<option value="newest-first">Post Date (newest first)</option>\
					<option value="oldest-first">Post Date (oldest first)</option>\
					<option value="menu-order">Menu Order</option>\
					<option value="alphabetical">Alphabetical</option>\
					<option value="random">Random</option>\
				</select><br />\
				<small>How do you want to order your galleries?</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_galleryPosts-title">Gallery Title (optional)</label></th>\
				<td><input type="text" name="title" id="js_galleryPosts-title" value="" /><br />\
				<small>Display an optional title at the top/left of the galleries.</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_galleryPosts-buttontext">Button Text (optional)</label></th>\
				<td><input type="text" name="buttontext" id="js_galleryPosts-buttontext" value="" /><br />\
				<small>Display an optional button at the top/right of the galleries.</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_galleryPosts-buttonlink">Button Link (optional)</label></th>\
				<td><input type="text" name="buttonlink" id="js_galleryPosts-buttonlink" value="" /><br />\
				<small>Enter the URL to which you want the button to link.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="js_galleryPosts-submit" class="button-primary" value="Add Posts" name="submit" />\
		</p>\
		</div></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#js_galleryPosts-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'category'      : '',
				'count'			: '',
				'orderby'		: '',
				'title'			: '',
				'buttonlink'	: '',
				'buttontext'	: '',
				};
			var shortcode = '[display-galleries';
			
			for( var index in options) {
				var currentInput = table.find('#js_galleryPosts-' + index);
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