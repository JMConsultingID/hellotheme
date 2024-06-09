<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
//Theme Activation
function hello_theme_ypf_addons_create_table() {
    global $wpdb;
    define('HELLO_ADDONS_TABLE_NAME', $wpdb->prefix . 'hello_theme_ypf_addons_fee');
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE " . HELLO_ADDONS_TABLE_NAME . " (
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
            <p><?php _e('Hello Theme Add-ons Fee table has been created successfully.', 'hello-theme'); ?></p>
        </div>
        <?php
        delete_option('hello_theme_show_addons_table_notice');
    }
}
add_action('admin_notices', 'hello_theme_addons_table_notice');

function hello_theme_display_swiper_navigation_buttons($left_button_id, $right_button_id) {
    ?>
    <div class="pt__option__mobile__nav">
        <a id="<?php echo esc_attr($left_button_id); ?>" href="#" class="mobile__nav__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <a id="<?php echo esc_attr($right_button_id); ?>" href="#" class="mobile__nav__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <?php
}