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
    if ( get_option( 'hello_theme_affiliatewp_enable' ) === 'yes'  ) {
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

add_action('wp_footer', 'hello_theme_affwp_register_form_script');

?>