<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

// Disable add to cart messages
add_filter( 'wc_add_to_cart_message_html', '__return_false' );

// Empty cart before adding a new item
add_filter( 'woocommerce_add_cart_item_data', '_empty_cart' );
function _empty_cart( $cart_item_data ) {
    WC()->cart->empty_cart();
    return $cart_item_data;
}

// Redirect to checkout page after adding an item to the cart
add_filter('woocommerce_add_to_cart_redirect', 'hello_funding_add_to_cart_redirect');
function hello_funding_add_to_cart_redirect() {
    return wc_get_checkout_url();
}

// Disable non-base location price adjustments
add_filter( 'woocommerce_adjust_non_base_location_prices', '__return_false' );

// Disable order notes field
add_filter('woocommerce_enable_order_notes_field', '__return_false');

// Change order button text
add_filter( 'woocommerce_order_button_text', 'exf_wc_custom_order_button_text' );
function exf_wc_custom_order_button_text() {
    return __( 'PROCEED TO PAYMENT', 'woocommerce' );
}

add_filter('woocommerce_checkout_fields', 'exf_modify_woocommerce_billing_fields', 18, 1);
function exf_modify_woocommerce_billing_fields($fields)
{
    $fields['billing']['billing_address_1']['label'] = __('Address', 'woocommerce');
    // $fields['billing']['billing_address_1']['class'][0] = 'form-row-first';

    // Remove the billing company field
    unset($fields['billing']['billing_company']);
    // Remove the billing address 2 field
    unset($fields['billing']['billing_address_2']);

    return $fields;
}
?>
