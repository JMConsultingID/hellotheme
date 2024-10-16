<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
function hello_theme_redirect_after_purchase( $order_id ) {
    if ( get_option( 'enable_thank_you_redirect' ) == '1' ) {
        $order = wc_get_order( $order_id );
        $status = $order->get_status();
        $order_key = $order->get_order_key(); // Retrieve the order key

        $thank_you_page_id = get_option( 'hello_theme_thank_you_page_url' );
        $failed_page_id = get_option( 'hello_theme_failed_page_url' );
        $on_hold_page_id = get_option( 'hello_theme_on_hold_page_url' );

        $thank_you_page_url = $thank_you_page_id ? get_permalink( $thank_you_page_id ) : home_url();
        $failed_page_url = $failed_page_id ? get_permalink( $failed_page_id ) : home_url();
        $on_hold_page_url = $on_hold_page_id ? get_permalink( $on_hold_page_id ) : home_url();

        // Append order_id and order_key to the thank_you_page_url
        $thank_you_page_url = add_query_arg( array(
            'order_id' => $order_id,
            'order_key' => $order_key,
        ), $thank_you_page_url );

        switch ( $status ) {
            case 'completed':
                wp_safe_redirect( $thank_you_page_url );
                exit;
            case 'failed':
                wp_safe_redirect( $failed_page_url );
                exit;
            case 'on-hold':
                wp_safe_redirect( $on_hold_page_url );
                exit;
            default:
                wp_safe_redirect( home_url() );
                exit;
        }
    }
}
add_action( 'woocommerce_thankyou', 'hello_theme_redirect_after_purchase' );

add_action('wp_footer', 'hello_theme_add_ga_gtm_script_to_thank_you_page', 10);

function hello_theme_add_ga_gtm_script_to_thank_you_page() {
    $enable_ecommerce_tracking = get_option( 'enable_ecommerce_tracking' );
    $thank_you_page_id = get_option( 'hello_theme_thank_you_page_url' );

    // If the $enable_ecommerce_tracking is not '1', return early
    if ($enable_ecommerce_tracking !== '1') {
        return;
    }

    if (is_page($thank_you_page_id) && isset($_GET['order_id']) && isset($_GET['order_key'])) {
        $order_id = sanitize_text_field($_GET['order_id']);
        $order = wc_get_order($order_id);

        if ($order) {
            $status = $order->get_status();
            $transaction_id = $order->get_order_number();
            $transaction_total = $order->get_total();
            $currency = get_woocommerce_currency();
            $billing_email = $order->get_billing_email();
            $billing_country = $order->get_billing_country();
            $billing_city = $order->get_billing_city();
            $billing_phone = $order->get_billing_phone();
            $items = $order->get_items();
            $products = [];

            foreach ($items as $item) {
                $products[] = [
                    'item_id' => $item->get_product_id(),
                    'item_name' => $item->get_name(),
                    'price' => $item->get_total(),
                    'quantity' => $item->get_quantity(),
                ];
            }

            $products_json = json_encode($products, JSON_HEX_TAG);

            if ($status === 'completed') {
                ?>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push({
                        event: 'purchase',
                        billing_email: '<?php echo $billing_email; ?>',
                        billing_country: '<?php echo $billing_country; ?>',
                        billing_city: '<?php echo $billing_city; ?>',
                        billing_phone: '<?php echo $billing_phone; ?>',
                        ecommerce: {
                            transaction_id: '<?php echo $transaction_id; ?>',
                            value: <?php echo $transaction_total; ?>,
                            currency: '<?php echo $currency; ?>',
                            coupon: 'SUMMER_SALE', // Add dynamic coupon logic if needed
                            items: <?php echo $products_json; ?>
                        }
                    });

                    // Facebook Meta Pixel Purchase Event
                    // fbq('track', 'Purchase', {
                    //     value: <?php echo $transaction_total; ?>,
                    //     currency: '<?php echo $currency; ?>',
                    //     contents: <?php echo $products_json; ?>,
                    //     content_type: 'product'
                    // });
                </script>
                <?php
            } else {
                ?>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push({
                        event: 'not_completed',
                        transactionProducts: <?php echo $products_json; ?>
                    });

                    // Facebook Meta Pixel Not Completed Event
                    //fbq('track', 'NotCompleted', {
                       // contents: <?php echo $products_json; ?>,
                        //content_type: 'product'
                    //});
                </script>
                <?php
            }
        }
    } else {
        ?>
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                'event': 'page_view',
                'page_id': '<?php echo $thank_you_page_id; ?>'
            });
            // fbq('track', 'PageView');
        </script>
        <?php
    }
}


function hello_theme_redirect_cart_to_home() {
    // Check if WooCommerce is installed and active
    if ( class_exists( 'WooCommerce' ) ) {
        if ( get_option( 'enable_thank_you_redirect' ) == '1' ) {
            if ( get_option( 'skip_cart_page' ) == '1' && ( is_page( 'cart' ) || ( isset( $_GET['cancel_order'] ) && $_GET['cancel_order'] === 'true' ) ) ) {
                $home_page_url = home_url();
                wp_safe_redirect( $home_page_url );
                exit;
            }
        }

        // Check if shop page is disabled
        if ( is_shop() && get_option( 'disable_shop_page' ) == '1' ) {
            $home_page_url = home_url();
            wp_safe_redirect( $home_page_url );
            exit;
        }

        // Check if product page is disabled
        if ( is_product() && get_option( 'disable_product_page' ) == '1' ) {
            $home_page_url = home_url();
            wp_safe_redirect( $home_page_url );
            exit;
        }
    }
}
add_action( 'template_redirect', 'hello_theme_redirect_cart_to_home' );
