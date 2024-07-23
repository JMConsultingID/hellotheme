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
    <div class="hello-theme-pricing-plan pricing-table <?php echo esc_attr($atts['style']); ?>">
        <div class="pricing-table-header">
            <h2><?php echo ucfirst($atts['category']); ?> Plans</h2>
        </div>
        <div class="pricing-table-content">
            <div class="pricing-table-row header-row">
                <div class="plan-category">Plan Category</div>
                <?php foreach ($products as $product) : ?>
                    <div class="plan-column product-id-<?php echo $product->ID; ?>">
                        <div class="plan-name"><?php echo get_the_title($product->ID); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pricing-table-row">
                <div class="plan-category">Account Price</div>
                <?php foreach ($products as $product) : 
                    $regular_price = get_post_meta($product->ID, '_regular_price', true);
                    $sale_price = get_post_meta($product->ID, '_sale_price', true);                    
                    ?>

                    <div class="plan-column">
                        <?php if ($sale_price && $sale_price < $regular_price) : ?>
                            <div class="plan-price">
                                <?php echo wc_price($sale_price); ?>
                                <span class="regular-price" style="text-decoration: line-through;"><?php echo wc_price($regular_price); ?></span>                           
                            </div>
                        <?php else : ?>
                            <div class="plan-price"><?php echo wc_price($regular_price); ?></div>
                        <?php endif; ?>
                        <div class="plan-button"><a href="<?php echo site_url('/checkout/?add-to-cart=' . $product->ID); ?>" class="button">Start Now</a></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php 
            // Fetch ACF group field values and object
            $group_field_object = get_field_object($acf_group_field, $products[0]->ID);
            $group_field_values = get_field($acf_group_field, $products[0]->ID);

            // Loop through the ACF fields dynamically
            if ($group_field_object && isset($group_field_object['sub_fields'])) {
                foreach ($group_field_object['sub_fields'] as $sub_field) : 
                    $sub_field_label = $sub_field['label'];
                    $sub_field_name = $sub_field['name'];
                    ?>
                    <div class="pricing-table-row">
                        <div class="plan-category"><?php echo esc_html($sub_field_label); ?></div>
                        <?php 
                            foreach ($products as $product) :
                                $field_value = get_field($acf_group_field . '_' . $sub_field_name, $product->ID);
                                echo '<div class="plan-column product-id-'.$product->ID.'">' . (!empty($field_value) ? esc_html($field_value) : 'N/A') . '</div>';
                            endforeach;
                        ?>
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