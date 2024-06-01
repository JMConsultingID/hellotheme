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
add_filter( 'woocommerce_order_button_text', 'hello_theme_wc_custom_order_button_text' );
function hello_theme_wc_custom_order_button_text() {
    return __( 'PROCEED TO PAYMENT', 'woocommerce' );
}

add_filter('woocommerce_checkout_fields', 'hello_theme_modify_woocommerce_billing_fields', 18, 1);
function hello_theme_modify_woocommerce_billing_fields($fields)
{   
    // Remove Default Field
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);    
    unset($fields['billing']['billing_address_2']);

    // Add Hello Theme Field
    $fields['billing']['billing_address_1'] = array(
        'type'        => 'text',
        'label'       => __('Address', 'woocommerce'),
        'required'    => true,
        'class'       => array('address-field','hello-theme-checkout-field'),
        'clear'       => true,
        'priority'    => 40,
    );
    return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'ganti_alamat_penagihan' );
function ganti_alamat_penagihan( $fields ) {
    // Hapus field lama
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);

    // Tambahkan field baru
    $fields['billing']['billing_address'] = array(
        'label'       => __('Address', 'woocommerce'),
        'placeholder' => _x('Address address', 'placeholder', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-first'),
        'clear'       => true,
        'priority' => 50 // Prioritas field baru
    );

    return $fields;
}

?>
