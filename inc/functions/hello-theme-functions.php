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

/**
 * Enqueue scripts and styles for Table Pricing Live Version.
 */
function hello_theme_pricing_table_live() {
    // Check if the pricing table is enabled
    if ( get_option( 'hello_theme_enable_table_pricing' ) !== '1' ) {
        wp_add_inline_script( 'jquery', 'console.log("Pricing table is not enabled");' );
        return;
    }

    $shortcode_found = false;

    // Check if we're on a singular page
    if ( is_singular() ) {
        global $post;

        // Check if Elementor is active on this page
        if ( \Elementor\Plugin::$instance->db->is_built_with_elementor( $post->ID ) ) {
            wp_add_inline_script( 'jquery', 'console.log("Page is built with Elementor");' );
            
            // Get Elementor data
            $elementor_data = get_post_meta( $post->ID, '_elementor_data', true );
            if ( $elementor_data ) {
                // Check for shortcode in Elementor data
                if ( strpos( $elementor_data, 'ypf_pricing_table' ) !== false || strpos( $elementor_data, 'ypf_scalling_table' ) !== false ) {
                    $shortcode_found = true;
                    wp_add_inline_script( 'jquery', 'console.log("Pricing table shortcode found in Elementor data");' );
                }
            }
        } else {
            wp_add_inline_script( 'jquery', 'console.log("Page is not built with Elementor");' );
            // Check for shortcode in regular post content
            if ( preg_match( '/\[(ypf_pricing_table|ypf_scalling_table)(?:\s|])/i', $post->post_content ) ) {
                $shortcode_found = true;
                wp_add_inline_script( 'jquery', 'console.log("Pricing table shortcode found in post content");' );
            }
        }
    } else {
        wp_add_inline_script( 'jquery', 'console.log("Not a singular page");' );
    }

    if ( $shortcode_found ) {
        // Enqueue styles
        wp_enqueue_style( 'hello-theme-swiper-bundle-css', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css');
        wp_enqueue_style( 'hello-theme-tippy-css', get_stylesheet_directory_uri() . '/assets/css/tippy.css');
        wp_enqueue_style( 'hello-theme-tippy-light-css', get_stylesheet_directory_uri() . '/assets/css/tippy-light.css');
        wp_enqueue_style( 'hello-theme-pricing-scaling-table-css', get_stylesheet_directory_uri() . '/assets/css/hello-theme-pricing-table.css', array('hello-theme-swiper-bundle-css'), HELLO_THEME_VERSION, 'all' );

        // Enqueue scripts        
        wp_enqueue_script( 'hello-theme-swiper-bundle-js', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), null, true );
        wp_enqueue_script( 'hello-theme-popper-js', get_stylesheet_directory_uri() . '/assets/js/popper.min.js', array(), null, true );
        wp_enqueue_script( 'hello-theme-tippy-js', get_stylesheet_directory_uri() . '/assets/js/tippy-bundle.umd.min.js', array(), null, true );
        wp_enqueue_script( 'hello-theme-pricing-scaling-table-js', get_stylesheet_directory_uri() . '/assets/css/hello-theme-pricing-table.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), HELLO_THEME_VERSION, true );

        wp_add_inline_script( 'jquery', 'console.log("Scripts and styles enqueued for pricing table");' );
    } else {
        wp_add_inline_script( 'jquery', 'console.log("No pricing table shortcode found");' );
    }
}
add_action( 'wp_enqueue_scripts', 'hello_theme_pricing_table_live', 20);
