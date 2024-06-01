(function( $ ) {
	'use strict';
	$(document.body).on('country_to_state_changed', function() {
		$('.hello-theme-address-field').addClass('form-row-first'); 
        $('.hello-theme-country-field').addClass('form-row-first'); 
        $('.hello-theme-state-field').addClass('form-row-last');  
    });


})( jQuery );
