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
    if ( get_option( 'hello_theme_enable_table_pricing' ) === '1' ) {
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
                    $products = wc_get_products(array('category' => array($category->slug)));
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
                                <?php echo render_product_pricing_table($product); ?>
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
}
add_shortcode( 'hello_pricing_table_level_2', 'hello_pricing_table_level_2_shortcode' );
