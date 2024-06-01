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

    function adjustCheckoutFieldClasses() {
        // Target and adjust classes for specific fields
        $('#billing_email_field').addClass('form-row-wide');

        $('#billing_first_name_field').addClass('form-row-first');
        $('#billing_last_name_field').addClass('form-row-last');      

        $('#billing_country_field').addClass('form-row-first');
        $('#billing_state_field').addClass('form-row-last');

        $('#billing_city_field').addClass('form-row-first');
        $('#billing_postcode_field').addClass('form-row-last');

    }

    // Apply classes on page load
    adjustCheckoutFieldClasses();

    // Change label on page load
    changeBillingAddressLabel();

    // Change label after AJAX update
    $(document.body).on('updated_checkout', function() {
        changeBillingAddressLabel();
        adjustCheckoutFieldClasses();
    });


})( jQuery );
