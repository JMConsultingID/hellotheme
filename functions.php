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
    wp_enqueue_style('hello-theme-custom-style', get_stylesheet_directory_uri() . '/assets/css/hello-theme.css', [],      HELLO_THEME_VERSION);
    wp_enqueue_script('hello-theme-custom-script', get_stylesheet_directory_uri() . '/assets/js/hello-theme.js', [],HELLO_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'hello_theme_scripts_styles', 20);


/**
 * Register scripts and styles for Table Pricing Live Version.
 */
function hello_theme_pricing_table_live() {
    // Check if the pricing table is enabled
    if ( get_option( 'hello_theme_enable_table_pricing' ) === '1' ) {
        // Register styles        
        wp_register_style( 'hello-theme-font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
        wp_register_style( 'hello-theme-swiper-bundle-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css');
        wp_register_style( 'hello-theme-plugins-css', get_stylesheet_directory_uri() . 'assets/css/hello-theme-pricing-table.css', array('hello-theme-font-awesome-css', 'hello-theme-swiper-bundle-css'), '1.0.1', 'all' );


        // Register scripts        
        wp_register_script( 'hello-theme-swiper-bundle-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js', array('jquery'), null, true );
        wp_register_script( 'hello-theme-popper-js', 'https://unpkg.com/@popperjs/core@2.11.8/dist/umd/popper.min.js', null, array(), null, true );
        wp_register_script( 'hello-theme-tippy-js', 'https://unpkg.com/tippy.js@6.3.7/dist/tippy-bundle.umd.min.js', null, array(), null, true );

        wp_register_script( 'hello-theme-plugins-js', get_stylesheet_directory_uri() . 'assets/js/hello-theme-pricing-table.js', array('jquery', 'hello-theme-swiper-bundle-js','hello-theme-popper-js', 'hello-theme-tippy-js'), '1.0.1', true );

    }
}
add_action( 'wp_enqueue_scripts', 'hello_theme_pricing_table_live', 100);