<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
function hello_theme_woo_settings_tab( $settings_tabs ) {
    $settings_tabs['hello_theme_redirects'] = 'Hello Theme Settings';
    return $settings_tabs;
}
add_filter( 'woocommerce_settings_tabs_array', 'hello_theme_woo_settings_tab', 50 );

function hello_theme_woo_settings() {
    woocommerce_admin_fields( get_hello_theme_woo_settings() );
}

add_action( 'woocommerce_settings_hello_theme_redirects', 'hello_theme_woo_settings' );


function save_hello_theme_woo_settings() {
    woocommerce_update_options( get_hello_theme_woo_settings() );
}
add_action( 'woocommerce_update_options_hello_theme_redirects', 'save_hello_theme_woo_settings' );

function hello_theme_get_pages_array() {
    $pages = get_pages();
    $pages_array = array();
    foreach ( $pages as $page ) {
        $pages_array[ $page->ID ] = $page->post_title;
    }
    return $pages_array;
}

function get_hello_theme_woo_settings() {
    $pages = hello_theme_get_pages_array();
    $settings = array(
        'section_title' => array(
            'name'     => 'Hello Theme Redirects Settings',
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'hello_theme_redirects_section_title'
        ),
        'checkout_mode' => array(
            'name' => 'Select Checkout Mode',
            'type' => 'select',
            'desc' => 'Select Checkout Mode: Single Product and Multiple Products',
            'id'   => 'hello_theme_checkout_mode',
            'options' => array(
                'single' => 'Single Product',
                'multiple' => 'Multiple Products'
            ),
            'default' => 'single'
        ),
        'enable_thank_you_redirect' => array(
            'name' => 'Enable Thank You Page Redirect',
            'type' => 'checkbox',
            'desc' => 'Enable redirect to specific pages based on order status.',
            'id'   => 'enable_thank_you_redirect'
        ),
        'skip_cart' => array(
            'name' => 'Skip Cart Page',
            'type' => 'checkbox',
            'desc' => 'Skip the cart page and redirect to home page.',
            'id'   => 'skip_cart_page'
        ),
        'thank_you_page' => array(
            'name' => 'Thank You Page URL',
            'type' => 'select',
            'desc' => 'URL to redirect to after a successful order.',
            'id'   => 'hello_theme_thank_you_page_url',
            'options' => $pages
        ),
        'failed_page' => array(
            'name' => 'Failed Order Page URL',
            'type' => 'select',
            'desc' => 'URL to redirect to after a failed order.',
            'id'   => 'hello_theme_failed_page_url',
            'options' => $pages
        ),
        'on_hold_page' => array(
            'name' => 'On Hold Order Page URL',
            'type' => 'select',
            'desc' => 'URL to redirect to for on-hold orders.',
            'id'   => 'hello_theme_on_hold_page_url',
            'options' => $pages
        ),
        'section_end' => array(
            'type' => 'sectionend',
            'id'   => 'hello_theme_redirects_section_end'
        ),
        'section_title_second' => array(
            'name'     => 'Hello Theme AffiliateWP Settings',
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'hello_theme_redirects_section_second_title'
        ),
        'enable_affiliatewp_config' => array(
            'name' => 'Enable AffiliateWP Configuration',
            'type' => 'checkbox',
            'desc' => 'Enable AffiliateWP Configuration Redirects.',
            'id'   => 'hello_theme_affiliatewp_enable'
        ),
        'affiliatewp_register' => array(
            'name' => 'AffiliateWP Register Page ID',
            'type' => 'select',
            'desc' => 'AffiliateWP Register Page.',
            'id'   => 'hello_theme_affiliatewp_register_id',
            'options' => $pages
        ),
        'affiliatewp_area_login' => array(
            'name' => 'AffiliateWP Area Login Page ID',
            'type' => 'select',
            'desc' => 'AffiliateWP Area Login Page, Please Set the Affiliate Area Slug : <code>/affiliate-area/</code>.',
            'id'   => 'hello_theme_affiliatewp_area_id',
            'options' => $pages
        ),
        'section_end_second' => array(
            'type' => 'sectionend',
            'id'   => 'hello_theme_redirects_section_second_end'
        ),
    );

    return $settings;
}