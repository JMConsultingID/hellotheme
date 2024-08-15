<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
function hello_pricing_table_level_2_shortcode($atts) {
    $enabled_pricing_table = get_option('hello_theme_enable_table_pricing');
    $atts = shortcode_atts(
        array(
            'tab_mode' => 'level-2',
            'category' => '1-phase-challenge',
            'category_active' => '1-phase-challenge',
            'html_value' => 'yes',
            'logo_url' => '',
            'tooltips' => 'yes',
            'tooltips_post_id' => '16787',
        ),
        $atts,
        'hello_pricing_table_level_2'
    );

    if ($enabled_pricing_table !== '1') {
        return;
    }

    $tab_mode = $atts['tab_mode'];
    $tooltips = $atts['tooltips'];
    $tooltips_post_id = $atts['tooltips_post_id'];

    // Parse the categories from the shortcode attribute
    $category_slugs = explode(',', $atts['category']);
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'slug' => $category_slugs,
        'hide_empty' => false,
    ));

    $html_value = $atts['html_value'];

    ob_start();
    ?>
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

                            <?php
                                $product_id = $product->get_id();
                                $product_price = wc_price($product->get_price()); // Get product price with currency symbol
                                $checkout_url = "/checkout/?add-to-cart={$product_id}"; // Generate checkout URL

                                // ACF field group names for each level
                                $acf_levels = array(
                                    'level_1' => 'hello_pricing_plan_step_1',
                                    'level_2' => 'hello_pricing_plan_step_2',
                                    'level_3' => 'hello_pricing_plan_step_3',
                                );

                                // Fetch tooltip values
                                $tooltip_post_id = $tooltips_post_id;
                                $acf_tooltip_group_field = 'hello_pricing_plan_tooltips';
                                $tooltip_field_values = get_field($acf_tooltip_group_field, $tooltip_post_id);

                                // Get a sample field object to get the labels dynamically
                                $sample_field_group = $acf_levels['level_1'];
                                $sample_fields = get_field($sample_field_group, $product_id);
                            ?>

                            <div class="pricing__table hello-theme-product product-id-<?php echo $product_id; ?>">
                                <div class="pt__title">
                                    <div class="pt__title__wrap">

                                        <?php 
                                            if (!is_null($sample_fields) && is_array($sample_fields)) :
                                                $is_first_label = true;
                                                foreach ($sample_fields as $field_key => $field_value) : 
                                                $field_object = get_field_object($sample_field_group . '_' . $field_key, $product_id);
                                                if ($field_object) :
                                                    $field_label = $field_object['label'];?>
                                                       <div class="hello-theme-pricing-table-row pt__row label-<?php echo esc_html($field_key); ?>">
                                                    <?php echo $field_label; ?>
                                                    <?php 
                                                        if ($is_first_label && !empty($atts['logo_url'])) {
                                                            echo '<img src="' . esc_url($atts['logo_url']) . '" width="172" alt="' . esc_attr(get_bloginfo('name')) . '">';
                                                        } else {
                                                            echo esc_html($field_label);
                                                        }
                                                    ?>
                                                    <?php if ($tooltips === 'yes' && !empty($tooltip_field_values[$field_key])) : ?>
                                                        <span class="hello-theme-label-tooltips" data-tippy-content="<?php echo esc_html($tooltip_field_values[$field_key]); ?>">
                                                            <i aria-hidden="true" class="fas fa-info-circle"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php 
                                                $is_first_label = false; // Ensure that only the first label is replaced with the logo
                                                endif;
                                                endforeach;
                                            endif; 
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="hello-theme-pricing-table-row pt__option">

                                    <?php hello_theme_display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight'); ?>

                                    <div class="hello-theme-pricing-table-option pt__option__slider swiper" id="pricingTableSlider">
                                      <div class="swiper-wrapper">

                                        <?php foreach ($acf_levels as $level_key => $level_value) : 
                                            $level_fields = get_field($level_value, $product_id);
                                            $has_value = false;

                                            if (!is_null($level_fields) && is_array($level_fields)) {
                                                // Check if at least one field has a value
                                                foreach ($level_fields as $field_key => $field_value) {
                                                    if (!empty($field_value)) {
                                                        $has_value = true;
                                                        break;
                                                    }
                                                }
                                            }

                                            // Only render the div if there is at least one non-empty field
                                            if ($has_value) : ?>
                                            <div class="swiper-slide slide-product-id-<?php echo $product_id; ?> pt__option__item <?php echo esc_html($level_value); ?>">
                                                <div class="pt__item">
                                                    <div class="pt__item__wrap">
                                                        <?php
                                                        if (!is_null($level_fields) && is_array($level_fields)) :
                                                            foreach ($level_fields as $field_key => $field_value) : ?>
                                                            <div class="pt__row <?php echo esc_html($field_key); ?>">
                                                                <?php
                                                                $table_field_value = ($atts['html_value'] === 'yes') ? $field_value : esc_html($field_value);
                                                                    echo !empty($table_field_value) ? $table_field_value : 'N/A';
                                                                ?>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                           <?php endif; ?>
                                        <?php endforeach; ?>

                                      </div>
                                    </div>
                                    
                                  </div>

                            </div>
                            <div class="hello-theme-checkout-button">
                                <a href="<?php echo $checkout_url; ?>">Purchase Now (<?php echo $product_price;?>)</a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found in this category.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'hello_pricing_table_level_2', 'hello_pricing_table_level_2_shortcode' );