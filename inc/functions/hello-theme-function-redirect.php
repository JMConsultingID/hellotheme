<?php
function hello_theme_woo_settings_tab( $settings_tabs ) {
    $settings_tabs['custom_redirects'] = 'Hello Theme Redirects';
    return $settings_tabs;
}
add_filter( 'woocommerce_settings_tabs_array', 'hello_theme_woo_settings_tab', 50 );

function hello_theme_woo_settings() {
    woocommerce_admin_fields( get_hello_theme_woo_settings() );
}

add_action( 'woocommerce_settings_custom_redirects', 'hello_theme_woo_settings' );


function save_hello_theme_woo_settings() {
    woocommerce_update_options( get_hello_theme_woo_settings() );
}
add_action( 'woocommerce_update_options_custom_redirects', 'save_hello_theme_woo_settings' );

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
    );

    return $settings;
}

function hello_theme_redirect_after_purchase( $order_id ) {
    $order = wc_get_order( $order_id );
    $status = $order->get_status();

    $thank_you_page_id = get_option( 'hello_theme_thank_you_page_url' );
    $failed_page_id = get_option( 'hello_theme_failed_page_url' );
    $on_hold_page_id = get_option( 'hello_theme_on_hold_page_url' );

    $thank_you_page_url = $thank_you_page_id ? get_permalink( $thank_you_page_id ) : home_url();
    $failed_page_url = $failed_page_id ? get_permalink( $failed_page_id ) : home_url();
    $on_hold_page_url = $on_hold_page_id ? get_permalink( $on_hold_page_id ) : home_url();

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
add_action( 'woocommerce_thankyou', 'hello_theme_redirect_after_purchase' );

?>