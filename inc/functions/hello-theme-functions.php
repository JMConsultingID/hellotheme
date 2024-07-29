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
    if ( get_option( 'hello_theme_enable_table_pricing' ) !== '1' ) {
        wp_add_inline_script( 'jquery', 'console.log("Pricing table is not enabled");' );
        return;
    }

    $shortcode_found = false;

    if ( is_singular() ) {
        global $post;

        if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor( $post->ID ) ) {
            wp_add_inline_script( 'jquery', 'console.log("Page is built with Elementor");' );
            
            $elementor_data = get_post_meta( $post->ID, '_elementor_data', true );
            if ( $elementor_data ) {
                wp_add_inline_script( 'jquery', 'console.log("Elementor data:", ' . json_encode($elementor_data) . ');' );
                
                // Check for shortcode in Elementor data
                if ( strpos( $elementor_data, 'ypf_pricing_table' ) !== false || 
                     strpos( $elementor_data, 'ypf_scalling_table' ) !== false ) {
                    $shortcode_found = true;
                    wp_add_inline_script( 'jquery', 'console.log("Pricing table shortcode found in Elementor data");' );
                } else {
                    wp_add_inline_script( 'jquery', 'console.log("Shortcode not found in Elementor data");' );
                }
            } else {
                wp_add_inline_script( 'jquery', 'console.log("No Elementor data found");' );
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
        // Enqueue your styles and scripts here
        wp_add_inline_script( 'jquery', 'console.log("Scripts and styles enqueued for pricing table");' );
    } else {
        wp_add_inline_script( 'jquery', 'console.log("No pricing table shortcode found");' );
    }
}
add_action( 'wp_enqueue_scripts', 'hello_theme_pricing_table_live', 20);

