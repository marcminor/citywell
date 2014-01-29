// closure to avoid namespace collision
(function(){

	var edTest = '';

	// creates the plugin
	tinymce.create('tinymce.plugins.js_calendar', {
	
		init : function(ed, url) {  
            ed.addButton('js_calendar_button', {  
                title : 'Add Calendar',  
                image : url+'/icon_calendar.png',  
                onclick : function() {
                
                	// inserts the shortcode into the active editor
                	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[calendar]');
                	
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_calendar', tinymce.plugins.js_calendar);
	
})()