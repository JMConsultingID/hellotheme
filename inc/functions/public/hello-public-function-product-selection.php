<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

function hello_theme_challenge_selection_shortcodes($atts) {
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
add_shortcode('hello_challenge_selections', 'hello_theme_challenge_selection_shortcodes');

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
            ),
            'default'     => 'standard' // Set "Standard Account" as default
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
                'label'       => __('active days: 21 days', 'woocommerce'),
                'description' => __('Check this if Active Days is 21 Days for Base Camp category.', 'woocommerce'),
                'desc_tip'    => 'true'
            )
        );
        woocommerce_wp_checkbox(
            array(
                'id'          => '_basecamp_profit_split',
                'label'       => __('profit split: 50%/70%/80%', 'woocommerce'),
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


function hello_theme_challenge_selection_shortcode($atts) {
    // Default attributes
    $atts = shortcode_atts(array(
        'category' => 'base-camp, the-peak',
        'type_account' => 'yes',
        'addons' => 'yes'
    ), $atts, 'hello_challenge_selection');

    // Explode categories
    $categories = explode(',', $atts['category']);
    $categories = array_map('trim', $categories);

    // Generate HTML for form
    ob_start();
    ?>
    <div id="challenge-selection-form">
        <!-- Category Selection -->
        <h3>Select Category</h3>
        <select id="category-select">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo esc_attr($category); ?>"><?php echo ucfirst(trim($category)); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Account Type Selection -->
        <?php if ($atts['type_account'] == 'yes'): ?>
            <h3>Select Account Type</h3>
            <input type="radio" id="standard_account" name="account_type" value="standard">
            <label for="standard_account">Standard Account</label>
            <input type="radio" id="swing_account" name="account_type" value="swing">
            <label for="swing_account">Swing Account</label>
        <?php endif; ?>

        <!-- Add-ons Selection -->
        <?php if ($atts['addons'] == 'yes'): ?>
            <h3>Select Add-ons</h3>
            <input type="checkbox" id="active_days" name="addon" value="active_days">
            <label for="active_days">Active Days</label>
            <input type="checkbox" id="profit_split" name="addon" value="profit_split">
            <label for="profit_split">Profit Split</label>
            <input type="checkbox" id="trading_days" name="addon" value="trading_days" style="display: none;">
            <label for="trading_days" style="display: none;">Trading Days</label>
        <?php endif; ?>

        <!-- Product Selection -->
        <h3>Select Product</h3>
        <select id="product-select">
            <!-- Options will be dynamically loaded here -->
        </select>

        <!-- Checkout Button -->
        <div id="checkout-button-container">
            <a id="checkout-button" href="#" class="button disabled">Continue</a>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            function updateProductOptions() {
                var category = $('#category-select').val();
                var accountType = $('input[name="account_type"]:checked').val();

                // Fetch products dynamically based on selected category and account type
                $.ajax({
                    url: ajax_object.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'get_products_by_selection',
                        category: category,
                        accountType: accountType
                    },
                    success: function(response) {
                        $('#product-select').html(response);
                        updateCheckoutButton();
                    }
                });
            }

            function updateCheckoutButton() {
                var category = $('#category-select').val();
                var accountType = $('input[name="account_type"]:checked').val();
                var productId = $('#product-select').val();
                var addons = [];
                $('input[name="addon"]:checked').each(function() {
                    addons.push($(this).val());
                });

                // AJAX request to get the correct product ID dynamically
                $.ajax({
                    url: ajax_object.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'get_dynamic_product_id',
                        category: category,
                        accountType: accountType,
                        productId: productId,
                        addons: addons
                    },
                    success: function(response) {
                        if (response) {
                            $('#checkout-button').attr('href', '/checkout/?add-to-cart=' + response);
                            $('#checkout-button').removeClass('disabled');
                        } else {
                            $('#checkout-button').attr('href', '#');
                            $('#checkout-button').addClass('disabled');
                        }
                    }
                });
            }

            // Update products on selection change
            $('#category-select, input[name="account_type"]').change(function() {
                updateProductOptions();
            });

            // Update button on product or addon change
            $('#product-select, input[name="addon"]').change(function() {
                updateCheckoutButton();
            });

            // Initial call to populate products
            updateProductOptions();
        });
    </script>
    <?php

    return ob_get_clean();
}
add_shortcode('hello_challenge_selection', 'hello_theme_challenge_selection_shortcode');

function get_products_by_selection() {
    $category = sanitize_text_field($_POST['category']);
    $accountType = sanitize_text_field($_POST['accountType']);

    // Query to fetch products dynamically
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => '_account_type',
                'value' => $accountType,
                'compare' => '=',
            ),
        ),
    );

    $query = new WP_Query($args);

    $output = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product_id = get_the_ID();
            $product_name = get_the_title();
            $product_price = get_post_meta($product_id, '_price', true); // Get the product price

            $output .= '<option value="' . esc_attr($product_id) . '">' . esc_html($product_name) . ' ($' . esc_html($product_price) . ')</option>';
        }
    } else {
        $output = '<option value="">No products available</option>';
    }

    wp_reset_postdata();
    echo $output;
    wp_die();
}
add_action('wp_ajax_get_products_by_selection', 'get_products_by_selection');
add_action('wp_ajax_nopriv_get_products_by_selection', 'get_products_by_selection');

