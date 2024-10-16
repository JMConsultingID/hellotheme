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

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('HELLO_THEME_VERSION', '2.1.8');

/**
 * Load hello theme scripts & styles.
 *
 * @return void
 */
require_once get_stylesheet_directory() . '/inc/functions/hello-theme-functions.php';

function hello_theme_scripts_styles()
{
    wp_enqueue_style('hello-theme-style', get_stylesheet_directory_uri() . '/style.css', [], HELLO_THEME_VERSION);
    wp_enqueue_style('hello-theme-custom-style', get_stylesheet_directory_uri() . '/assets/css/hello-theme.css', [], HELLO_THEME_VERSION);
    wp_enqueue_script('hello-theme-custom-script', get_stylesheet_directory_uri() . '/assets/js/hello-theme.js', [], HELLO_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'hello_theme_scripts_styles', 20);

function hello_theme_move_coupon_field_below_order_review()
{
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
}
add_action('woocommerce_checkout_init', 'hello_theme_move_coupon_field_below_order_review');


function hello_theme_enqueue_coupon_script()
{
    if (is_checkout()) {
        wp_enqueue_script('hello-theme-coupon-ajax', get_stylesheet_directory_uri() . '/assets/js/hello-theme-coupon-ajax.js', array('jquery'), null, true);
        wp_localize_script('hello-theme-coupon-ajax', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'hello_theme_enqueue_coupon_script');

function hello_theme_apply_coupon_action()
{
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

function hello_theme_add_coupon_form_before_payment()
{
    echo '<div class="hello-theme-coupon-form">
        <label for="coupon_code_field" style="display: block; margin-bottom: 15px;">If you have a coupon code, please apply it below.</label>
        <div style="display: flex; align-items: center;">
            <input type="text" id="coupon_code_field" name="coupon_code" placeholder="Apply Coupon Code"/>
            <button type="button" id="apply_coupon_button">Apply Coupon</button>
        </div>
    </div>';
}
add_action('woocommerce_review_order_before_payment', 'hello_theme_add_coupon_form_before_payment');


add_action('wp_footer', 'hello_theme_affwp_register_form_script');
add_filter('affwp_tracking_cookie_compat_mode', '__return_true');
add_filter('affwp_get_referring_affiliate_id', function ($affiliate_id, $reference, $context) {
    if ('woocommerce' === $context) {
        $affiliate_id = affiliate_wp()->tracking->get_affiliate_id();
    }

    return $affiliate_id;
}, 10, 3);

function hello_theme_product_combinations()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'hello_theme_product_combinations';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        category varchar(55) NOT NULL,
        account_type varchar(55) NOT NULL,
        challenge varchar(55) NOT NULL,
        addon_active_days varchar(3) NOT NULL,
        addon_profitsplit varchar(3) NOT NULL,
        addon_peak_active_days varchar(3) NOT NULL,
        addon_trading_days varchar(3) NOT NULL,
        product_id bigint(20) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('after_switch_theme', 'hello_theme_product_combinations');