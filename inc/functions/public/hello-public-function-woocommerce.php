<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

// Disable add to cart messages and setup single product checkout mode
function setup_single_product_checkout_mode() {
    if ( get_option( 'hello_theme_checkout_mode' ) === 'single' ) {
        // Disable add to cart messages
        add_filter( 'wc_add_to_cart_message_html', '__return_false' );
        
        // Empty the cart before adding a new product
        add_filter( 'woocommerce_add_cart_item_data', '_hello_theme_additional_empty_cart' );
        
        // Redirect to the checkout page after adding the product to the cart
        add_filter( 'woocommerce_add_to_cart_redirect', 'hello_theme_additional_add_to_cart_redirect' );
    }
}
add_action( 'init', 'setup_single_product_checkout_mode' );

// Function to empty the cart before adding a new product
function _hello_theme_additional_empty_cart( $cart_item_data ) {
    WC()->cart->empty_cart(); // Clear cart before adding a new product
    return $cart_item_data; // Proceed with adding the new product
}

// Function to redirect to the checkout page after product is added
function hello_theme_additional_add_to_cart_redirect() {
    return wc_get_checkout_url(); // Redirect to checkout
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
    // unset($fields['billing']['billing_company']);    
    // unset($fields['billing']['billing_address_2']);

    // Change Priority Field
    $fields['billing']['billing_email']['priority'] = 5;
    // $fields['billing']['billing_address_1']['priority'] = 30;
    // $fields['billing']['billing_country']['priority'] = 40;
    // $fields['billing']['billing_state']['priority'] = 50;
    return $fields;
}

//add_filter('woocommerce_checkout_fields', 'hello_theme_checkout_fields_order_and_class');
function hello_theme_checkout_fields_order_and_class($fields) {
    $billing_fields_order = array(
        'billing_email' => array(
            'label'       => __('Email', 'woocommerce'),
            'placeholder' => _x('Email address', 'placeholder', 'woocommerce'),
            'required'    => true,
            'class'       => array('form-row-wide hello-theme-checkout-field'),
            'clear'       => true,
            'priority' => 10 
        ),
        'billing_first_name' => array(
            'label'       => __('First Name', 'woocommerce'), 
            'placeholder' => _x('First name', 'placeholder', 'woocommerce'), 
            'required'    => true,
            'class'       => array('form-row-first hello-theme-checkout-field'),
            'clear'       => false, 
            'priority' => 20
        ),
        'billing_last_name' => array(
            'label'       => __('Last Name', 'woocommerce'), 
            'placeholder' => _x('Last name', 'placeholder', 'woocommerce'), 
            'required'    => true,
            'class'       => array('form-row-last hello-theme-checkout-field'),
            'clear'       => false, 
            'priority' => 30
        ),
        'billing_address_1' => array( 
            'label'       => __('Address', 'woocommerce'),
            'placeholder' => _x('Street address', 'placeholder', 'woocommerce'),
            'required'    => false,
            'class'       => array('form-row-wide hello-theme-checkout-field'),
            'clear'       => true,
            'priority' => 40
        ),
        'billing_country' => array(
            'label'       => __('Country', 'woocommerce'), 
            'required'    => true,
            'type'        => 'country',
            'class'       => array('form-row-wide hello-theme-checkout-field'),
            'clear'       => true,
            'priority' => 50
        ),
        'billing_state' => array(
            'label'       => __('State', 'woocommerce'),
            'required'    => false,
            'type'        => 'state',
            'class'       => array('form-row-wide hello-theme-checkout-field'),
            'clear'       => false,
            'priority' => 60
        ),
        'billing_city' => array(
            'label'       => __('Town / City', 'woocommerce'), // Default label for billing_city
            'placeholder' => _x('Town / City', 'placeholder', 'woocommerce'), 
            'required'    => false,
            'class'       => array('form-row-wide hello-theme-checkout-field'),
            'clear'       => true,
            'priority' => 70
        ),
        'billing_postcode' => array(
            'label'       => __('Postcode / ZIP', 'woocommerce'), 
            'placeholder' => _x('Postcode / ZIP', 'placeholder', 'woocommerce'), 
            'required'    => false,
            'class'       => array('form-row-wide hello-theme-checkout-field'),
            'clear'       => false, 
            'priority' => 80
        ),

        'billing_phone' => array(
            'label'       => __('Phone', 'woocommerce'),
            'placeholder' => _x('Phone number', 'placeholder', 'woocommerce'),
            'required'    => false,
            'class'       => array('form-row-wide hello-theme-checkout-field'),
            'clear'       => false, 
            'priority' => 90
        ),
    );
    $fields['billing'] = $billing_fields_order;
    return $fields;
}
function hello_theme_woocommerce_checkout_terms_and_conditions() {
  remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
}
add_action( 'wp', 'hello_theme_woocommerce_checkout_terms_and_conditions' );

// Function to hide specific countries on WooCommerce checkout
function hello_theme_woocommerce_checkout_hide_countries_on_checkout($countries) {
    // Array of country codes to hide
    $countries_to_hide = array(''); // Add the country codes you want to hide

    foreach ($countries_to_hide as $country_code) {
        if (isset($countries[$country_code])) {
            unset($countries[$country_code]);
        }
    }

    return $countries;
}

// Hook the function to the WooCommerce checkout fields filter
add_filter('woocommerce_countries', 'hello_theme_woocommerce_checkout_hide_countries_on_checkout', 10, 1);

?>