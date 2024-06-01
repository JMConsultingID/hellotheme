(function( $ ) {
	'use strict';
    function changeBillingAddressLabel() {
        var addressField = $('#billing_address_1_field label');
        if (addressField.length && addressField.text().trim() !== 'Address') {
            addressField.text('Address');
        }
    }

    function adjustCheckoutFieldClasses() {
        // Target and adjust classes for specific fields
        $('#billing_email_field').addClass('form-row-wide');

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
