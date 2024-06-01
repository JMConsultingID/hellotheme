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

add_filter( 'woocommerce_checkout_fields' , 'hello_theme_modify_woocommerce_billing_fields' );
function hello_theme_modify_woocommerce_billing_fields( $fields ) {
    // Remove Default Field
    unset($fields['billing']['billing_company']);    
    unset($fields['billing']['billing_address_2']);
    return $fields;
}

add_filter('woocommerce_checkout_fields', 'hello_theme_checkout_fields_order_and_class');
function hello_theme_checkout_fields_order_and_class($fields) {
    $billing_fields_order = array(
        'billing_email' => array(
            'label'       => __('Email', 'woocommerce'),
            'placeholder' => _x('Email address', 'placeholder', 'woocommerce'),
            'required'    => true,
            'class'       => array('form-row-wide'),
            'clear'       => true,
            'priority' => 10 // You can adjust the priority as needed
        ),
        'billing_first_name' => array(
            'class' => array('form-row-first'),
            'priority' => 20
        ),
        'billing_last_name' => array(
            'class' => array('form-row-last'),
            'priority' => 30
        ),
        'billing_address_1' => array( // Assuming you want to use billing_address_1 for Address
            'label'       => __('Address', 'woocommerce'),
            'placeholder' => _x('Street address', 'placeholder', 'woocommerce'),
            'required'    => true,
            'class'       => array('form-row-first'),
            'clear'       => true,
            'priority' => 40
        ),
        'billing_phone' => array(
            'class' => array('form-row-last'),
            'priority' => 50
        ),
        'billing_country' => array(
            'class' => array('form-row-first'),
            'priority' => 60
        ),
        'billing_state' => array(
            'class' => array('form-row-last'),
            'priority' => 70
        ),
        'billing_city' => array(
            'class' => array('form-row-first'),
            'priority' => 80
        ),
        'billing_postcode' => array(
            'class' => array('form-row-last'),
            'priority' => 90
        )
    );

    // Overwrite the existing billing fields with our custom order and classes
    $fields['billing'] = $billing_fields_order;

    return $fields;
}


?>
