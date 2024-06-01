(function( $ ) {
	'use strict';
	$(document).ready(function() {
		$('.hello-theme-address-field').addClass('form-row-first'); 
        $('.hello-theme-country-field').addClass('form-row-first'); 
        $('.hello-theme-state-field').addClass('form-row-last');  
    });

    function changeBillingAddressLabel() {
        var addressField = $('#billing_address_1_field label');
        if (addressField.length && addressField.text().trim() !== 'Address') {
            addressField.text('Address');
        }
    }

    // Change label on page load
    changeBillingAddressLabel();

    // Change label after AJAX update
    $(document.body).on('updated_checkout', function() {
        changeBillingAddressLabel();
    });


})( jQuery );
