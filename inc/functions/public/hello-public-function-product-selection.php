<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

function hello_theme_challenge_selection_shortcode($atts) {
    $enabled_pricing_table = get_option('hello_theme_enable_table_pricing');
    $atts = shortcode_atts(
        array(
            'tab_mode' => 'mode-1',
            'category' => '',
        ),
        $atts,
        'hello_challenge_selection'
    );

    if ($enabled_pricing_table !== '1') {
        return;
    }

    $tab_mode = $atts['tab_mode'];

    // Parse the categories from the shortcode attribute
    $category_slugs = explode(',', $atts['category']);
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'slug' => $category_slugs,
        'hide_empty' => false,
    ));

    ob_start();
    ?>
        <!-- Add your HTML here as per the uploaded design -->
        <div class="hello-theme-container hello-theme-table-pricing hello-theme-with-tab hello-theme-table-<?php echo $tab_mode; ?>">
            <div class="hello-theme-tab-buttons">
                <?php foreach ($categories as $index => $category): ?>
                    <div class="hello-theme-tab-button <?php echo $index == 0 ? 'active' : ''; ?>" data-tab-id="tab-<?php echo $category->term_id; ?>">
                        <?php echo $category->name; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php foreach ($categories as $index => $category): ?>
            <div id="tab-<?php echo $category->term_id; ?>" class="hello-theme-tab-content category-<?php echo $category->slug; ?> <?php echo $index == 0 ? 'active' : ''; ?>" data-tab-id="tab-<?php echo $category->term_id; ?>">
                <?php
                $products = wc_get_products(array(
                    'category' => array($category->slug),
                    'status' => 'publish',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                if ($products): ?>
                    <div class="hello-theme-sub-tab-buttons">
                        <?php foreach ($products as $productIndex => $product): ?>
                            <div class="hello-theme-sub-tab-button <?php echo $productIndex == 0 ? 'active' : ''; ?>" data-sub-tab-id="subtab-<?php echo $product->get_id(); ?>">
                                <?php echo $product->get_name(); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php foreach ($products as $productIndex => $product): ?>
                        <div id="subtab-<?php echo $product->get_id(); ?>" class="hello-theme-sub-tab-content product-<?php echo $product->get_slug(); ?> <?php echo $productIndex == 0 ? 'active' : ''; ?>" data-sub-tab-id="subtab-<?php echo $product->get_id(); ?>">
                            <p><?php echo $product->get_name(); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="hello-theme-sub-tab-buttons">
                        <p>No products found in this category.</p>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    <?php
    return ob_get_clean();
}
add_shortcode('hello_challenge_selection', 'hello_theme_challenge_selection_shortcode');

function custom_product_selection_shortcode() {
    ob_start(); // Memulai output buffering untuk menampung output shortcode
    
    // Kategori Produk
    $categories = array(
        'base-camp' => 'Base Camp',
        'the-peak' => 'The Peak'
    );
    
    // Bagian Pilihan Kategori
    echo '<div id="product-selection">';
    echo '<div class="category-selection">';
    echo '<h3>Category</h3>';
    foreach ($categories as $slug => $name) {
        echo '<button class="category-button" data-category="' . esc_attr($slug) . '">' . esc_html($name) . '</button>';
    }
    echo '</div>';
    
    // Bagian Pilihan Produk (Akan diisi berdasarkan kategori yang dipilih)
    echo '<div class="product-selection">';
    echo '<h3>Choose a Product</h3>';
    echo '<div id="product-list"></div>'; // Daftar produk akan di-load via AJAX
    echo '</div>';
    
    echo '</div>';
    
    // Mengembalikan output buffer
    return ob_get_clean();
}

// Menambahkan shortcode ke WordPress
add_shortcode('product_selection', 'custom_product_selection_shortcode');

function hello_theme_product_selection_enqueue_scripts() {
    wp_enqueue_script('hello-theme-product-selection-js', get_stylesheet_directory_uri() . '/assets/js/hello-theme-product-selection.js', array('jquery'), HELLO_THEME_VERSION, true);

    // Mengirimkan variabel untuk digunakan dalam JavaScript (nonce dan URL AJAX)
    wp_localize_script('hello-theme-product-selection-js', 'productSelectionParams', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('product_selection_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'hello_theme_product_selection_enqueue_scripts');

function load_products_by_category() {
    // Validasi nonce untuk keamanan
    check_ajax_referer('product_selection_nonce', 'nonce');

    // Mendapatkan kategori yang dipilih
    $category_slug = sanitize_text_field($_POST['category']);

    // Query untuk mendapatkan produk berdasarkan kategori
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1, // Ambil semua produk
        'product_cat' => $category_slug, // Filter berdasarkan kategori
        'post_status' => 'publish',
    );

    $products = new WP_Query($args);

    if ($products->have_posts()) {
        echo '<ul>';
        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());

            // Tampilkan nama produk dan harga
            echo '<li>';
            echo '<input type="radio" name="selected_product" value="' . esc_attr($product->get_id()) . '" />';
            echo '<span>' . get_the_title() . ' - ' . $product->get_price_html() . '</span>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No products found in this category.</p>';
    }

    wp_reset_postdata();
    wp_die(); // Menghentikan eksekusi PHP
}
add_action('wp_ajax_load_products_by_category', 'load_products_by_category');
add_action('wp_ajax_nopriv_load_products_by_category', 'load_products_by_category');

// Add custom radio buttons for Account Type
function hello_theme_add_account_type_field() {
    global $post;

    echo '<div class="options_group">';

    // Custom radio buttons for Account Type
    woocommerce_wp_radio(
        array(
            'id'          => '_account_type',
            'label'       => __('Account Type', 'woocommerce'),
            'description' => __('Select the account type for this product.', 'woocommerce'),
            'desc_tip'    => 'true',
            'options'     => array(
                'standard' => __('Standard Account', 'woocommerce'),
                'swing'    => __('Swing Account', 'woocommerce')
            )
        )
    );

    echo '</div>';
}
add_action('woocommerce_product_options_pricing', 'hello_theme_add_account_type_field');


// Add custom fields for Base Camp and The Peak categories
function hello_theme_add_addon_product_fields() {
    global $post;

    echo '<div class="options_group">';

    // Custom checkbox fields for Base Camp category
    if (has_term('base-camp', 'product_cat', $post)) {
        woocommerce_wp_checkbox(
            array(
                'id'          => '_basecamp_active_days',
                'label'       => __('Active Days: 21 Days', 'woocommerce'),
                'description' => __('Check this if Active Days is 21 Days for Base Camp category.', 'woocommerce'),
                'desc_tip'    => 'true'
            )
        );
        woocommerce_wp_checkbox(
            array(
                'id'          => '_basecamp_profit_split',
                'label'       => __('Profit Split', 'woocommerce'),
                'description' => __('Check this if Profit Split is available for Base Camp category.', 'woocommerce'),
                'desc_tip'    => 'true'
            )
        );
    }

    // Custom checkbox fields for The Peak category
    if (has_term('the-peak', 'product_cat', $post)) {
        woocommerce_wp_checkbox(
            array(
                'id'          => '_thepeak_active_days',
                'label'       => __('Active Days: Bi-weekly', 'woocommerce'),
                'description' => __('Check this if Active Days is Bi-weekly for The Peak category.', 'woocommerce'),
                'desc_tip'    => 'true'
            )
        );
        woocommerce_wp_checkbox(
            array(
                'id'          => '_thepeak_trading_days',
                'label'       => __('Trading Days: No minimum trading days', 'woocommerce'),
                'description' => __('Check this if Trading Days has no minimum days for The Peak category.', 'woocommerce'),
                'desc_tip'    => 'true'
            )
        );
    }

    echo '</div>';
}
add_action('woocommerce_product_options_pricing', 'hello_theme_add_addon_product_fields');

// Save the custom radio button field data
function hello_theme_save_account_type_field($post_id) {
    if (isset($_POST['_account_type'])) {
        update_post_meta($post_id, '_account_type', sanitize_text_field($_POST['_account_type']));
    }
}
add_action('woocommerce_process_product_meta', 'hello_theme_save_account_type_field');


// Save the custom checkbox fields data
function hello_theme_save_addon_product_fields_checkbox_fields($post_id) {
    // Save Base Camp checkbox fields
    $basecamp_active_days = isset($_POST['_basecamp_active_days']) ? 'yes' : 'no';
    update_post_meta($post_id, '_basecamp_active_days', $basecamp_active_days);

    $basecamp_profit_split = isset($_POST['_basecamp_profit_split']) ? 'yes' : 'no';
    update_post_meta($post_id, '_basecamp_profit_split', $basecamp_profit_split);

    // Save The Peak checkbox fields
    $thepeak_active_days = isset($_POST['_thepeak_active_days']) ? 'yes' : 'no';
    update_post_meta($post_id, '_thepeak_active_days', $thepeak_active_days);

    $thepeak_trading_days = isset($_POST['_thepeak_trading_days']) ? 'yes' : 'no';
    update_post_meta($post_id, '_thepeak_trading_days', $thepeak_trading_days);
}
add_action('woocommerce_process_product_meta', 'hello_theme_save_addon_product_fields_checkbox_fields');





