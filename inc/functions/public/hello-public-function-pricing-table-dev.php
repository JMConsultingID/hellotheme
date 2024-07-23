<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

function hello_pricing_table_multi_product_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'mode' => 'multi_product',
            'category' => 'origin',
            'style' => 'style1',
        ),
        $atts,
        'ypf_pricing_table'
    );

    // Fetch products by category
    $products = get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'product_cat' => $atts['category']
    ));

    if (empty($products)) {
        return '<p>No products found.</p>';
    }

    // ACF field group name
    $acf_group_field = 'fyfx_pricing_table';

    ob_start();
    ?>
    <div class="pricing-table <?php echo esc_attr($atts['style']); ?>">
        <div class="pricing-table-header">
            <h2><?php echo ucfirst($atts['category']); ?> Plans</h2>
        </div>
        <div class="pricing-table-content">
            <div class="pricing-table-row header-row">
                <div class="plan-category">Plan Category</div>
                <?php foreach ($products as $product) : ?>
                    <div class="plan-column">
                        <div class="plan-name"><?php echo get_the_title($product->ID); ?></div>
                        <div class="plan-price"><?php echo wc_price(get_post_meta($product->ID, '_price', true)); ?></div>
                        <div class="plan-button"><a href="<?php echo site_url('/checkout/?add-to-cart=' . $product->ID); ?>" class="button">Start Now</a></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php 
            // Get the field group
            $group_field = get_field($acf_group_field, $products[0]->ID);

            // Loop through the ACF fields dynamically
            if ($group_field) {
                foreach ($group_field as $field_key => $field_value) : ?>
                    <div class="pricing-table-row">
                        <div class="plan-category"><?php echo esc_html(get_field_object($acf_group_field . '_' . $field_key)['label']); ?></div>
                        <?php foreach ($products as $product) : ?>
                            <div class="plan-column"><?php echo get_field($acf_group_field . '_' . $field_key, $product->ID); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach;
            }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ypf_pricing_table', 'hello_pricing_table_multi_product_shortcode');



function hello_pricing_table_dev_shortcode() {
    if ( get_option( 'hello_theme_enable_table_pricing' ) == '1' ) {
        ob_start();
        ?>
        <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th>Feature</th>
                    <th>Basic</th>
                    <th>Standard</th>
                    <th>Premium</th>
                </tr>
            </thead>
            <tbody>
                <?php for ( $i = 1; $i <= 9; $i++ ) : ?>
                    <tr>
                        <td>Feature <?php echo $i; ?></td>
                        <td>Basic Feature <?php echo $i; ?></td>
                        <td>Standard Feature <?php echo $i; ?></td>
                        <td>Premium Feature <?php echo $i; ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    } else {
        return '<p>Table pricing is not enabled.</p>';
    }
}
add_shortcode( 'hello_pricing_table_dev', 'hello_pricing_table_dev_shortcode' );