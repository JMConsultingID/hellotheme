<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
// Helper
$enabled_pricing_table = get_option('hello_theme_enable_table_pricing');
$enabled_product_selection = get_option('enable_product_selection_pages');
require_once get_stylesheet_directory() . '/inc/functions/helper/hello-theme-helper.php';

// Admin Settings
require_once get_stylesheet_directory() . '/inc/functions/admin/hello-admin-function-settings-menu.php';
//require_once get_stylesheet_directory() . '/inc/functions/admin/hello-admin-function-settings-tab.php';

// Public Settings
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-affiliate-wp.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-redirect-page.php';
//require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-level-1.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-level-2.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-dev.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-woocommerce.php';

if ($enabled_product_selection === '1') {
    require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-product-selection.php';
}

// if ($enabled_pricing_table === '1') {
//     require_once get_stylesheet_directory() . '/inc/functions/helper/hello-theme-acf-import-field.php';
// }


/**
 * Enqueue scripts and styles for Table Pricing Live Version.
 */
function hello_theme_pricing_table_live() {
    $enabled_pricing_table = get_option('hello_theme_enable_table_pricing');
    // Check if the pricing table is enabled
    if ($enabled_pricing_table === '1') {
        // Enqueue styles        
        wp_enqueue_style( 'hello-theme-font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
        wp_enqueue_style( 'hello-theme-swiper-bundle-css', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css');
        wp_enqueue_style( 'hello-theme-tippy-css', get_stylesheet_directory_uri() . '/assets/css/tippy.css');
        wp_enqueue_style( 'hello-theme-tippy-light-css', get_stylesheet_directory_uri() . '/assets/css/tippy-light.css');
        wp_enqueue_style( 'hello-theme-plugins-css', get_stylesheet_directory_uri() . '/assets/css/hello-theme-pricing-table.css', array('hello-theme-font-awesome-css', 'hello-theme-swiper-bundle-css', 'hello-theme-tippy-css', 'hello-theme-tippy-light-css'), HELLO_THEME_VERSION, 'all' );

        // Enqueue scripts        
        wp_enqueue_script( 'hello-theme-swiper-bundle-js', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), null, true );
        wp_enqueue_script( 'hello-theme-popper-js', get_stylesheet_directory_uri() . '/assets/js/popper.min.js', array(), null, true );
        wp_enqueue_script( 'hello-theme-tippy-js', get_stylesheet_directory_uri() . '/assets/js/tippy-bundle.umd.min.js', array(), null, true );

        wp_enqueue_script( 'hello-theme-pricing-table-level-all-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table-level-all.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );
        // wp_enqueue_script( 'hello-theme-pricing-table-level-1-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table-level-1.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );
        // wp_enqueue_script( 'hello-theme-pricing-table-level-2-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table-level-2.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );
        // wp_enqueue_script( 'hello-theme-pricing-table-group-level-1-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );

    }
}
add_action( 'wp_enqueue_scripts', 'hello_theme_pricing_table_live', 20);

function hello_theme_enqueue_product_selection() {
    $enabled_product_selection = get_option('enable_product_selection_pages');
    if ($enabled_product_selection === '1') {
        wp_enqueue_style( 'hello-theme-products-selection-challenge-css', get_stylesheet_directory_uri() . '/assets/css/hello-theme-product-selection.css', array(), HELLO_THEME_VERSION, 'all' );
        wp_enqueue_script('hello-theme-products-selection-challenge-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-product-selection.js', array('jquery'), null, true);
        wp_localize_script('hello-theme-products-selection-challenge-js', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'hello_theme_enqueue_product_selection', 21);
