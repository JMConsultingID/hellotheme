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
$enabled_pricing_table = get_option('hello_theme_enable_table_pricing');
$enabled_yrt_functions = get_option('enable_yrt_functions');
require_once get_stylesheet_directory() . '/inc/functions/helper/hello-theme-helper.php';

// Admin Settings
require_once get_stylesheet_directory() . '/inc/functions/admin/hello-admin-function-settings-menu.php';

// Public Settings
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-affiliate-wp.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-redirect-page.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-woocommerce.php';

// if ($enabled_yrt_functions === '1') {
//     require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-woocommerce-yrt.php';
// }

if ($enabled_pricing_table === '1') {
    require_once get_stylesheet_directory() . '/inc/functions/helper/hello-theme-helper.php';
}


add_filter('wf_pklist_toggle_received_seal', 'wt_pklist_toggle_received_seal', 10, 3);
function wt_pklist_toggle_received_seal($is_enable_received_seal, $template_type, $order)
{
    if($order->get_status()=='completed')
    {
         return true;
    }
    return false;
}