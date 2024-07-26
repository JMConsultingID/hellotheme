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
            'header' => 'no',
            'tooltips' => 'yes',
            'account_price_text' => '',
        ),
        $atts,
        'ypf_pricing_table'
    );

    $category_product = $atts['category'];
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
    $tooltip_post_id = 28386;
    $acf_group_field = 'fyfx_pricing_table';
    $acf_tooltip_group_field = 'fyfx_pricing_table_tooltips';
    $spinner_url = get_stylesheet_directory_uri() . '/assets/img/spinner.svg';

    ob_start();
    ?>

    <!-- Mobile -->
    <?php if (wp_is_mobile()) : ?>
    <select id="product-select-<?php echo $category_product; ?>" class="pricing-table-select-option" onchange="updateProductDetails('<?php echo $category_product; ?>')">
        <?php foreach ($products as $product) : ?>
            <?php 
                $product_id = $product->ID;
                $regular_price = get_post_meta($product_id, '_regular_price', true);
                $sale_price = get_post_meta($product_id, '_sale_price', true);
                $price = $sale_price && $sale_price < $regular_price ? wc_price($sale_price) : wc_price($regular_price);
            ?>
            <option value="<?php echo $product_id; ?>"><?php echo get_the_title($product_id); ?> - <?php echo $price; ?></option>
        <?php endforeach; ?>
    </select>
    <?php endif; ?>
    <div class="hello-theme-pricing-plan pricing-table <?php echo $category_product; ?> <?php echo esc_attr($atts['style']); ?>">
        <?php if ($atts['header'] === 'yes') : ?>
        <div class="pricing-table-header">
            <h2><?php echo ucfirst($atts['category']); ?> Plans</h2>
        </div>
        <?php endif; ?>

        <!-- Mobile -->
        <?php if (wp_is_mobile()) : ?>
            <div class="pricing-table-content">            
                <div id="product-details-<?php echo $category_product; ?>" class="product-details-mobile">
                    <?php foreach ($products as $index => $product) : ?>
                        <?php 
                            $product_id = $product->ID;
                            $regular_price = get_post_meta($product_id, '_regular_price', true);
                            $sale_price = get_post_meta($product_id, '_sale_price', true);                    
                        ?>
                        <div class="product-detail <?php echo $category_product; ?>" id="product-detail-<?php echo $product_id; ?>" style="<?php echo $index === 0 ? '' : 'display:none;'; ?>">
                            <div class="pricing-table-row no-border mobile mobile-product-title-wrapper">
                                <div class="plan-name mobile product-id-<?php echo $product->ID; ?>"><?php echo get_the_title($product_id); ?></div>
                            </div>
                            <?php 
                            // Fetch ACF group field values and object
                            $group_field_object = get_field_object($acf_group_field, $product_id);
                            $tooltip_field_values = get_field($acf_tooltip_group_field, $tooltip_post_id);
                            if ($group_field_object && isset($group_field_object['sub_fields'])) {
                                foreach ($group_field_object['sub_fields'] as $sub_field) : 
                                    $sub_field_label = $sub_field['label'];
                                    $sub_field_name = $sub_field['name'];
                                    $tooltip = isset($tooltip_field_values[$sub_field_name]) ? $tooltip_field_values[$sub_field_name] : '';
                                    $field_value = get_field($acf_group_field . '_' . $sub_field_name, $product_id);
                                    ?>
                                    <div class="pricing-table-row top-border mobile mobile-acf-wrapper row-<?php echo esc_html($sub_field_name); ?>">
                                        <div class="plan-category mobile label-<?php echo esc_html($sub_field_name); ?>">
                                            <?php echo esc_html($sub_field_label); ?>
                                            <?php if ($atts['tooltips'] === 'yes' && !empty($tooltip)) : ?>
                                                <span class="pricing-table-label-tooltips" data-tippy-content="<?php echo esc_html($tooltip); ?>" style="float: right;">
                                                    <i aria-hidden="true" class="fas fa-info-circle"></i>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="plan-column mobile product-id-<?php echo $product->ID; ?>"><?php echo !empty($field_value) ? esc_html($field_value) : 'N/A'; ?></div>
                                    </div>
                                <?php endforeach;
                            }
                            ?>
                            <div class="pricing-table-row top-border mobile mobile-pricing-wrapper">
                            <div class="plan-category mobile">
                                Account Price 
                                <span class="plan-category-price-discount mobile" style="display: block;"><?php echo ucfirst($atts['account_price_text']); ?></span>
                            </div>
                            <div class="plan-column mobile">
                                <?php if ($sale_price && $sale_price < $regular_price) : ?>
                                    <?php echo wc_price($sale_price); ?>
                                    <span class="regular-price mobile" style="text-decoration: line-through;"><?php echo wc_price($regular_price); ?></span>
                                <?php else : ?>
                                    <?php echo wc_price($regular_price); ?>
                                <?php endif; ?>
                            </div>
                            </div>
                            <div class="pricing-table-row no-border mobile mobile-button-wrapper">
                                <div class="plan-button mobile"><a href="<?php echo site_url('/checkout/?add-to-cart=' . $product_id); ?>" class="button">Start Now</a></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>

        <!-- Desktop -->
        <div class="pricing-table-content">
            <div class="pricing-table-row header-row">
                <div class="plan-category">Plan Category</div>
                <?php foreach ($products as $product) : ?>
                    <div class="plan-column product-id-<?php echo $product->ID; ?>">
                        <div class="plan-name"><?php echo get_the_title($product->ID); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pricing-table-row top-border">
                <div class="plan-category">Account Price <span class="plan-category-price-discount" style="display: block;"><?php echo ucfirst($atts['account_price_text']); ?></span></div>
                <?php foreach ($products as $product) : 
                    $regular_price = get_post_meta($product->ID, '_regular_price', true);
                    $sale_price = get_post_meta($product->ID, '_sale_price', true);                    
                    ?>

                    <div class="plan-column product-id-<?php echo $product->ID; ?>">
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
            $tooltip_field_object = get_field_object($acf_tooltip_group_field, $products[0]->ID);
            $group_field_values = get_field($acf_group_field, $products[0]->ID);
            $tooltip_field_values = get_field($acf_tooltip_group_field, $tooltip_post_id);

            // Loop through the ACF fields dynamically
            if ($group_field_object && isset($group_field_object['sub_fields'])) {
                foreach ($group_field_object['sub_fields'] as $sub_field) : 
                    $sub_field_label = $sub_field['label'];
                    $sub_field_name = $sub_field['name'];
                    $tooltip = isset($tooltip_field_values[$sub_field_name]) ? $tooltip_field_values[$sub_field_name] : '';
                    ?>
                    <div class="pricing-table-row top-border row-<?php echo esc_html($sub_field_name); ?>">
                        <div class="plan-category label-<?php echo esc_html($sub_field_name); ?>">
                            <?php echo esc_html($sub_field_label); ?>
                            <?php if ($atts['tooltips'] === 'yes' & !empty($tooltip)) : ?>
                                <span class="pricing-table-label-tooltips" data-tippy-content="<?php echo esc_html($tooltip); ?>" style="float: right;">
                                    <i aria-hidden="true" class="fas fa-info-circle"></i>
                                </span>
                            <?php endif; ?>
                        </div>
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
    <?php endif; ?>
    </div>
    <script>
        function updateProductDetails(category) {
            const select = document.getElementById('product-select-' + category);
            const selectedProduct = select.value;
            document.querySelectorAll('.product-detail.' + category).forEach(detail => {
                detail.style.display = 'none';
            });
            document.getElementById('product-detail-' + selectedProduct).style.display = 'block';
        }
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('ypf_pricing_table', 'hello_pricing_table_multi_product_shortcode');

function hello_scalling_table_single_product_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'mode' => 'single_product',
            'category' => 'origin',
            'product_id' => '7132',
            'style' => 'style1',
        ),
        $atts,
        'ypf_scalling_table'
    );

    if (empty($atts['category'])) {
        return '<p>No category specified.</p>';
    }

    if (empty($atts['product_id'])) {
        return '<p>No product specified.</p>';
    }

    $product_id = $atts['product_id'];
    $category = $atts['category'];

    // Fetch products by category
    $products = get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'product_cat' => $category
    ));

    // ACF field group names for each level
    $acf_levels = array(
        'level_1' => 'fyfx_scalling_plan_level_1',
        'level_2' => 'fyfx_scalling_plan_level_2',
        'level_3' => 'fyfx_scalling_plan_level_3',
        'level_4' => 'fyfx_scalling_plan_level_4',
        'level_5' => 'fyfx_scalling_plan_level_5',
        'level_6' => 'fyfx_scalling_plan_level_6',
    );

    // Fetch tooltip values
    $tooltip_post_id = 28386;
    $acf_tooltip_group_field = 'fyfx_scalling_plan_tooltips';
    $tooltip_field_values = get_field($acf_tooltip_group_field, $tooltip_post_id);

    // Get a sample field object to get the labels dynamically
    $sample_field_group = $acf_levels['level_1'];
    $sample_fields = get_field($sample_field_group, $product_id);

    ob_start();

    // Mobile version
    if (wp_is_mobile()) : ?>

    <div class="hello-theme-hello-theme-scalling-plan-select">
        <select id="product-select-<?php echo $category; ?>" class="pricing-table-select-option" onchange="updateProductDetailsMobile('<?php echo $category; ?>')">
            <?php foreach ($products as $product) : 
                $product_id = $product->ID;
                $regular_price = get_post_meta($product_id, '_regular_price', true);
                $sale_price = get_post_meta($product_id, '_sale_price', true);
                $price = $sale_price && $sale_price < $regular_price ? wc_price($sale_price) : wc_price($regular_price);
            ?>
                <option value="<?php echo $product_id; ?>"><?php echo get_the_title($product_id); ?> - <?php echo $price; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id="product-details-<?php echo $category; ?>" class="product-details-mobile">
        <?php foreach ($products as $product) : ?>
            <?php 
                $product_id = $product->ID;
            ?>
            <div class="product-detail <?php echo $category; ?>" id="product-detail-<?php echo $product_id; ?>" style="display: none;">
                <div class="hello-theme-scalling-plan-mobile scaling-plan-table <?php echo esc_attr($atts['style']); ?>">
                <div class="scaling-category-group pt__title">
                    <div class="scaling-category header-row">&nbsp;</div>
                    <?php foreach ($sample_fields as $field_key => $field_value) : 
                        $field_object = get_field_object($sample_field_group . '_' . $field_key, $product_id);
                        if ($field_object) :
                            $field_label = $field_object['label'];
                    ?>
                        <div class="scalling-category">
                            <?php echo $field_label; ?>
                            <?php if (!empty($tooltip_field_values[$field_key])) : ?>
                                <span class="scalling-table-label-tooltips" data-tippy-content="<?php echo esc_html($tooltip_field_values[$field_key]); ?>">
                                    <i aria-hidden="true" class="fas fa-info-circle"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
                <div class="scaling-value-group pt__option swiper-container" id="swiper-<?php echo $product_id; ?>">
                    <div class="swiper-wrapper">
                        <?php foreach ($acf_levels as $level_key => $level_value) : 
                            $level_fields = get_field($level_value, $product_id);
                        ?>
                            <div class="swiper-slide">
                                <div class="scaling-column header-row"><?php echo ucfirst(str_replace('_', ' ', $level_key)); ?>
                                <?php if (in_array($level_key, ['level_4', 'level_5', 'level_6'])) : ?>
                                    <span class="refund-of-fees">Refund of Fees</span>
                                <?php endif; ?>
                                </div>
                                <?php foreach ($level_fields as $field_key => $field_value) : ?>
                                    <div class="scaling-column"><?php echo !empty($field_value) ? esc_html($field_value) : 'N/A'; ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        function updateProductDetailsMobile(category) {
            const select = document.getElementById('product-select-' + category);
            const selectedProduct = select.value;
            document.querySelectorAll('.product-detail.' + category).forEach(detail => {
                detail.style.display = 'none';
            });
            const productDetail = document.getElementById('product-detail-' + selectedProduct);
            if (productDetail) {
                productDetail.style.display = 'block';
                // Initialize swiper for the selected product
                new Swiper('#swiper-' + selectedProduct, {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    allowTouchMove: false,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    }
                });
            } else {
                console.error('Selected product detail not found for ID:', selectedProduct);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Trigger update for the initially selected product
            const initialSelect = document.getElementById('product-select-<?php echo $category; ?>');
            if (initialSelect) {
                updateProductDetailsMobile('<?php echo $category; ?>');
            }
        });
    </script>

    <?php else : ?>
    <!-- Desktop -->
    <div class="hello-theme-scalling-plan scalling-table <?php echo esc_attr($atts['style']); ?> product_id-<?php echo $product_id; ?>">
        <div class="scalling-table-content">
            <div class="scalling-table-row header-row">
                <div class="scalling-category">Scaling Level</div>
                <?php foreach ($acf_levels as $level_key => $level_value) : ?>
                    <div class="scalling-column <?php echo $level_value; ?>"><?php echo ucfirst(str_replace('_', ' ', $level_key)); ?></div>
                <?php endforeach; ?>
            </div>
            <?php foreach ($sample_fields as $field_key => $field_value) : 
                $field_object = get_field_object($sample_field_group . '_' . $field_key, $product_id);
                if ($field_object) :
                    $field_label = $field_object['label'];
                    ?>
                    <div class="scalling-table-row top-border product_id-<?php echo $product_id; ?>">
                        <div class="scalling-category">
                            <?php echo $field_label; ?>
                            <?php if (!empty($tooltip_field_values[$field_key])) : ?>
                                <span class="scalling-table-label-tooltips" data-tippy-content="<?php echo esc_html($tooltip_field_values[$field_key]); ?>">
                                    <i aria-hidden="true" class="fas fa-info-circle"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php foreach ($acf_levels as $level_key => $level_value) : 
                            $field_value = get_field($level_value . '_' . $field_key, $product_id);
                        ?>
                            <div class="scalling-column <?php echo $level_value; ?>"><?php echo !empty($field_value) ? esc_html($field_value) : 'N/A'; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            tippy(".scalling-table-label-tooltips", {
                placement: 'right-end'
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('ypf_scalling_table', 'hello_scalling_table_single_product_shortcode');

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