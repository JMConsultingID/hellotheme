<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
// 1. Create the "Hello Theme" Menu
function hello_theme_create_menu() {
    add_menu_page(
        'Hello Theme Settings',          // Page title
        'Hello Theme',                   // Menu title
        'manage_options',                // Capability (admin level)
        'hello_theme_settings',          // Menu slug (unique identifier)
        'hello_theme_settings_page',     // Function to display the page
        'dashicons-admin-settings',      // Menu icon (optional)
        null                             // Position (optional)
    );
}
add_action('admin_menu', 'hello_theme_create_menu');

// 2. Function to Render the Settings Page
function hello_theme_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hello Theme Settings</h1>
        <form method="post" action="options.php"> 
            <?php
                settings_fields('hello_theme_settings_group'); // Settings group
                do_settings_sections('hello_theme_settings');  // Settings sections
                submit_button(); 
            ?>
        </form>
    </div>
    <?php
}

// 3. Register the Settings (and Sections)
function hello_theme_register_settings() {
    register_setting(
        'hello_theme_settings_group',       // Settings group
        'hello_theme_settings_options'     // Option name
    );
    
    add_settings_section(
        'hello_theme_redirects_section',  // Section ID
        'Hello Theme Redirects Settings', // Section title
        '',                              // Empty callback function for now
        'hello_theme_settings'            // Page to display on
    );

    // Add your existing settings fields here (from get_hello_theme_woo_settings)
    // Make sure to change the section ID in each field to 'hello_theme_redirects_section'

    // ... your existing settings fields ...

    add_settings_section(
        'hello_theme_affiliatewp_section',  // Section ID
        'Hello Theme AffiliateWP Settings', // Section title
        '',                              // Empty callback function for now
        'hello_theme_settings'            // Page to display on
    );
}
add_action('admin_init', 'hello_theme_register_settings');

function hello_theme_get_pages_array() {
    $pages = get_pages();
    $pages_array = array();
    foreach ( $pages as $page ) {
        $pages_array[ $page->ID ] = $page->post_title;
    }
    return $pages_array;
}

function get_hello_theme_woo_settings() {
    $pages = hello_theme_get_pages_array();
    $settings = array(
        'section_title' => array(
            'name'     => 'Hello Theme Redirects Settings',
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'hello_theme_redirects_section_title'
        ),
        'enable_thank_you_redirect' => array(
            'name' => 'Enable Thank You Page Redirect',
            'type' => 'checkbox',
            'desc' => 'Enable redirect to specific pages based on order status.',
            'id'   => 'enable_thank_you_redirect'
        ),
        'skip_cart' => array(
            'name' => 'Skip Cart Page',
            'type' => 'checkbox',
            'desc' => 'Skip the cart page and redirect to home page.',
            'id'   => 'skip_cart_page'
        ),
        'thank_you_page' => array(
            'name' => 'Thank You Page URL',
            'type' => 'select',
            'desc' => 'URL to redirect to after a successful order.',
            'id'   => 'hello_theme_thank_you_page_url',
            'options' => $pages
        ),
        'failed_page' => array(
            'name' => 'Failed Order Page URL',
            'type' => 'select',
            'desc' => 'URL to redirect to after a failed order.',
            'id'   => 'hello_theme_failed_page_url',
            'options' => $pages
        ),
        'on_hold_page' => array(
            'name' => 'On Hold Order Page URL',
            'type' => 'select',
            'desc' => 'URL to redirect to for on-hold orders.',
            'id'   => 'hello_theme_on_hold_page_url',
            'options' => $pages
        ),
        'section_end' => array(
            'type' => 'sectionend',
            'id'   => 'hello_theme_redirects_section_end'
        ),
        'section_title_second' => array(
            'name'     => 'Hello Theme AffiliateWP Settings',
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'hello_theme_redirects_section_second_title'
        ),
        'affiliatewp_register' => array(
            'name' => 'AffiliateWP Register Page ID',
            'type' => 'select',
            'desc' => 'AffiliateWP Register Page.',
            'id'   => 'hello_theme_affiliatewp_register_id',
            'options' => $pages
        ),
        'affiliatewp_area_login' => array(
            'name' => 'AffiliateWP Area Login Page ID',
            'type' => 'select',
            'desc' => 'AffiliateWP Area Login Page, Please Set the Affiliate Area Slug : <code>/affiliate-area/</code>.',
            'id'   => 'hello_theme_affiliatewp_area_id',
            'options' => $pages
        ),
        'section_end_second' => array(
            'type' => 'sectionend',
            'id'   => 'hello_theme_redirects_section_second_end'
        ),
    );

    return $settings;
}

function hello_theme_redirect_after_purchase( $order_id ) {
    if ( get_option( 'enable_thank_you_redirect' ) == 'yes' ) {
        $order = wc_get_order( $order_id );
        $status = $order->get_status();

        $thank_you_page_id = get_option( 'hello_theme_thank_you_page_url' );
        $failed_page_id = get_option( 'hello_theme_failed_page_url' );
        $on_hold_page_id = get_option( 'hello_theme_on_hold_page_url' );

        $thank_you_page_url = $thank_you_page_id ? get_permalink( $thank_you_page_id ) : home_url();
        $failed_page_url = $failed_page_id ? get_permalink( $failed_page_id ) : home_url();
        $on_hold_page_url = $on_hold_page_id ? get_permalink( $on_hold_page_id ) : home_url();

        switch ( $status ) {
            case 'completed':
                wp_safe_redirect( $thank_you_page_url );
                exit;
            case 'failed':
                wp_safe_redirect( $failed_page_url );
                exit;
            case 'on-hold':
                wp_safe_redirect( $on_hold_page_url );
                exit;
            default:
                wp_safe_redirect( home_url() );
                exit;
        }
    }
}
add_action( 'woocommerce_thankyou', 'hello_theme_redirect_after_purchase' );

function hello_theme_redirect_cart_to_home() {
    if ( get_option( 'enable_thank_you_redirect' ) == 'yes' ) {
        if ( get_option( 'skip_cart_page' ) == 'yes' && ( is_page( 'cart' ) || ( isset( $_GET['cancel_order'] ) && $_GET['cancel_order'] === 'true' ) ) ) {
            $home_page_url = home_url();
            wp_safe_redirect( $home_page_url );
            exit;
        }
    }
}
add_action( 'template_redirect', 'hello_theme_redirect_cart_to_home' );

function hello_theme_affwp_register_form_script() {
    // Get the current post ID
    $post_id = get_the_ID();
    $affiliatewp_register_id = get_option( 'hello_theme_affiliatewp_register_id' );
    $affiliatewp_login_id = get_option( 'hello_theme_affiliatewp_area_id' );

    // Check if the current post ID is 639 and not in the Elementor editor
    if ( $post_id === $affiliatewp_register_id && strpos($_SERVER['REQUEST_URI'], 'elementor') === false ) {
    ?>
    <script>
    jQuery(document).ready(function($) {
        if ($('#affwp-register-form').length === 0) {
            window.location.href = '/affiliate-area';
        }
    });
    </script>
    <?php
    }

    // Check if the current post ID is 631 and not in the Elementor editor
    if ( $post_id === $affiliatewp_login_id && strpos($_SERVER['REQUEST_URI'], 'elementor') === false ) {
        // Check if user is logged in and not an affiliate
        if ( is_user_logged_in() && !affwp_is_affiliate() ) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                if ($('#affwp-register-form').length > 0) {
                    $('#affwp-login-form').hide();
                }
            });
            </script>
            <?php
        } else {
            ?>
            <script>
            jQuery(document).ready(function($) {
                $('#affwp-register-form').hide();
            });
            </script>
            <?php
        }
    }
}
add_action('wp_footer', 'hello_theme_affwp_register_form_script');

?>