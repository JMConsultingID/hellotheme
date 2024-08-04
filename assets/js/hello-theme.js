(function( $ ) {
	'use strict';
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

    // Initialize tippy tooltips
    document.addEventListener("DOMContentLoaded", function() {
        tippy(".hello-theme-label-tooltips", {
            theme: 'light',
            placement: 'right',
            arrow: false,
            animation: 'fade',
            allowHTML: true,
            interactive: true,
            delay: [100, 100],
        });
    });


})( jQuery );
