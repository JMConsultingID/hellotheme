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
    $redirect_method = get_option( 'hello_theme_affiliatewp_enable_redirect_method' );
    $redirect_referral_url = get_option( 'hello_theme_affiliatewp_redirect_referral_url' );

    // If the option is not '1', return early
    if ($is_enabled_referral_url !== '1') {
        return;
    }

    if ($redirect_method === 'php') {

        // Get the current request URI.
        $request_uri = $_SERVER['REQUEST_URI'];
        // Get the full URL including query string.
        $full_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


        // Check for the presence of 'ref' as a query parameter.
        if (strpos($full_url, '?ref=') !== false || preg_match('|^/ref/[\w-]+/?|', $_SERVER['REQUEST_URI'])) {
            // Construct the new URL to redirect to the homepage of the main site.
            $new_url = $redirect_referral_url;
            // Perform the redirection to the main site.
            wp_redirect($new_url, 301);
            exit;
        }

        // Match the /ref/{string}/ structure (with or without query parameters).
        if (preg_match('|^/ref/([\w-]+)/?(\?.*)?$|', $request_uri, $matches)) {
            // Extract the string from the matches.
            $dynamic_string = $matches[1];        
            // Check for query string and extract if it exists.
            $query_string = isset($matches[2]) ? $matches[2] : '';
            // Perform the redirection.
            wp_redirect($redirect_referral_url, 301);
            exit;
        }
        
        // Use a regex pattern to match the /ref/{dynamic_number}/ structure.
        if ( preg_match('|^/ref/([\d\w]+)/?$|', $request_uri, $matches)) {
            // Extract the dynamic number from the matches.
            $dynamic_value = $matches[1];            
            // Perform the redirection.
            wp_redirect($redirect_referral_url, 301);
            exit;
        }

        // Check if the URL path is just a query string starting with ref.
        if (preg_match('/^\?ref=\d+/', $request_uri)) {
            // Perform the redirection to the main site.
            wp_redirect($redirect_referral_url, 301);
            exit;
        }
    }
}
add_action( 'template_redirect', 'hello_theme_affiliate_redirect',999 );

function hello_theme_affiliate_redirect_by_page_id() {
    $is_enabled_referral_url = get_option('hello_theme_affiliatewp_enable_redirect_referral');
    $redirect_method = get_option( 'hello_theme_affiliatewp_enable_redirect_method' );
    $redirect_referral_url = get_option('hello_theme_affiliatewp_redirect_referral_url');

    // If the option is not '1', return early
    if ($is_enabled_referral_url !== '1' || $redirect_method !== 'js') {
        return;
    }

    if (is_front_page() || is_home()) {
        ?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    var urlParams = new URLSearchParams(window.location.search);
                    var refParam = urlParams.get('ref');
                    var redirectUrl = "<?php echo esc_js($redirect_referral_url); ?>";
                    if (refParam) {
                        window.location.href = redirectUrl + "?ref=" + refParam;
                    } else {
                        window.location.href = redirectUrl;
                    }
                }, 1000); // 5000 milliseconds = 5 seconds
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'hello_theme_affiliate_redirect_by_page_id', 999);

?>