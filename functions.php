<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_THEME_VERSION', '2.1.3' );

/**
 * Load hello theme scripts & styles.
 *
 * @return void
 */
require_once get_stylesheet_directory() . '/inc/functions/hello-theme-functions.php';

function hello_theme_scripts_styles() {
    wp_enqueue_style('hello-theme-style', get_stylesheet_directory_uri() . '/style.css', [], HELLO_THEME_VERSION);
    wp_enqueue_style('hello-theme-custom-style', get_stylesheet_directory_uri() . '/assets/css/hello-theme.css', [], HELLO_THEME_VERSION);
    wp_enqueue_script('hello-theme-custom-script', get_stylesheet_directory_uri() . '/assets/js/hello-theme.js', [], HELLO_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'hello_theme_scripts_styles', 20);

function hello_theme_move_coupon_field_below_order_review() {
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}
add_action( 'woocommerce_checkout_init', 'hello_theme_move_coupon_field_below_order_review' );


function hello_theme_enqueue_coupon_script() {
    if (is_checkout()) {
        wp_enqueue_script('hello-theme-coupon-ajax', get_stylesheet_directory_uri() . '/assets/js/hello-theme-coupon-ajax.js', array('jquery'), null, true);
        wp_localize_script('hello-theme-coupon-ajax', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'hello_theme_enqueue_coupon_script');

function hello_theme_apply_coupon_action() {
    if (!isset($_POST['coupon_code'])) {
        wp_send_json_error('Coupon code not provided.');
    }

    $coupon_code = sanitize_text_field($_POST['coupon_code']);
    WC()->cart->add_discount($coupon_code);

    if (wc_notice_count('error') > 0) {
        $errors = wc_get_notices('error');
        wc_clear_notices();
        wp_send_json_error(join(', ', wp_list_pluck($errors, 'notice')));
    }

    wp_send_json_success();
}
add_action('wp_ajax_apply_coupon_action', 'hello_theme_apply_coupon_action');
add_action('wp_ajax_nopriv_apply_coupon_action', 'hello_theme_apply_coupon_action');

function hello_theme_add_coupon_form_before_payment() {
    echo '<div class="hello-theme-coupon-form">
        <label for="coupon_code_field" style="display: block; margin-bottom: 15px;">If you have a coupon code, please apply it below.</label>
        <div style="display: flex; align-items: center;">
            <input type="text" id="coupon_code_field" name="coupon_code" placeholder="Apply Coupon Code"/>
            <button type="button" id="apply_coupon_button">Apply Coupon</button>
        </div>
    </div>';
}
add_action('woocommerce_review_order_before_payment', 'hello_theme_add_coupon_form_before_payment');

function fyt_affiliate_redirect() {
    // Get the current request URI.
    $request_uri = $_SERVER['REQUEST_URI'];
    // Get the full URL including query string.
    $full_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


    // Check for the presence of 'ref' as a query parameter.
    if (strpos($full_url, '?ref=') !== false || preg_match('|^/ref/[\w-]+/?|', $_SERVER['REQUEST_URI'])) {
        // Construct the new URL to redirect to the homepage of the main site.
        $new_url = "https://www.fundyourtrading.io/";

        // Perform the redirection to the main site.
        wp_redirect($new_url, 301);
        exit;
    }

    // Match the /ref/{string}/ structure (with or without query parameters).
    if (preg_match('|^/ref/([\w-]+)/?(\?.*)?$|', $request_uri, $matches)) {
        // Extract the string from the matches.
        $dynamic_string = $matches[1];

        // Check for query string and extract if it exists.
        $query_string = isset($matches[2]) ? $matches[2] : '';
        
        // Perform the redirection.
        wp_redirect('https://fundyourtrading.io', 301);
        exit;
    }
    
    // Use a regex pattern to match the /ref/{dynamic_number}/ structure.
    if ( preg_match('|^/ref/([\d\w]+)/?$|', $request_uri, $matches)) {
        // Extract the dynamic number from the matches.
        $dynamic_value = $matches[1];
                
        // Perform the redirection.
        wp_redirect('https://fundyourtrading.io', 301);
        exit;
    }

    // Check if the URL path is just a query string starting with ref.
    if (preg_match('/^\?ref=\d+/', $request_uri)) {
        // Perform the redirection to the main site.
        wp_redirect('https://fundyourtrading.io', 301);
        exit;
    }
}
add_action( 'template_redirect', 'fyt_affiliate_redirect',20 );

// Enable XML-RPC
add_filter('xmlrpc_enabled', '__return_true');

function add_fee_settings_tab($settings_tabs) {
    $settings_tabs['add_fee_settings'] = __('Add Fee Settings', 'woocommerce');
    return $settings_tabs;
}
add_filter('woocommerce_settings_tabs_array', 'add_fee_settings_tab', 50);

function add_fee_settings_fields() {
    woocommerce_admin_fields(get_add_fee_settings());
}
add_action('woocommerce_settings_add_fee_settings', 'add_fee_settings_fields');

function get_add_fee_settings() {
    $settings = array(
        'section_title' => array(
            'name' => __('Add Fee Settings', 'woocommerce'),
            'type' => 'title',
            'desc' => '',
            'id' => 'add_fee_settings_section_title'
        ),
        'enable_add_fee' => array(
            'name' => __('Enable Add Fee', 'woocommerce'),
            'type' => 'checkbox',
            'desc' => __('Enable or disable the add fee feature.', 'woocommerce'),
            'id' => 'enable_add_fee'
        ),
        'fee_type' => array(
            'name' => __('Fee Type', 'woocommerce'),
            'type' => 'select',
            'desc' => __('Select the fee type.', 'woocommerce'),
            'id' => 'fee_type',
            'options' => array(
                'fixed' => __('Fixed', 'woocommerce'),
                'percentage' => __('Percentage', 'woocommerce')
            )
        ),
        'fee_value' => array(
            'name' => __('Fee Value', 'woocommerce'),
            'type' => 'number',
            'desc' => __('Set the fee value. Default is 15.', 'woocommerce'),
            'id' => 'fee_value',
            'default' => 15,
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            )
        ),
        'section_end' => array(
            'type' => 'sectionend',
            'id' => 'add_fee_settings_section_end'
        )
    );
    return $settings;
}

function save_add_fee_settings() {
    woocommerce_update_options(get_add_fee_settings());
}
add_action('woocommerce_update_options_add_fee_settings', 'save_add_fee_settings');

function add_custom_fee_dynamic() {
    if (!is_admin() && is_checkout()) {
        global $woocommerce;

        $enable_add_fee = get_option('enable_add_fee');
        $fee_type = get_option('fee_type');
        $fee_value = get_option('fee_value', 15);

        if ('yes' === $enable_add_fee) {
            $fee_name = "Platform Fee";
            $fee = 0;

            if ($fee_type === 'fixed') {
                $fee = $fee_value;
            } elseif ($fee_type === 'percentage') {
                $cart_subtotal = $woocommerce->cart->get_subtotal();
                $fee = ($cart_subtotal * $fee_value) / 100;
            }

            $woocommerce->cart->add_fee($fee_name, $fee);
        }
    }
}
add_action('woocommerce_cart_calculate_fees', 'add_custom_fee_dynamic');
