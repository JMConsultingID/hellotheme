<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
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
    if ( get_option( 'hello_theme_affiliatewp_enable' ) === 'yes'  ) {
        // Get the current post ID
        $post_id = get_the_ID();
        $affiliatewp_register_id = intval(get_option( 'hello_theme_affiliatewp_register_id' ));
        $affiliatewp_login_id = intval(get_option( 'hello_theme_affiliatewp_area_id' ));

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
}

add_action('wp_footer', 'hello_theme_affwp_register_form_script');

?>