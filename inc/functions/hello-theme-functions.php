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
require_once get_stylesheet_directory() . '/inc/functions/helper/hello-theme-helper.php';

// Admin Settings
require_once get_stylesheet_directory() . '/inc/functions/admin/hello-admin-function-settings-menu.php';
//require_once get_stylesheet_directory() . '/inc/functions/admin/hello-admin-function-settings-tab.php';

// Public Settings
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-affiliate-wp.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-redirect-page.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-scaling-table.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-woocommerce.php';
//require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table.php';
// require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-level-1.php';
// require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-level-2.php';

function hello_theme_pricing_table_live() {
    // Check if the pricing table is enabled
    if ( get_option( 'hello_theme_enable_table_pricing' ) !== '1' ) {
        wp_add_inline_script( 'jquery', 'console.log("Pricing table is not enabled");' );
        return;
    }

    // Array of page IDs where we want to load the scripts and styles
    $target_page_ids = array(20602, 15544);

    // Check if we're on one of the target pages
    if ( is_page($target_page_ids) ) {
        // Enqueue styles
        wp_enqueue_style( 'hello-theme-swiper-bundle-css', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css');
        wp_enqueue_style( 'hello-theme-tippy-css', get_stylesheet_directory_uri() . '/assets/css/tippy.css');
        wp_enqueue_style( 'hello-theme-tippy-light-css', get_stylesheet_directory_uri() . '/assets/css/tippy-light.css');
        wp_enqueue_style( 'hello-theme-pricing-scaling-table-css', get_stylesheet_directory_uri() . '/assets/css/hello-theme-pricing-table.css', array('hello-theme-swiper-bundle-css'), HELLO_THEME_VERSION, 'all' );

        // Enqueue scripts        
        wp_enqueue_script( 'hello-theme-swiper-bundle-js', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), null, true );
        wp_enqueue_script( 'hello-theme-popper-js', get_stylesheet_directory_uri() . '/assets/js/popper.min.js', array(), null, true );
        wp_enqueue_script( 'hello-theme-tippy-js', get_stylesheet_directory_uri() . '/assets/js/tippy-bundle.umd.min.js', array(), null, true );
        wp_enqueue_script( 'hello-theme-pricing-scaling-table-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );
    }
}
add_action( 'wp_enqueue_scripts', 'hello_theme_pricing_table_live', 20);

