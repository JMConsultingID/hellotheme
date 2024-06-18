<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

// Menambahkan menu dan submenu di bawah dashboard WordPress
function hello_theme_add_menu_page() {
    add_menu_page(
        'Hello Theme Panel',
        'Hello Panel',
        'manage_options',
        'hello-theme-panel',
        'hello_theme_panel_page_content',
        'dashicons-screenoptions',
        2
    );

    add_submenu_page(
        'hello-theme-panel',
        'Hello AffiliateWP',
        'Hello AffiliateWP',
        'manage_options',
        'hello-affiliatewp-settings',
        'hello_theme_affiliatewp_settings_page'
    );

    add_submenu_page(
        'hello-theme-panel',
        'Hello Pricing Table',
        'Hello Pricing Table',
        'manage_options',
        'hello-table-pricing-settings',
        'hello_theme_table_pricing_settings_page'
    );

    add_submenu_page(
        'hello-theme-panel',
        'Hello WooCommerce',
        'Hello WooCommerce',
        'manage_options',
        'hello-woocommerce-settings',
        'hello_theme_woocommerce_settings_page'
    );   

}
add_action( 'admin_menu', 'hello_theme_add_menu_page' );

// Konten halaman utama Hello Theme Panel
function hello_theme_panel_page_content() {
    echo "<h1>Welcome to Hello Theme Panel</h1>";
    echo "<p>We're still under development. Please be patient – we'll let you know as soon as we're live!</p>";
}

// Konten halaman pengaturan WooCommerce
function hello_theme_woocommerce_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hello WooCommerce Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'hello_woocommerce_settings_group' );
            do_settings_sections( 'hello-woocommerce-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Konten halaman pengaturan Table Pricing
function hello_theme_table_pricing_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hello Table Pricing Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'hello_table_pricing_settings_group' );
            do_settings_sections( 'hello-table-pricing-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Konten halaman pengaturan Affiliate WP
function hello_theme_affiliatewp_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hello AffiliateWP Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'hello_affiliatewp_settings_group' );
            do_settings_sections( 'hello-affiliatewp-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Mendaftarkan pengaturan dan bagian pengaturan untuk WooCommerce
function hello_theme_register_settings() {
    register_setting( 'hello_woocommerce_settings_group', 'hello_theme_checkout_mode' );
    register_setting( 'hello_woocommerce_settings_group', 'enable_thank_you_redirect' );
    register_setting( 'hello_woocommerce_settings_group', 'skip_cart_page' );
    register_setting( 'hello_woocommerce_settings_group', 'disable_shop_page' );
    register_setting( 'hello_woocommerce_settings_group', 'disable_product_page' );
    register_setting( 'hello_woocommerce_settings_group', 'hello_theme_thank_you_page_url' );
    register_setting( 'hello_woocommerce_settings_group', 'hello_theme_failed_page_url' );
    register_setting( 'hello_woocommerce_settings_group', 'hello_theme_on_hold_page_url' );

    add_settings_section(
        'hello_woocommerce_settings_section',
        'Hello Theme WooCommerce Settings',
        'hello_woocommerce_settings_section_callback',
        'hello-woocommerce-settings'
    );

    add_settings_field(
        'hello_theme_checkout_mode',
        'Select Checkout Mode',
        'hello_theme_checkout_mode_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'enable_thank_you_redirect',
        'Enable Thank You Page Redirect',
        'hello_theme_enable_thank_you_redirect_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'skip_cart_page',
        'Skip Cart Page',
        'hello_theme_skip_cart_page_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'disable_shop_page',
        'Disable Shop Page',
        'hello_theme_disable_shop_page_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'disable_product_page',
        'Disable Product Page',
        'hello_theme_disable_product_page_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );


    add_settings_field(
        'select_custom_url_thank_you_page',
        'Custom Url Thank You Page',
        'hello_theme_select_custom_url_thank_you_page_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'hello_theme_thank_you_page_url',
        'Thank You Page URL',
        'hello_theme_thank_you_page_url_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'hello_theme_failed_page_url',
        'Failed Order Page URL',
        'hello_theme_failed_page_url_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'hello_theme_on_hold_page_url',
        'On Hold Order Page URL',
        'hello_theme_on_hold_page_url_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'hello_theme_custom_thank_you_page_url',
        'Custom Thank You Page URL',
        'hello_theme_custom_thank_you_page_url_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );

    add_settings_field(
        'hello_theme_custom_failed_page_url',
        'Custom Failed Order Page URL',
        'hello_theme_custom_failed_page_url_callback',
        'hello-woocommerce-settings',
        'hello_woocommerce_settings_section'
    );
}
add_action( 'admin_init', 'hello_theme_register_settings' );

function hello_theme_register_affiliatewp_settings() {
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_enable' );
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_register_id' );
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_area_id' );

    add_settings_section(
        'hello_affiliatewp_settings_section',
        'Hello Theme AffiliateWP Settings',
        'hello_affiliatewp_settings_section_callback',
        'hello-affiliatewp-settings'
    );

    add_settings_field(
        'hello_theme_affiliatewp_enable',
        'Enable AffiliateWP Configuration',
        'hello_theme_affiliatewp_enable_callback',
        'hello-affiliatewp-settings',
        'hello_affiliatewp_settings_section'
    );

    add_settings_field(
        'hello_theme_affiliatewp_register_id',
        'AffiliateWP Register Page ID',
        'hello_theme_affiliatewp_register_id_callback',
        'hello-affiliatewp-settings',
        'hello_affiliatewp_settings_section'
    );

    add_settings_field(
        'hello_theme_affiliatewp_area_id',
        'AffiliateWP Area Login Page ID',
        'hello_theme_affiliatewp_area_id_callback',
        'hello-affiliatewp-settings',
        'hello_affiliatewp_settings_section'
    );
}
add_action( 'admin_init', 'hello_theme_register_affiliatewp_settings' );

function hello_theme_register_table_pricing_settings() {
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_enable_table_pricing' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_mode' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_style' );

    add_settings_section(
        'hello_table_pricing_settings_section',
        'Hello Theme Pricing Table Settings',
        'hello_table_pricing_settings_section_callback',
        'hello-table-pricing-settings'
    );

    add_settings_field(
        'hello_theme_enable_table_pricing',
        'Enable Pricing Table',
        'hello_theme_enable_table_pricing_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_mode',
        'Table Mode',
        'hello_theme_table_mode_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_style',
        'Select Table Style',
        'hello_theme_table_style_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_pricing_description',
        'Shortcode',
        'hello_theme_table_pricing_description_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );
}
add_action( 'admin_init', 'hello_theme_register_table_pricing_settings' );

function hello_woocommerce_settings_section_callback() {
    echo '<p>Configure your WooCommerce settings below.</p>';
}

function hello_affiliatewp_settings_section_callback() {
    echo '<p>Configure your AffiliateWP settings below.</p>';
}

function hello_table_pricing_settings_section_callback() {
    echo '<p>Configure your Pricing Table settings below.</p>';
}

function hello_theme_checkout_mode_callback() {
    $options = get_option( 'hello_theme_checkout_mode' );
    ?>
    <select name="hello_theme_checkout_mode">
        <option value="single" <?php selected( $options, 'single' ); ?>>Single Product</option>
        <option value="multiple" <?php selected( $options, 'multiple' ); ?>>Multiple Products</option>
    </select>
    <?php
}

function hello_theme_enable_thank_you_redirect_callback() {
    $options = get_option( 'enable_thank_you_redirect' );
    ?>
    <input type="checkbox" name="enable_thank_you_redirect" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_skip_cart_page_callback() {
    $options = get_option( 'skip_cart_page' );
    ?>
    <input type="checkbox" name="skip_cart_page" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_disable_shop_page_callback() {
    $options = get_option( 'disable_shop_page' );
    ?>
    <input type="checkbox" name="disable_shop_page" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_disable_product_page_callback() {
    $options = get_option( 'disable_product_page' );
    ?>
    <input type="checkbox" name="disable_product_page" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_select_custom_url_thank_you_page_callback() {
    $options = get_option( 'select_custom_url_thank_you_page' );
    ?>
    <input type="checkbox" name="select_custom_url_thank_you_page" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_thank_you_page_url_callback() {
    $options = get_option( 'hello_theme_thank_you_page_url' );
    $pages = hello_theme_menu_get_pages_array();
    ?>
    <select name="hello_theme_thank_you_page_url">
        <?php
        foreach ( $pages as $id => $title ) {
            echo '<option value="' . esc_attr( $id ) . '" ' . selected( $options, $id, false ) . '>' . esc_html( $title ) . '</option>';
        }
        ?>
    </select>
    <?php
}

function hello_theme_failed_page_url_callback() {
    $options = get_option( 'hello_theme_failed_page_url' );
    $pages = hello_theme_menu_get_pages_array();
    ?>
    <select name="hello_theme_failed_page_url">
        <?php
        foreach ( $pages as $id => $title ) {
            echo '<option value="' . esc_attr( $id ) . '" ' . selected( $options, $id, false ) . '>' . esc_html( $title ) . '</option>';
        }
        ?>
    </select>
    <?php
}

function hello_theme_on_hold_page_url_callback() {
    $options = get_option( 'hello_theme_on_hold_page_url' );
    $pages = hello_theme_menu_get_pages_array();
    ?>
    <select name="hello_theme_on_hold_page_url">
        <?php
        foreach ( $pages as $id => $title ) {
            echo '<option value="' . esc_attr( $id ) . '" ' . selected( $options, $id, false ) . '>' . esc_html( $title ) . '</option>';
        }
        ?>
    </select>
    <?php
}

function hello_theme_custom_thank_you_page_url_callback() {
    $options = get_option( 'hello_theme_custom_thank_you_page_url' );
    ?>
    <input type="text" name="hello_theme_custom_thank_you_page_url" value="<?php echo esc_url_raw($options); ?>"/>
    <?php
}

function hello_theme_custom_failed_page_url_callback() {
    $options = get_option( 'hello_theme_custom_failed_page_url' );
    ?>
    <input type="text" name="hello_theme_custom_failed_page_url" value="<?php echo esc_url_raw($options); ?>"/>
    <?php
}


function hello_theme_affiliatewp_enable_callback() {
    $options = get_option( 'hello_theme_affiliatewp_enable' );
    ?>
    <input type="checkbox" name="hello_theme_affiliatewp_enable" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_affiliatewp_register_id_callback() {
    $options = get_option( 'hello_theme_affiliatewp_register_id' );
    $pages = hello_theme_menu_get_pages_array();
    ?>
    <select name="hello_theme_affiliatewp_register_id">
        <?php
        foreach ( $pages as $id => $title ) {
            echo '<option value="' . esc_attr( $id ) . '" ' . selected( $options, $id, false ) . '>' . esc_html( $title ) . '</option>';
        }
        ?>
    </select>
    <?php
}

function hello_theme_affiliatewp_area_id_callback() {
    $options = get_option( 'hello_theme_affiliatewp_area_id' );
    $pages = hello_theme_menu_get_pages_array();
    ?>
    <select name="hello_theme_affiliatewp_area_id">
        <?php
        foreach ( $pages as $id => $title ) {
            echo '<option value="' . esc_attr( $id ) . '" ' . selected( $options, $id, false ) . '>' . esc_html( $title ) . '</option>';
        }
        ?>
    </select>
    <?php
}

function hello_theme_enable_table_pricing_callback() {
    $options = get_option( 'hello_theme_enable_table_pricing' );
    ?>
    <input type="checkbox" name="hello_theme_enable_table_pricing" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_table_mode_callback() {
    $options = get_option( 'hello_theme_table_mode' );
    ?>
    <select name="hello_theme_table_mode">
        <option value="single" <?php selected( $options, 'single' ); ?>>Single Table</option>
        <option value="one_tab" <?php selected( $options, 'one_tab' ); ?>>1 Tab Heading</option>
        <option value="two_tabs" <?php selected( $options, 'two_tabs' ); ?>>2 Tabs Heading</option>
        <option value="three_tabs" <?php selected( $options, 'three_tabs' ); ?>>3 Tabs Heading</option>
    </select>
    <?php
}

function hello_theme_table_style_callback() {
    $options = get_option( 'hello_theme_table_style' );
    ?>
    <select name="hello_theme_table_style">
        <option value="style1" <?php selected( $options, 'style1' ); ?>>Table Style 1</option>
        <option value="style2" <?php selected( $options, 'style2' ); ?>>Tabel Style 2</option>
        <option value="style3" <?php selected( $options, 'style3' ); ?>>Table Style 3</option>
    </select>
    <?php
}

function hello_theme_table_pricing_description_callback() {
    $mode = get_option( 'hello_theme_table_mode', 'single' ); // Default to 'single' if not set
    $style = get_option( 'hello_theme_table_style', 'style1' ); // Default to 'style1' if not set
    ?>
    <p>Use this shortcode on your front-end page :
        <ol>
            <li><code>[hello_pricing_table mode='<?php echo esc_attr( $mode ); ?>' style='<?php echo esc_attr( $style ); ?>']</code> for live version</li>
            <li>or using <code>[hello_pricing_table_dev]</code> for development version</li>
        </ol>
    </p>
    <?php
}

function hello_theme_menu_get_pages_array() {
    $pages = get_pages();
    $pages_array = array();
    foreach ( $pages as $page ) {
        $pages_array[ $page->ID ] = $page->post_title;
    }
    return $pages_array;
}