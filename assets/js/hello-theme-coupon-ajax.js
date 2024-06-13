(function( $ ) {
	'use strict';
	$(document).ready(function() {
        $('#apply_coupon_button').click(function(e) {
            e.preventDefault();

            var coupon_code = $('#coupon_code_field').val();

            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: {
                    action: 'apply_coupon_action',
                    coupon_code: coupon_code
                },
                success: function(response) {
                    if (response.success) {
                        alert('Coupon applied successfully!');
                        location.reload();
                    } else {
                        alert('Failed to apply coupon: ' + response.data);
                    }
                }
            });
        });
    });

})( jQuery );