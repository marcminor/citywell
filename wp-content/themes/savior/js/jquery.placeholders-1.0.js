jQuery(document).ready(function($) {

	jQuery.fn.do_placeholders = function() {
		var browser_supports_placeholder = !!("placeholder" in (document.createElement('input')));
		if (browser_supports_placeholder) {
			return;
		}
	
		this.each(function() {
			// Do not re-initialize
			if ($(this).data("did_placeholder")) {
				return;
			}
	
			var original_value = this.value;
			if (original_value == '' && this.type != 'password') {
				this.value = this.getAttribute('placeholder');
			}
			$(this).data("did_placeholder", true);
		});
	
		$(document).on('focusin', this.selector, function() {
			if(this.value == this.getAttribute('placeholder')) {
				this.value = '';
			}
		}).on('focusout', this.selector, function() {
			if(this.value == '' && this.type != 'password') {
				this.value = this.getAttribute('placeholder');
			}
		});
	}
	jQuery.do_placeholders = function ( ) {
		$('input[placeholder], textarea[placeholder]').do_placeholders();
	}

});