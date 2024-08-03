<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
function hello_pricing_table_level_2_shortcode() {
     // Get all product categories
    $categories = get_terms('product_cat');
    ob_start();
    ?>
    <div class="hello-theme-container hello-theme-table-pricing hello-theme-with-tab">
        <div class="hello-theme-tab-buttons">
            <?php foreach ($categories as $index => $category): ?>
                <div class="hello-theme-tab-button <?php echo $index == 0 ? 'active' : ''; ?>" data-tab-id="tab-<?php echo $category->term_id; ?>">
                    <?php echo $category->name; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php foreach ($categories as $index => $category): ?>
            <div id="tab-<?php echo $category->term_id; ?>" class="hello-theme-tab-content <?php echo $index == 0 ? 'active' : ''; ?>" data-tab-id="tab-<?php echo $category->term_id; ?>">
                <?php
                $products = wc_get_products(array(
                    'category' => array($category->slug),
                    'status' => 'publish'
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
                        <div id="subtab-<?php echo $product->get_id(); ?>" class="hello-theme-sub-tab-content <?php echo $productIndex == 0 ? 'active' : ''; ?>" data-sub-tab-id="subtab-<?php echo $product->get_id(); ?>">

                            <?php
                                $product_id = $product->get_id();
                                $product_price = wc_price($product->get_price()); // Get product price with currency symbol
                                $checkout_url = "/checkout/?add-to-cart={$product_id}"; // Generate checkout URL

                                // ACF field group name
                                $tooltip_post_id = 16787;
                                $acf_group_field = 'hello_pricing_plans';
                                $acf_tooltip_group_field = 'hello_pricing_plan_tooltips';

                                $regular_price = get_post_meta($product_id, '_regular_price', true);
                                $sale_price = get_post_meta($product_id, '_sale_price', true);
                            ?>

                            <div class="pricing__table hello-theme-product-id">
                                <div class="pt__title">
                                    <div class="pt__title__wrap">

                                        <?php
                                        // Fetch ACF group field values and object
                                        $group_field_object = get_field_object($acf_group_field, $product_id);
                                        $tooltip_field_values = get_field($acf_tooltip_group_field, $tooltip_post_id);
                                        // Loop through the ACF fields dynamically
                                        if ($group_field_object && isset($group_field_object['sub_fields'])) :
                                            foreach ($group_field_object['sub_fields'] as $sub_field) : 
                                                $sub_field_label = $sub_field['label'];
                                                $sub_field_name = $sub_field['name'];
                                                $tooltip = isset($tooltip_field_values[$sub_field_name]) ? $tooltip_field_values[$sub_field_name] : '';?>
                                                <div class="hello-theme-pricing-table-row pt__row label-<?php echo esc_html($sub_field_name); ?>">
                                                    <?php echo esc_html($sub_field_label); ?>
                                                    <?php if ($atts['tooltips'] === 'yes' & !empty($tooltip)) : ?>
                                                        <span class="hello-theme-label-tooltips" data-tippy-content="<?php echo esc_html($tooltip); ?>" style="float: right;">
                                                            <i aria-hidden="true" class="fas fa-info-circle"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>

                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="pt__option">
                                </div>
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