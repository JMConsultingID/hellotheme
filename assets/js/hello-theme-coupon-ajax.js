(function($) {
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
                        // Trigger WooCommerce notices update
                        $('body').trigger('update_checkout');
                    } else {
                        // Display error message using WooCommerce notices
                        if (typeof response.data === 'string') {
                            $('.woocommerce-error, .woocommerce-message').remove();
                            $('form.checkout').prepend('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-updateOrderReview"><ul class="woocommerce-error" role="alert"><li>' + response.data + '</li></ul></div>');
                        } else {
                            $('body').trigger('checkout_error', [response.data]);
                        }
                    }
                }
            });
        });
    });

})(jQuery);
