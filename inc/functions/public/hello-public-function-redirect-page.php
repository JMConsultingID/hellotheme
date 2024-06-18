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

        if ( get_option( 'select_custom_url_thank_you_page' ) == '1' ) {
            $thank_you_page_url = 'https://www.fundyourtrading.io/thank-you';
        } else {
            $thank_you_page_id = get_option( 'hello_theme_thank_you_page_url' );
            $failed_page_id = get_option( 'hello_theme_failed_page_url' );
            $on_hold_page_id = get_option( 'hello_theme_on_hold_page_url' );

            $thank_you_page_url = $thank_you_page_id ? get_permalink( $thank_you_page_id ) : home_url();
            $failed_page_url = $failed_page_id ? get_permalink( $failed_page_id ) : home_url();
            $on_hold_page_url = $on_hold_page_id ? get_permalink( $on_hold_page_id ) : home_url();
        }

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