<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

function hello_theme_challenge_selection_shortcode($atts)
{
    $enabled_product_selection = get_option('enable_product_selection_pages');
    if ($enabled_product_selection === '1') {
        $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : 'base-camp';
        $challenge = isset($_GET['challenge']) ? sanitize_text_field($_GET['challenge']) : '10k';
        $account_type = isset($_GET['account_type']) ? sanitize_text_field($_GET['account_type']) : 'standard';
        $active_days = isset($_GET['active_days']) ? sanitize_text_field($_GET['active_days']) : 'no';
        $profitsplit = isset($_GET['profitsplit']) ? sanitize_text_field($_GET['profitsplit']) : 'no';
        $peak_active_days = isset($_GET['peak_active_days']) ? sanitize_text_field($_GET['peak_active_days']) : 'no';
        $tradingdays = isset($_GET['tradingdays']) ? sanitize_text_field($_GET['tradingdays']) : 'no';

        global $wpdb;
        $query = $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}hello_theme_product_combinations 
            WHERE category = %s AND account_type = %s AND challenge = %s 
            AND addon_active_days = %s AND addon_profitsplit = %s AND addon_peak_active_days = %s AND addon_trading_days = %s",
            $category,
            $account_type,
            $challenge,
            $active_days,
            $profitsplit,
            $peak_active_days,
            $tradingdays
        );
        $is_valid_combination = $wpdb->get_var($query) > 0;

        ob_start();
        ?>
        <div id="challenge-selection-form" class="hello-theme-product-selection"
            data-category="<?php echo esc_attr($category); ?>" data-challenge="<?php echo esc_attr($challenge); ?>"
            data-account-type="<?php echo esc_attr($account_type); ?>" data-active-days="<?php echo esc_attr($active_days); ?>"
            data-profitsplit="<?php echo esc_attr($profitsplit); ?>"
            data-peak_active_days="<?php echo esc_attr($peak_active_days); ?>"
            data-tradingdays="<?php echo esc_attr($tradingdays); ?>"
            data-valid="<?php echo $is_valid_combination ? 'yes' : 'no'; ?>">
            <div class="warpper-alf">

                <div class="left box-shadow">

                    <?php if (!$is_valid_combination): ?>
                        <div class="warning">
                            <p>Error Code: 10089 - Invalid Parameter.</p>
                        </div>
                    <?php endif; ?>

                    <!-- Button Selection Category -->
                    <div id="category-selection">
                        <h5 class="sub-title">Category</h5>
                        <input type="radio" class="hide radio" id="id-basecamp" name="category" value="base-camp" <?php checked('base-camp', $category); ?> />
                        <input type="radio" class="hide radio" id="id-thepeak" name="category" value="the-peak" <?php checked('the-peak', $category); ?> />
                        <div class="category-tabs">
                            <div class="category-items">
                                <label class="tab-label" id="tab-label-basecamp" for="id-basecamp">Base Camp</label>
                                <label class="tab-label" id="tab-label-thepeak" for="id-thepeak">The Peak</label>
                            </div>
                        </div>
                    </div>

                    <div class="panels">
                        <div class="panel">
                            <!-- Button Selection Bar Challenge -->
                            <div class="select-account-challenge">
                                <h5 class="sub-title">Balance</h5>
                                <div id="challenge-selection-bar">
                                    <div class="progress-container">
                                        <input type="range" name="range" id="sac-progress-range" value="1" min="1" max="5" />
                                    </div>
                                    <button type="button" class="challenge-option" data-value="10k" data-tab-index="1" <?php if ($challenge == '10k')
                                        echo 'class="selected"'; ?>>10k</button>
                                    <button type="button" class="challenge-option" data-value="25k" data-tab-index="2" <?php if ($challenge == '25k')
                                        echo 'class="selected"'; ?>>25k</button>
                                    <button type="button" class="challenge-option" data-value="50k" data-tab-index="3" <?php if ($challenge == '50k')
                                        echo 'class="selected"'; ?>>50k</button>
                                    <button type="button" class="challenge-option" data-value="100k" data-tab-index="4" <?php if ($challenge == '100k')
                                        echo 'class="selected"'; ?>>100k</button>
                                    <button type="button" class="challenge-option" data-value="200k" data-tab-index="5" <?php if ($challenge == '200k')
                                        echo 'class="selected"'; ?>>200k</button>
                                </div>
                            </div>

                            <div id="account-type-selection" class="type-of-account">
                                <h5 class="sub-title">Type of Account</h5>
                                <ul>
                                    <li>
                                        <input id="standard-account" type="radio" class="input-radio" name="account_type"
                                            value="standard" <?php checked('standard', $account_type); ?> />
                                        <label for="standard-account" class="">Standard Account</label>
                                        <span class="hello-theme-pcs-label-tooltips" id="standard-tooltip" data-tippy-content="No Weekend Holding, No News Trading, Up to 100:1 Leverage.">
                                            <i aria-hidden="true" class="fas fa-info-circle"></i>
                                        </span>
                                    </li>
                                    <li>
                                        <input id="swing-account" type="radio" class="input-radio" name="account_type"
                                            value="swing" <?php checked('swing', $account_type); ?> />
                                        <label for="swing-account" class="">Swing Account</label>
                                        <span class="hello-theme-pcs-label-tooltips" id="swing-tooltip" data-tippy-content="Weekend Holding Allowed, News Trading Allowed, Up to 30:1 Leverage">
                                            <i aria-hidden="true" class="fas fa-info-circle"></i>
                                        </span>
                                    </li>
                                </ul>
                            </div>


                            <div id="addons-selection" class="addon">
                                <h5 class="sub-title">Addon</h5>
                                <ul>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="right box-shadow">
                    <div class="items-panel">
                        <div class="box-tabs-content">
                            <div data-tab-index="1" class="e-content e-active">
                                <div class="products">

                                    <!-- Product Image and Price -->
                                    <div id="product-display">
                                        <div class="product">
                                            <div id="product-image"></div>
                                        </div>

                                        <div class="description">
                                            <div id="product-title" class="sub-title"></div>
                                            <div id="product-description" class="detail-product"></div>
                                        </div>

                                        <div class="amount">
                                            <div class="amount-box">
                                                <div id="product-price"></div>
                                                <span class="note">VAT Included</span>
                                            </div>
                                        </div>

                                        <div class="box-btn">
                                            <a id="checkout-button" href="#" class="button price-btn">Continue</a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
add_shortcode('hello_challenge_selection', 'hello_theme_challenge_selection_shortcode');


function hello_theme_challenge_selection_get_product_id()
{
    global $wpdb;

    $category = sanitize_text_field($_POST['category']);
    $account_type = sanitize_text_field($_POST['account_type']);
    $challenge = sanitize_text_field($_POST['challenge']);
    $active_days = sanitize_text_field($_POST['active_days']);
    $profitsplit = sanitize_text_field($_POST['profitsplit']);
    $peak_active_days = sanitize_text_field($_POST['peak_active_days']);
    $tradingdays = sanitize_text_field($_POST['tradingdays']);

    $query = $wpdb->prepare(
        "SELECT product_id FROM {$wpdb->prefix}hello_theme_product_combinations 
        WHERE category = %s AND account_type = %s AND challenge = %s 
        AND addon_active_days = %s AND addon_profitsplit = %s AND addon_peak_active_days = %s AND addon_trading_days = %s",
        $category,
        $account_type,
        $challenge,
        $active_days,
        $profitsplit,
        $peak_active_days,
        $tradingdays
    );

    $product_id = $wpdb->get_var($query);

    if ($product_id) {
        // Get product details
        $product = wc_get_product($product_id);

        // Check if $product is valid
        if ($product) {
            $product_image_id = $product->get_image_id();
            // Check if product image exists, otherwise use placeholder image
            if ($product_image_id) {
                $product_image = wp_get_attachment_image_url($product_image_id, 'medium');
            } else {
                // Use WooCommerce placeholder image
                $product_image = wc_placeholder_img_src('medium');
            }
            $product_title = $product->get_name();
            $product_description = $product->get_description();
            $product_price = $product->get_price_html(); // Get product price in HTML format

            // Send response with product details
            wp_send_json_success(
                array(
                    'product_id' => $product_id,
                    'product_image' => $product_image,
                    'product_title' => $product_title,
                    'product_description' => $product_description,
                    'product_price' => $product_price
                )
            );
        } else {
            wp_send_json_error(array('message' => 'Product not found.'));
        }
    } else {
        wp_send_json_error(array('message' => 'No product found.'));
    }

    wp_die();
}
add_action('wp_ajax_get_custom_product_id', 'hello_theme_challenge_selection_get_product_id');
add_action('wp_ajax_nopriv_get_custom_product_id', 'hello_theme_challenge_selection_get_product_id');