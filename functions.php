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


//Theme Activation
function hello_theme_ypf_addons_create_table() {
    global $wpdb;
    define('HELLO_ADDONS_TABLE_NAME', $wpdb->prefix . 'hello_theme_ypf_addons_fee');
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE " . HELLO_ADDONS_TABLE_NAME . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        addon_name varchar(255) NOT NULL,
        value_percentage decimal(5,2) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option('hello_theme_addons_table_created', '1');

    // Set flag to show admin notice
    update_option('hello_theme_show_addons_table_notice', '1');
}

function hello_theme_activate() {
    if (!get_option('hello_theme_addons_table_created')) {
        hello_theme_ypf_addons_create_table();
    }
}
add_action('after_switch_theme', 'hello_theme_activate');

function hello_theme_deactivate() {
    //do some function if deactive theme
}
add_action('switch_theme', 'hello_theme_deactivate');

function hello_theme_addons_table_notice() {
    if (get_option('hello_theme_show_addons_table_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Hello Theme Add-ons Fee table has been created successfully.', 'hello-theme'); ?></p>
        </div>
        <?php
        delete_option('hello_theme_show_addons_table_notice');
    }
}
add_action('admin_notices', 'hello_theme_addons_table_notice');

function hello_theme_scripts_styles() {
    wp_enqueue_style('hello-theme-style', get_stylesheet_directory_uri() . '/style.css', [], HELLO_THEME_VERSION);
    wp_enqueue_style('hello-theme-custom-style', get_stylesheet_directory_uri() . '/assets/css/hello-theme.css', [],      HELLO_THEME_VERSION);
    wp_enqueue_script('hello-theme-custom-script', get_stylesheet_directory_uri() . '/assets/js/hello-theme.js', [],HELLO_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'hello_theme_scripts_styles', 20);


/**
 * Enqueue scripts and styles for Table Pricing Live Version.
 */
function hello_theme_pricing_table_live() {
    // Check if the pricing table is enabled
    if ( get_option( 'hello_theme_enable_table_pricing' ) === '1' ) {
        // Enqueue styles        
        wp_enqueue_style( 'hello-theme-font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
        wp_enqueue_style( 'hello-theme-swiper-bundle-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css');
        wp_enqueue_style( 'hello-theme-plugins-css', get_stylesheet_directory_uri() . '/assets/css/hello-theme-pricing-table.css', array('hello-theme-font-awesome-css', 'hello-theme-swiper-bundle-css'), HELLO_THEME_VERSION, 'all' );

        // Enqueue scripts        
        wp_enqueue_script( 'hello-theme-swiper-bundle-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js', array('jquery'), null, true );
        wp_enqueue_script( 'hello-theme-popper-js', 'https://unpkg.com/@popperjs/core@2.11.8/dist/umd/popper.min.js', array(), null, true );
        wp_enqueue_script( 'hello-theme-tippy-js', 'https://unpkg.com/tippy.js@6.3.7/dist/tippy-bundle.umd.min.js', array(), null, true );

        wp_enqueue_script( 'hello-theme-plugins-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );
    }
}
add_action( 'wp_enqueue_scripts', 'hello_theme_pricing_table_live', 20);