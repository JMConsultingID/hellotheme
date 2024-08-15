<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

function hello_pricing_table_level_1_shortcode($atts) {
    $enabled_pricing_table = get_option('hello_theme_enable_table_pricing');
    $atts = shortcode_atts(
        array(
            'tab_mode' => 'level-1',
            'category' => '1-phase-challenge',
            'html_value' => 'yes',
            'logo_url' => '',
            'tooltips' => 'yes',
            'tooltips_post_id' => '16787',
        ),
        $atts,
        'hello_pricing_table_level_1'
    );

    if ($enabled_pricing_table !== '1') {
        return;
    }
    
    $tab_mode = $atts['tab_mode'];
    $category_product = $atts['category'];
    $tooltips = $atts['tooltips'];
    $tooltips_post_id = $atts['tooltips_post_id'];

    // Parse the categories from the shortcode attribute
    $category_slugs = array_map('trim', explode(',', $atts['category']));
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'slug' => $category_slugs,
        'hide_empty' => false,
    ));

    // Extract slugs from category objects
    $category_slugs = wp_list_pluck($categories, 'slug');
    $category_slugs_string = implode(' ', $category_slugs); // Convert array to string

    // Fetch products from these categories
    $products = wc_get_products(array(
        'category' => $category_slugs,
        'status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));

    $html_value = $atts['html_value'];


    ob_start();
    ?>
    <div class="hello-theme-container hello-theme-table-pricing hello-theme-with-tab hello-theme-table-<?php echo $tab_mode; ?> category-<?php echo esc_attr($category_slugs_string); ?>">
                <?php
                if ($products): ?>
                    <div class="hello-theme-tab-buttons">
                        <?php foreach ($products as $productIndex => $product): ?>
                            <div class="hello-theme-tab-button <?php echo $productIndex == 0 ? 'active' : ''; ?>" data-tab-id="tab-<?php echo $product->get_id(); ?>">
                                <?php echo $product->get_name(); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php foreach ($products as $productIndex => $product): ?>
                        <div id="tab-<?php echo $product->get_id(); ?>" class="hello-theme-tab-content product-<?php echo $product->get_slug(); ?> <?php echo $productIndex == 0 ? 'active' : ''; ?>" data-tab-id="tab-<?php echo $product->get_id(); ?>">

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
                            <div class="pricing__table-wraping product-id-<?php echo $product_id; ?>">
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
                            </div>                            
                        </div>
                        <div class="hello-theme-checkout-button">
                            <a href="<?php echo $checkout_url; ?>">Purchase Now (<?php echo $product_price;?>)</a>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found in this category.</p>
                <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'hello_pricing_table_level_1', 'hello_pricing_table_level_1_shortcode' );


function hello_pricing_table_sample_level_1_shortcode() {
    if ( get_option( 'hello_theme_enable_table_pricing' ) === '1' ) {
        ob_start();
        ?>
        <div class="hello-theme-container hello-theme-table-pricing hello-theme-with-tab">

        <div class="hello-theme-tab-buttons">
            <div class="hello-theme-tab-button active" data-tab-id="tab1">Origin Funded</div>
            <div class="hello-theme-tab-button" data-tab-id="tab2">Evaluation Funded</div>
            <div class="hello-theme-tab-button" data-tab-id="tab3">Plus Funded</div>
        </div>

        <div id="tab1" class="hello-theme-tab-content active" data-tab-id="tab1">
        <div class="pricing__table hello-theme-product-id">
          <div class="pt__title">
            <div class="pt__title__wrap">
              <div class="pt__row"></div>
              <div class="pt__row">Monthly Email Sends</div>
              <div class="pt__row">Users</div>
              <div class="pt__row">Audiences</div>
              <div class="pt__row">24/7 Email & Chat Support</div>
              <div class="pt__row">Pre-built Email Templates</div>
              <div class="pt__row">300+ Integrations</div>
              <div class="pt__row">Reporting & Analytics</div>
              <div class="pt__row">Forms & Landing Pages</div>
              <div class="pt__row">Creative Assistant</div>
            </div>
          </div>
          <div class="pt__option">

            <?php hello_theme_display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight'); ?>

            <div class="pt__option__slider swiper" id="pricingTableSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item recommend">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Origin Funded Stater</div>
                      <div class="pt__row">150,000</div>
                      <div class="pt__row">Unlimited</div>
                      <div class="pt__row">Unlimited</div>
                      <div class="pt__row">Phone & Priority Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Origin Funded Standard</div>
                      <div class="pt__row">16,000</div>
                      <div class="pt__row">5 Seats</div>
                      <div class="pt__row">5 Audiences</div>
                      <div class="pt__row">24/7 Email & Chat Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Origin Funded Profesional</div>
                      <div class="pt__row">5,000</div>
                      <div class="pt__row">3 Seats</div>
                      <div class="pt__row">3 Audiences</div>
                      <div class="pt__row">24/7 Email & Chat Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>

        <div id="tab2" class="hello-theme-tab-content active" data-tab-id="tab2">
        <div class="pricing__table hello-theme-product-id">
          <div class="pt__title">
            <div class="pt__title__wrap">
              <div class="pt__row"></div>
              <div class="pt__row">Monthly Email Sends</div>
              <div class="pt__row">Users</div>
              <div class="pt__row">Audiences</div>
              <div class="pt__row">24/7 Email & Chat Support</div>
              <div class="pt__row">Pre-built Email Templates</div>
              <div class="pt__row">300+ Integrations</div>
              <div class="pt__row">Reporting & Analytics</div>
              <div class="pt__row">Forms & Landing Pages</div>
              <div class="pt__row">Creative Assistant</div>
            </div>
          </div>
          <div class="pt__option">

            <?php hello_theme_display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight'); ?>

            <div class="pt__option__slider swiper" id="pricingTableSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item recommend">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Evaluation Funded Stater</div>
                      <div class="pt__row">150,000</div>
                      <div class="pt__row">Unlimited</div>
                      <div class="pt__row">Unlimited</div>
                      <div class="pt__row">Phone & Priority Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Evaluation Funded Standard</div>
                      <div class="pt__row">16,000</div>
                      <div class="pt__row">5 Seats</div>
                      <div class="pt__row">5 Audiences</div>
                      <div class="pt__row">24/7 Email & Chat Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Evaluation Funded Profesional</div>
                      <div class="pt__row">5,000</div>
                      <div class="pt__row">3 Seats</div>
                      <div class="pt__row">3 Audiences</div>
                      <div class="pt__row">24/7 Email & Chat Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>

        <div id="tab3" class="hello-theme-tab-content active" data-tab-id="tab3">
        <div class="pricing__table hello-theme-product-id">
          <div class="pt__title">
            <div class="pt__title__wrap">
              <div class="pt__row"></div>
              <div class="pt__row">Monthly Email Sends</div>
              <div class="pt__row">Users</div>
              <div class="pt__row">Audiences</div>
              <div class="pt__row">24/7 Email & Chat Support</div>
              <div class="pt__row">Pre-built Email Templates</div>
              <div class="pt__row">300+ Integrations</div>
              <div class="pt__row">Reporting & Analytics</div>
              <div class="pt__row">Forms & Landing Pages</div>
              <div class="pt__row">Creative Assistant</div>
            </div>
          </div>
          <div class="pt__option">

            <?php hello_theme_display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight'); ?>

            <div class="pt__option__slider swiper" id="pricingTableSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item recommend">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Plus Funded Stater</div>
                      <div class="pt__row">150,000</div>
                      <div class="pt__row">Unlimited</div>
                      <div class="pt__row">Unlimited</div>
                      <div class="pt__row">Phone & Priority Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Plus Funded Standard</div>
                      <div class="pt__row">16,000</div>
                      <div class="pt__row">5 Seats</div>
                      <div class="pt__row">5 Audiences</div>
                      <div class="pt__row">24/7 Email & Chat Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Plus Funded Profesional</div>
                      <div class="pt__row">5,000</div>
                      <div class="pt__row">3 Seats</div>
                      <div class="pt__row">3 Audiences</div>
                      <div class="pt__row">24/7 Email & Chat Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Plus Funded Plus Plus</div>
                      <div class="pt__row">5,000</div>
                      <div class="pt__row">3 Seats</div>
                      <div class="pt__row">3 Audiences</div>
                      <div class="pt__row">24/7 Email & Chat Support</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row"><i class="fa-solid fa-check"></i></div>
                      <div class="pt__row">Limited</div>
                      <div class="pt__row">
                        <a href="">Purchase Now</a>
                      </div>
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
    } else {
        return '<p>Table pricing is not enabled.</p>';
    }
}
add_shortcode( 'hello_pricing_table_sample_level_1', 'hello_pricing_table_sample_level_1_shortcode' );

