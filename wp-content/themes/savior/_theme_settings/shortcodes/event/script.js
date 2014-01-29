// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.js_event', {
	
		init : function(ed, url) {  
            ed.addButton('js_event_button', {  
                title : 'Single Event',  
                image : url+'/icon_event.png',  
                onclick : function() {
					// triggers the thickbox
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Single Event', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=js_event-form' );
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;  
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_event', tinymce.plugins.js_event);
	
	// executes this when the DOM is ready
	jQuery(function(){
	
		var eventListOptions = '';
	
		for (var prop in eventList) {
			if (eventList.hasOwnProperty(prop)) { 
		    	eventListOptions += '<option value="'+prop+'">'+eventList[prop]+'</option>';
		    }
		}
		
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="js_event-form"><div class="shortcode-form">\
			<h2>Single Event</h2>\
			<table id="js_event-table" class="form-table">\
			<tr>\
				<th><label for="js_event-id">Event to Display</label></th>\
				<td><select name="id" id="js_event-id">'+eventListOptions+'</select><br />\
				<small>Choose an event to display, or simply load the next upcoming event.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="js_event-submit" class="button-primary" value="Add Event" name="submit" />\
		</p>\
		</div></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#js_event-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'id' : 0,
				};
			var shortcode = '[display-event';
			
			for( var index in options) {
				var currentInput = table.find('#js_event-' + index);
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