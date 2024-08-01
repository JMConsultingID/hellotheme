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
        $order_key = $order->get_order_key();

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
                ?>
                <script>
                    gtag('event', 'purchase', {
                        "transaction_id": "<?php echo $order->get_order_number(); ?>",
                        "value": <?php echo $order->get_total(); ?>,
                        "currency": "<?php echo get_woocommerce_currency(); ?>",
                        "items": <?php echo json_encode($order->get_items()); ?>
                    });
                </script>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push({
                        'event': 'purchase',
                        'transactionId': '<?php echo $order->get_order_number(); ?>',
                        'transactionTotal': <?php echo $order->get_total(); ?>,
                        'transactionCurrency': '<?php echo get_woocommerce_currency(); ?>',
                        'transactionProducts': <?php echo json_encode($order->get_items(), JSON_HEX_TAG); ?>
                    });
                </script>
                <?php
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

function hello_theme_redirect_cart_to_home() {
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
add_action( 'template_redirect', 'hello_theme_redirect_cart_to_home' );