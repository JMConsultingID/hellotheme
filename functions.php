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

define('HELLO_THEME_VERSION', '2.1.31');

/**
 * Load hello theme scripts & styles.
 *
 * @return void
 */
require_once get_stylesheet_directory() . '/inc/functions/hello-theme-functions.php';

function hello_theme_scripts_styles()
{
    wp_enqueue_style('hello-theme-style', get_stylesheet_directory_uri() . '/style.css', [], HELLO_THEME_VERSION);
    //wp_enqueue_style('hello-theme-custom-style', get_stylesheet_directory_uri() . '/assets/css/hello-theme.css', [], HELLO_THEME_VERSION);
    //wp_enqueue_script('hello-theme-custom-script', get_stylesheet_directory_uri() . '/assets/js/hello-theme.js', [], HELLO_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'hello_theme_scripts_styles', 20);

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