<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
function hello_theme_affwp_register_form_script() {
    if ( get_option( 'hello_theme_affiliatewp_enable' ) === '1'  ) {
        // Get the current post ID
        $post_id = get_the_ID();
        $affiliatewp_register_id = intval(get_option( 'hello_theme_affiliatewp_register_id' ));
        $affiliatewp_login_id = intval(get_option( 'hello_theme_affiliatewp_area_id' ));
        $affiliatewp_area_url = $affiliatewp_login_id  ? get_permalink( $affiliatewp_login_id  ) : home_url();

        // Check if the current post ID is 639 and not in the Elementor editor
        if ( $post_id === $affiliatewp_register_id && strpos($_SERVER['REQUEST_URI'], 'elementor') === false ) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            if ($('#affwp-register-form').length === 0) {
                window.location.href = '<?php echo esc_js($affiliatewp_area_url); ?>';
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

function hello_theme_affiliate_redirect() {
    $is_enabled_referral_url = get_option( 'hello_theme_affiliatewp_enable_redirect_referral' );
    $redirect_referral_url = get_option( 'hello_theme_affiliatewp_redirect_referral_url' );

    // If the option is not '1', return early
    if ($is_enabled_referral_url !== '1') {
        echo '<script>console.log("Referral redirect is disabled.");</script>';
        return;
    }

    // Get the current request URI.
    $request_uri = $_SERVER['REQUEST_URI'];
    echo '<script>console.log("Current request URI: ' . $request_uri . '");</script>';

    // Match any URL that starts with /ref/ followed by any characters.
    if (preg_match('|^/ref/.*|', $request_uri)) {
        echo '<script>console.log("Matched /ref/ pattern, redirecting to: ' . $redirect_referral_url . '");</script>';
        // Perform the redirection to the main site without any additional path.
        wp_redirect($redirect_referral_url, 301);
        exit;
    }

    // Check for the presence of 'ref' as a query parameter.
    if (strpos($request_uri, '?ref=') !== false) {
        echo '<script>console.log("Matched ?ref= pattern, redirecting to: ' . $redirect_referral_url . '");</script>';
        // Perform the redirection to the main site without any additional path.
        wp_redirect($redirect_referral_url, 301);
        exit;
    }
}
add_action( 'template_redirect', 'hello_theme_affiliate_redirect', 20 );

function hello_theme_enqueue_scripts() {
    $is_enabled_referral_url = get_option( 'hello_theme_affiliatewp_enable_redirect_referral' );
    // If the option is not '1', return early
    if ($is_enabled_referral_url !== '1') {
        return;
    }
    wp_enqueue_script( 'affiliatewp-redirect', get_stylesheet_directory_uri() . 'assets/js/affiliate-redirect.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'hello_theme_enqueue_scripts' );



?>