<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

// Menambahkan menu utama dan sub-menu ke dalam Dashboard WordPress
function hello_theme_add_admin_menu() {
    // Menu utama
    add_menu_page(
        'Hello Panel', // Page title
        'Hello Panel', // Menu title
        'manage_options', // Capability
        'hello-panel', // Menu slug
        'hello_panel_page', // Function to display page content
        'dashicons-admin-generic', // Icon URL
        3 // Position
    );

    // Sub-menu Hello AffiliateWP
    add_submenu_page(
        'hello-panel', // Parent slug
        'Hello AffiliateWP', // Page title
        'Hello AffiliateWP', // Menu title
        'manage_options', // Capability
        'hello-affiliatewp', // Menu slug
        'hello_affiliatewp_settings_page' // Function to display page content
    );

    // Sub-menu Hello WooCommerce
    add_submenu_page(
        'hello-panel', // Parent slug
        'Hello WooCommerce', // Page title
        'Hello WooCommerce', // Menu title
        'manage_options', // Capability
        'hello-woocommerce', // Menu slug
        'hello_woocommerce_settings_page' // Function to display page content
    );

    // Sub-menu General Settings
    add_submenu_page(
        'hello-panel', // Parent slug
        'General Settings', // Page title
        'General Settings', // Menu title
        'manage_options', // Capability
        'hello-general-settings', // Menu slug
        'hello_general_settings_page' // Function to display page content
    );
}

add_action( 'admin_menu', 'hello_theme_add_admin_menu' );

// Fungsi untuk menampilkan konten halaman Hello Panel
function hello_panel_page() {
    echo '<h1>Hello Panel</h1>';
    echo '<p>Welcome to the Hello Panel settings page.</p>';
}

// Fungsi untuk menampilkan konten halaman pengaturan AffiliateWP
function hello_affiliatewp_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Hello AffiliateWP Settings', 'hello-theme' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'hello_affiliatewp_settings_group' );
            do_settings_sections( 'hello-affiliatewp' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Fungsi untuk menampilkan konten halaman pengaturan WooCommerce
function hello_woocommerce_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Hello WooCommerce Settings', 'hello-theme' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'hello_woocommerce_settings_group' );
            do_settings_sections( 'hello-woocommerce' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Fungsi untuk menampilkan konten halaman pengaturan umum
function hello_general_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'General Settings', 'hello-theme' ); ?></h1>
        <p>Under development.</p>
    </div>
    <?php
}

// Mendaftarkan pengaturan dan menambahkan pengaturan ke halaman AffiliateWP
function hello_theme_affiliatewp_settings_init() {
    register_setting( 'hello_affiliatewp_settings_group', 'hello_affiliatewp_settings' );

    add_settings_section(
        'hello_affiliatewp_section',
        __( 'Hello Theme AffiliateWP Settings', 'hello-theme' ),
        'hello_theme_affiliatewp_section_callback',
        'hello-affiliatewp'
    );

    add_settings_field(
        'enable_affiliatewp_config',
        __( 'Enable AffiliateWP Configuration', 'hello-theme' ),
        'enable_affiliatewp_config_render',
        'hello-affiliatewp',
        'hello_affiliatewp_section'
    );

    add_settings_field(
        'affiliatewp_register',
        __( 'AffiliateWP Register Page ID', 'hello-theme' ),
        'affiliatewp_register_render',
        'hello-affiliatewp',
        'hello_affiliatewp_section'
    );

    add_settings_field(
        'affiliatewp_area_login',
        __( 'AffiliateWP Area Login Page ID', 'hello-theme' ),
        'affiliatewp_area_login_render',
        'hello-affiliatewp',
        'hello_affiliatewp_section'
    );
}

add_action( 'admin_init', 'hello_theme_affiliatewp_settings_init' );

// Mendaftarkan pengaturan dan menambahkan pengaturan ke halaman WooCommerce
function hello_theme_woocommerce_settings_init() {
    register_setting( 'hello_woocommerce_settings_group', 'hello_woocommerce_settings' );

    add_settings_section(
        'hello_woocommerce_section',
        __( 'Hello Theme WooCommerce Settings', 'hello-theme' ),
        'hello_theme_woocommerce_section_callback',
        'hello-woocommerce'
    );

    add_settings_field(
        'hello_theme_checkout_mode',
        __( 'Select Checkout Mode', 'hello-theme' ),
        'hello_theme_checkout_mode_render',
        'hello-woocommerce',
        'hello_woocommerce_section'
    );

    add_settings_field(
        'enable_thank_you_redirect',
        __( 'Enable Thank You Page Redirect', 'hello-theme' ),
        'enable_thank_you_redirect_render',
        'hello-woocommerce',
        'hello_woocommerce_section'
    );

    add_settings_field(
        'skip_cart',
        __( 'Skip Cart Page', 'hello-theme' ),
        'skip_cart_render',
        'hello-woocommerce',
        'hello_woocommerce_section'
    );

    add_settings_field(
        'thank_you_page',
        __( 'Thank You Page URL', 'hello-theme' ),
        'thank_you_page_render',
        'hello-woocommerce',
        'hello_woocommerce_section'
    );

    add_settings_field(
        'failed_page',
        __( 'Failed Order Page URL', 'hello-theme' ),
        'failed_page_render',
        'hello-woocommerce',
        'hello_woocommerce_section'
    );

    add_settings_field(
        'on_hold_page',
        __( 'On Hold Order Page URL', 'hello-theme' ),
        'on_hold_page_render',
        'hello-woocommerce',
        'hello_woocommerce_section'
    );
}

add_action( 'admin_init', 'hello_theme_woocommerce_settings_init' );

function hello_theme_affiliatewp_section_callback() {
    echo __( 'Configure your Hello Theme AffiliateWP settings below:', 'hello-theme' );
}

function hello_theme_woocommerce_section_callback() {
    echo __( 'Configure your Hello Theme WooCommerce settings below:', 'hello-theme' );
}

function hello_theme_checkout_mode_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $checkout_mode = isset( $options['hello_theme_checkout_mode'] ) ? $options['hello_theme_checkout_mode'] : '';
    ?>
    <select name='hello_woocommerce_settings[hello_theme_checkout_mode]'>
        <option value='single' <?php selected( $checkout_mode, 'single' ); ?>>Single Product</option>
        <option value='multiple' <?php selected( $checkout_mode, 'multiple' ); ?>>Multiple Products</option>
    </select>
    <?php
}

function enable_thank_you_redirect_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $enable_thank_you_redirect = isset( $options['enable_thank_you_redirect'] ) ? $options['enable_thank_you_redirect'] : 0;
    ?>
    <input type='checkbox' name='hello_woocommerce_settings[enable_thank_you_redirect]' <?php checked( $enable_thank_you_redirect, 1 ); ?> value='1'>
    <?php
}

function skip_cart_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $skip_cart = isset( $options['skip_cart'] ) ? $options['skip_cart'] : 0;
    ?>
    <input type='checkbox' name='hello_woocommerce_settings[skip_cart]' <?php checked( $skip_cart, 1 ); ?> value='1'>
    <?php
}

function thank_you_page_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $thank_you_page = isset( $options['thank_you_page'] ) ? $options['thank_you_page'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_woocommerce_settings[thank_you_page]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $thank_you_page, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function failed_page_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $failed_page = isset( $options['failed_page'] ) ? $options['failed_page'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_woocommerce_settings[failed_page]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $failed_page, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function on_hold_page_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $on_hold_page = isset( $options['on_hold_page'] ) ? $options['on_hold_page'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_woocommerce_settings[on_hold_page]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $on_hold_page, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function enable_affiliatewp_config_render() {
    $options = get_option( 'hello_affiliatewp_settings' );
    $enable_affiliatewp_config = isset( $options['enable_affiliatewp_config'] ) ? $options['enable_affiliatewp_config'] : 0;
    ?>
    <input type='checkbox' name='hello_affiliatewp_settings[enable_affiliatewp_config]' <?php checked( $enable_affiliatewp_config, 1 ); ?> value='1'>
    <?php
}

function affiliatewp_register_render() {
    $options = get_option( 'hello_affiliatewp_settings' );
    $affiliatewp_register = isset( $options['affiliatewp_register'] ) ? $options['affiliatewp_register'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_affiliatewp_settings[affiliatewp_register]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $affiliatewp_register, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function affiliatewp_area_login_render() {
    $options = get_option( 'hello_affiliatewp_settings' );
    $affiliatewp_area_login = isset( $options['affiliatewp_area_login'] ) ? $options['affiliatewp_area_login'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_affiliatewp_settings[affiliatewp_area_login]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $affiliatewp_area_login, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function hello_theme_get_pages_array() {
    $pages = get_pages();
    $pages_array = array();
    foreach ( $pages as $page ) {
        $pages_array[ $page->ID ] = $page->post_title;
    }
    return $pages_array;
}
