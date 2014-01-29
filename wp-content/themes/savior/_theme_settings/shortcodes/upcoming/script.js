// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.js_upcoming', {
	
		init : function(ed, url) {  
            ed.addButton('js_upcoming_button', {  
                title : 'Upcoming Events',  
                image : url+'/icon_upcoming.png',  
                onclick : function() {
					// triggers the thickbox
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Upcoming Events', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=js_upcoming-form' );
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;  
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_upcoming', tinymce.plugins.js_upcoming);
	
	// executes this when the DOM is ready
	jQuery(function(){
	
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="js_upcoming-form"><div class="shortcode-form">\
			<h2>Upcoming</h2>\
			<table id="js_upcoming-table" class="form-table">\
			<tr>\
				<th><label for="js_upcoming-count">How many upcoming events to display?</label></th>\
				<td><input type="text" name="upcomingCount" id="js_upcoming-count" value="5" /><br />\
				<small>How many upcoming events do you want to display?</small>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="js_upcoming-submit" class="button-primary" value="Add Upcoming Events" name="submit" />\
		</p>\
		</div></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#js_upcoming-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'count'			: ''
				};
			var shortcode = '[upcoming-events';
			
			for( var index in options) {
				var currentInput = table.find('#js_upcoming-' + index);
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