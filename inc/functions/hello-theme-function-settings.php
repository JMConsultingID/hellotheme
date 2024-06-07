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
        'hello_theme_redirects_section_second_title',
        __( 'Hello Theme AffiliateWP Settings', 'hello-theme' ),
        'hello_theme_affiliatewp_section_callback',
        'hello-affiliatewp'
    );

    add_settings_field(
        'hello_theme_affiliatewp_enable',
        __( 'Enable AffiliateWP Configuration', 'hello-theme' ),
        'hello_theme_affiliatewp_enable_render',
        'hello-affiliatewp',
        'hello_theme_redirects_section_second_title'
    );

    add_settings_field(
        'hello_theme_affiliatewp_register_id',
        __( 'AffiliateWP Register Page ID', 'hello-theme' ),
        'hello_theme_affiliatewp_register_id_render',
        'hello-affiliatewp',
        'hello_theme_redirects_section_second_title'
    );

    add_settings_field(
        'hello_theme_affiliatewp_area_id',
        __( 'AffiliateWP Area Login Page ID', 'hello-theme' ),
        'hello_theme_affiliatewp_area_id_render',
        'hello-affiliatewp',
        'hello_theme_redirects_section_second_title'
    );
}

add_action( 'admin_init', 'hello_theme_affiliatewp_settings_init' );

// Mendaftarkan pengaturan dan menambahkan pengaturan ke halaman WooCommerce
function hello_theme_woocommerce_settings_init() {
    register_setting( 'hello_woocommerce_settings_group', 'hello_woocommerce_settings' );

    add_settings_section(
        'hello_theme_redirects_section_title',
        __( 'Hello Theme Redirects Settings', 'hello-theme' ),
        'hello_theme_woocommerce_section_callback',
        'hello-woocommerce'
    );

    add_settings_field(
        'hello_theme_checkout_mode',
        __( 'Select Checkout Mode', 'hello-theme' ),
        'hello_theme_checkout_mode_render',
        'hello-woocommerce',
        'hello_theme_redirects_section_title'
    );

    add_settings_field(
        'enable_thank_you_redirect',
        __( 'Enable Thank You Page Redirect', 'hello-theme' ),
        'enable_thank_you_redirect_render',
        'hello-woocommerce',
        'hello_theme_redirects_section_title'
    );

    add_settings_field(
        'skip_cart_page',
        __( 'Skip Cart Page', 'hello-theme' ),
        'skip_cart_page_render',
        'hello-woocommerce',
        'hello_theme_redirects_section_title'
    );

    add_settings_field(
        'hello_theme_thank_you_page_url',
        __( 'Thank You Page URL', 'hello-theme' ),
        'hello_theme_thank_you_page_url_render',
        'hello-woocommerce',
        'hello_theme_redirects_section_title'
    );

    add_settings_field(
        'hello_theme_failed_page_url',
        __( 'Failed Order Page URL', 'hello-theme' ),
        'hello_theme_failed_page_url_render',
        'hello-woocommerce',
        'hello_theme_redirects_section_title'
    );

    add_settings_field(
        'hello_theme_on_hold_page_url',
        __( 'On Hold Order Page URL', 'hello-theme' ),
        'hello_theme_on_hold_page_url_render',
        'hello-woocommerce',
        'hello_theme_redirects_section_title'
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

function skip_cart_page_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $skip_cart_page = isset( $options['skip_cart_page'] ) ? $options['skip_cart_page'] : 0;
    ?>
    <input type='checkbox' name='hello_woocommerce_settings[skip_cart_page]' <?php checked( $skip_cart_page, 1 ); ?> value='1'>
    <?php
}

function hello_theme_thank_you_page_url_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $thank_you_page = isset( $options['hello_theme_thank_you_page_url'] ) ? $options['hello_theme_thank_you_page_url'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_woocommerce_settings[hello_theme_thank_you_page_url]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $thank_you_page, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function hello_theme_failed_page_url_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $failed_page = isset( $options['hello_theme_failed_page_url'] ) ? $options['hello_theme_failed_page_url'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_woocommerce_settings[hello_theme_failed_page_url]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $failed_page, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function hello_theme_on_hold_page_url_render() {
    $options = get_option( 'hello_woocommerce_settings' );
    $on_hold_page = isset( $options['hello_theme_on_hold_page_url'] ) ? $options['hello_theme_on_hold_page_url'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_woocommerce_settings[hello_theme_on_hold_page_url]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $on_hold_page, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function hello_theme_affiliatewp_enable_render() {
    $options = get_option( 'hello_affiliatewp_settings' );
    $enable_affiliatewp_config = isset( $options['hello_theme_affiliatewp_enable'] ) ? $options['hello_theme_affiliatewp_enable'] : 0;
    ?>
    <input type='checkbox' name='hello_affiliatewp_settings[hello_theme_affiliatewp_enable]' <?php checked( $enable_affiliatewp_config, 1 ); ?> value='1'>
    <?php
}

function hello_theme_affiliatewp_register_id_render() {
    $options = get_option( 'hello_affiliatewp_settings' );
    $affiliatewp_register = isset( $options['hello_theme_affiliatewp_register_id'] ) ? $options['hello_theme_affiliatewp_register_id'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_affiliatewp_settings[hello_theme_affiliatewp_register_id]'>
        <?php foreach ( $pages as $id => $title ) { ?>
            <option value='<?php echo $id; ?>' <?php selected( $affiliatewp_register, $id ); ?>><?php echo $title; ?></option>
        <?php } ?>
    </select>
    <?php
}

function hello_theme_affiliatewp_area_id_render() {
    $options = get_option( 'hello_affiliatewp_settings' );
    $affiliatewp_area_login = isset( $options['hello_theme_affiliatewp_area_id'] ) ? $options['hello_theme_affiliatewp_area_id'] : '';
    $pages = hello_theme_get_pages_array();
    ?>
    <select name='hello_affiliatewp_settings[hello_theme_affiliatewp_area_id]'>
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