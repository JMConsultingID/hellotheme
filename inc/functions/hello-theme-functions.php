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
//require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-level-1.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-level-2.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-dev.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-woocommerce.php';

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

        wp_enqueue_script( 'hello-theme-pricing-table-level-all-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table-level-all.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );

        // wp_enqueue_script( 'hello-theme-pricing-table-level-1-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table-level-1.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );
        // wp_enqueue_script( 'hello-theme-pricing-table-level-2-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table-level-2.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );
        // wp_enqueue_script( 'hello-theme-pricing-table-group-level-1-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-pricing-table.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );

    }
}
add_action( 'wp_enqueue_scripts', 'hello_theme_pricing_table_live', 20);