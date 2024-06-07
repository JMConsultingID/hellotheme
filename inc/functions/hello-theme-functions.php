<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
// Admin Settings
require_once get_stylesheet_directory() . '/inc/functions/admin/hello-admin-function-settings-menu.php';
//require_once get_stylesheet_directory() . '/inc/functions/admin/hello-admin-function-settings-tab.php';

// Public Settings
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-affiliate-wp.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-redirect-page.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-pricing-table-dev.php';
require_once get_stylesheet_directory() . '/inc/functions/public/hello-public-function-woocommerce.php';


//Theme Activation
function hello_theme_ypf_addons_create_table() {
    global $wpdb;
    define('YPF_ADDONS_TABLE_NAME', $wpdb->prefix . 'hello_theme_ypf_addons_fee');
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE " . YPF_ADDONS_TABLE_NAME . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        addon_name varchar(255) NOT NULL,
        value_percentage decimal(5,2) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option('hello_theme_addons_table_created', '1');

    // Set flag to show admin notice
    update_option('hello_theme_show_addons_table_notice', '1');
}

function hello_theme_activate() {
    if (!get_option('hello_theme_addons_table_created')) {
        hello_theme_ypf_addons_create_table();
    }
}
add_action('after_switch_theme', 'hello_theme_activate');

function hello_theme_deactivate() {
    //do some function if deactive theme
}
add_action('switch_theme', 'hello_theme_deactivate');

function hello_theme_addons_table_notice() {
    if (get_option('hello_theme_show_addons_table_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Add-ons table has been created successfully.', 'hello-theme'); ?></p>
        </div>
        <?php
        // Hapus opsi setelah menampilkan notifikasi
        delete_option('hello_theme_show_addons_table_notice');
    }
}
add_action('admin_notices', 'hello_theme_addons_table_notice');