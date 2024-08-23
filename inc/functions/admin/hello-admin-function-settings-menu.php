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

    add_submenu_page(
        'hello-theme-panel',
        'Hello Products',
        'Hello Products',
        'manage_options',
        'hello-product-selection-settings',
        'hello_theme_product_selection_settings_page'
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

function hello_theme_product_selection_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hello Product Selection Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'hello_product_selection_settings_group' );
            do_settings_sections( 'hello-product-selection-settings' );
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
            submit_button( 'Generate Shortcode' );
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
    register_setting( 'hello_woocommerce_settings_group', 'enable_ecommerce_tracking' );
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
        'enable_ecommerce_tracking',
        'Enable E-Commerce Tracking',
        'hello_theme_enable_ecommerce_tracking_callback',
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
}
add_action( 'admin_init', 'hello_theme_register_settings' );

// Mendaftarkan pengaturan dan bagian pengaturan untuk WooCommerce
function hello_theme_register_product_selection_settings() {
    register_setting( 'hello_product_selection_settings_group', 'enable_product_selection_pages' );

    add_settings_section(
        'hello_product_selection_settings_section',
        'Hello Theme Product Selection Settings',
        'hello_product_selection_settings_section_callback',
        'hello-product-selection-settings'
    );

    add_settings_field(
        'enable_product_selection_pages',
        'Enable Thank You Page Redirect',
        'hello_theme_enable_product_selection_pages_callback',
        'hello-product-selection-settings',
        'hello_product_selection_settings_section'
    );

}
add_action( 'admin_init', 'hello_theme_register_product_selection_settings' );

// Mendaftarkan pengaturan dan bagian pengaturan untuk Affiliate WP
function hello_theme_register_affiliatewp_settings() {
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_enable' );
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_register_id' );
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_area_id' );
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_enable_redirect_referral' );
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_enable_redirect_method' );
    register_setting( 'hello_affiliatewp_settings_group', 'hello_theme_affiliatewp_redirect_referral_url' );

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

    // add_settings_field(
    //     'hello_theme_affiliatewp_register_id',
    //     'AffiliateWP Register Page ID',
    //     'hello_theme_affiliatewp_register_id_callback',
    //     'hello-affiliatewp-settings',
    //     'hello_affiliatewp_settings_section'
    // );

    // add_settings_field(
    //     'hello_theme_affiliatewp_area_id',
    //     'AffiliateWP Area Login Page ID',
    //     'hello_theme_affiliatewp_area_id_callback',
    //     'hello-affiliatewp-settings',
    //     'hello_affiliatewp_settings_section'
    // );

    add_settings_field(
        'hello_theme_affiliatewp_enable_redirect_referral',
        'Enable AffiliateWP Redirect Referral',
        'hello_theme_affiliatewp_enable_redirect_referral_callback',
        'hello-affiliatewp-settings',
        'hello_affiliatewp_settings_section'
    );

    add_settings_field(
        'hello_theme_affiliatewp_enable_redirect_method',
        'AffiliateWP Redirect Referral Method',
        'hello_theme_affiliatewp_enable_redirect_method_callback',
        'hello-affiliatewp-settings',
        'hello_affiliatewp_settings_section'
    );

    add_settings_field(
        'hello_theme_affiliatewp_redirect_referral_url',
        'AffiliateWP Redirect Referral Url',
        'hello_theme_affiliatewp_redirect_referral_url_callback',
        'hello-affiliatewp-settings',
        'hello_affiliatewp_settings_section'
    );
}
add_action( 'admin_init', 'hello_theme_register_affiliatewp_settings' );

// Mendaftarkan pengaturan dan bagian pengaturan untuk Table Pricing
function hello_theme_register_table_pricing_settings() {
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_enable_table_pricing' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_mode' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_style' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_category' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_category_active' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_enable_html_value' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_logo_url' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_tooltips' );
    register_setting( 'hello_table_pricing_settings_group', 'hello_theme_table_tooltip_post_id' );

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
        'hello_theme_table_pricing_title_generate',
        'Generate Shortcode',
        'hello_theme_table_pricing_title_generate_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_mode',
        'Tab Mode',
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
        'hello_theme_table_category',
        'Select Product Categories',
        'hello_theme_table_category_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_category_active',
        'Category Active Tab (Level 2)',
        'hello_theme_table_category_active_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_enable_html_value',
        'Enable HTML value',
        'hello_theme_table_enable_html_value_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_logo_url',
        'Header Logo',
        'hello_theme_table_logo_url_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_tooltips',
        'Enable Tooltips Table',
        'hello_theme_table_tooltips_callback',
        'hello-table-pricing-settings',
        'hello_table_pricing_settings_section'
    );

    add_settings_field(
        'hello_theme_table_tooltip_post_id',
        'Tooltips Post-Id',
        'hello_theme_table_tooltip_post_id_callback',
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

function hello_product_selection_settings_section_callback() {
    echo '<p>Configure your Product Selections below.</p>';
}

function hello_table_pricing_settings_section_callback() {
    // Get the base URL of the site
    $site_url = home_url();
    // Manually append the path to the JSON file within the child theme directory
    $file_url = $site_url . '/wp-content/themes/hellotheme/inc/functions/import/acf-export-ypf-default-2024.json';
    
    echo '<p>Configure & Generate your Pricing Table settings below.</p>';
    echo '<p><strong>Download ACF Template:</strong> If you want to use a pre-built ACF template for your pricing table, you can download the JSON file from the link below and import it into your ACF settings.</p>';
    echo '<a href="' . esc_url($file_url) . '" download>Download ACF Template JSON File</a>';
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

function hello_theme_enable_ecommerce_tracking_callback() {
    $options = get_option( 'enable_ecommerce_tracking' );
    ?>
    <input type="checkbox" name="enable_ecommerce_tracking" value="1" <?php checked( 1, $options, true ); ?> />
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

function hello_theme_enable_product_selection_pages_callback() {
    $options = get_option( 'enable_product_selection_pages' );
    ?>
    <input type="checkbox" name="enable_product_selection_pages" value="1" <?php checked( 1, $options, true ); ?> />
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

function hello_theme_affiliatewp_enable_redirect_referral_callback() {
    $options = get_option( 'hello_theme_affiliatewp_enable_redirect_referral' );
    ?>
    <input type="checkbox" name="hello_theme_affiliatewp_enable_redirect_referral" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_affiliatewp_enable_redirect_method_callback() {
    $options = get_option( 'hello_theme_affiliatewp_enable_redirect_method' );
    ?>
    <select name="hello_theme_affiliatewp_enable_redirect_method">
        <option value="php" <?php selected( $options, 'php' ); ?>>PHP Redirect</option>
        <option value="js" <?php selected( $options, 'js' ); ?>>JS Redirect</option>
    </select>
    <?php
}

function hello_theme_affiliatewp_redirect_referral_url_callback() {
    $options = get_option( 'hello_theme_affiliatewp_redirect_referral_url' );
    ?>
    <input type="text" id="hello_theme_affiliatewp_redirect_referral_url" name="hello_theme_affiliatewp_redirect_referral_url" value="<?php  echo esc_attr($options) ?>" />
    <?php
}

function hello_theme_enable_table_pricing_callback() {
    $options = get_option( 'hello_theme_enable_table_pricing' );
    ?>
    <input type="checkbox" name="hello_theme_enable_table_pricing" value="1" <?php checked( 1, $options, true ); ?> />
    <?php
}

function hello_theme_table_pricing_title_generate_callback() {
    ?>
    <p>Generate Shortcode on your Front-End or Table Pricing Page</p>
    <?php
}

function hello_theme_table_mode_callback() {
    $options = get_option( 'hello_theme_table_mode' );
    ?>
    <select name="hello_theme_table_mode">
        <option value="level-1" <?php selected( $options, 'level-1' ); ?>>Tab Level 1</option>
        <option value="level-2" <?php selected( $options, 'level-2' ); ?>>Tab Level 2</option>
    </select>
    <?php
}

function hello_theme_table_style_callback() {
    $options = get_option( 'hello_theme_table_style' );
    ?>
    <select name="hello_theme_table_style">
        <option value="style1" <?php selected( $options, 'style1' ); ?>>Table Style 1</option>
    </select>
    <?php
}

function hello_theme_table_category_callback() {
    $options = get_option( 'hello_theme_table_category' );
    ?>
    <input type="text" id="hello_theme_table_category" name="hello_theme_table_category" value="<?php  echo esc_attr($options) ?>" placeholder="Categories slug url : 1-phase-challenge, 2-phase-challenge" />
    <?php
}

function hello_theme_table_category_active_callback() {
    $options = get_option( 'hello_theme_table_category_active' );
    ?>
    <input type="text" id="hello_theme_table_category_active" name="hello_theme_table_category_active" value="<?php  echo esc_attr($options) ?>" placeholder="Category slug url : 1-phase-challenge" />
    <?php
}

function hello_theme_table_enable_html_value_callback() {
    $options = get_option( 'hello_theme_table_enable_html_value' );
    ?>
    <select name="hello_theme_table_enable_html_value">
        <option value="yes" <?php selected( $options, 'yes' ); ?>>Yes</option>
        <option value="no" <?php selected( $options, 'no' ); ?>>No</option>
    </select>
    <?php
}



function hello_theme_table_logo_url_callback() {
    $options = get_option( 'hello_theme_table_logo_url' );
    ?>
    <input type="text" id="hello_theme_table_logo_url" name="hello_theme_table_logo_url" value="<?php  echo esc_attr($options) ?>" placeholder="if using text, leave it default blank" />
    <?php
}

function hello_theme_table_tooltips_callback() {
    $options = get_option( 'hello_theme_table_tooltips' );
    ?>
    <select name="hello_theme_table_tooltips">
        <option value="yes" <?php selected( $options, 'yes' ); ?>>Yes</option>
        <option value="no" <?php selected( $options, 'no' ); ?>>No</option>
    </select>
    <?php
}

function hello_theme_table_tooltip_post_id_callback() {
    $options = get_option( 'hello_theme_table_tooltip_post_id' );
    ?>
    <input type="text" id="hello_theme_table_tooltip_post_id" name="hello_theme_table_tooltip_post_id" value="<?php  echo esc_attr($options) ?>" placeholder="Tooltips Post ID" />
    <?php
}

function hello_theme_table_pricing_description_callback() {
    $mode = get_option( 'hello_theme_table_mode', 'level-1' );
    $style = get_option( 'hello_theme_table_style', 'style1' );
    $categories = get_option( 'hello_theme_table_category', 'origin' ); 
    $category_active = get_option( 'hello_theme_table_category_active', '' ); 
    $html_value = get_option( 'hello_theme_table_enable_html_value', 'yes' );
    $logo_url = get_option( 'hello_theme_table_logo_url' );
    $tooltips = get_option( 'hello_theme_table_tooltips', 'no' ); 
    $tooltips_post_id = get_option( 'hello_theme_table_tooltip_post_id', '16787' ); 


    if ($mode === 'level-1'){
        $shortcode_tag = 'hello_pricing_table_level_1';
    } else {
        $shortcode_tag = 'hello_pricing_table_level_2';
    }
    ?>
    <p>Use this shortcode on your Front-End or Table Pricing Page : <br/>
    <code>
        [<?php echo esc_attr( $shortcode_tag ); ?> tab_mode='<?php echo esc_attr( $mode ); ?>' style='<?php echo esc_attr( $style ); ?>' category='<?php echo esc_attr( $categories ); ?>' category_active='<?php echo esc_attr( $category_active ); ?>' html_value='<?php echo esc_attr( $html_value ); ?>' tooltips='<?php echo esc_attr( $tooltips ); ?>' tooltips_post_id='<?php echo esc_attr( $tooltips_post_id ); ?>' logo_url='<?php echo esc_attr( $logo_url ); ?>' ]
    </code>
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