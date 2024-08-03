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
                        <div id="subtab-<?php echo $product->get_id(); ?>" class="hello-theme-sub-tab-content pricing__table hello-theme-product-id <?php echo $productIndex == 0 ? 'active' : ''; ?>" data-sub-tab-id="subtab-<?php echo $product->get_id(); ?>">

                            <?php
                                $product_id = $product->get_id();
                                $product_price = wc_price($product->get_price()); // Get product price with currency symbol
                                $checkout_url = "/checkout/?add-to-cart={$product_id}"; // Generate checkout URL

                                // ACF field group name
                                $tooltip_post_id = 28386;
                                $acf_group_field = 'fyfx_pricing_table';
                                $acf_tooltip_group_field = 'fyfx_pricing_table_tooltips';

                                $regular_price = get_post_meta($product_id, '_regular_price', true);
                                $sale_price = get_post_meta($product_id, '_sale_price', true);
                            ?>

                              <div class='pt__title'>
                                <div class='pt__title__wrap'>
                                  <div class='pt__row'><?php $product->get_name() ?></div>
                                  <div class='pt__row'>Monthly Email Sends</div>
                                  <div class='pt__row'>Users</div>
                                  <div class='pt__row'>Audiences</div>
                                  <div class='pt__row'>24/7 Email & Chat Support</div>
                                  <div class='pt__row'>Pre-built Email Templates</div>
                                  <div class='pt__row'>300+ Integrations</div>
                                  <div class='pt__row'>Reporting & Analytics</div>
                                  <div class='pt__row'>Forms & Landing Pages</div>
                                  <div class='pt__row'>Creative Assistant</div>
                                </div>
                              </div>

                            <div class="pt__option">
                                <?php hello_theme_display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight'); ?>
                                <div class='pt__option__slider swiper' id='pricingTableSlider'>
                                  <div class='swiper-wrapper'>
                                    <div class='swiper-slide pt__option__item'>
                                      <div class='pt__item'>
                                        <div class='pt__item__wrap'>
                                          <div class='pt__row'>Origin Funded Stater</div>
                                          <div class='pt__row'>150,000</div>
                                          <div class='pt__row'>Unlimited</div>
                                          <div class='pt__row'>Unlimited</div>
                                          <div class='pt__row'>Phone & Priority Support</div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class='swiper-slide pt__option__item'>
                                      <div class='pt__item'>
                                        <div class='pt__item__wrap'>
                                          <div class='pt__row'>Origin Funded Standard</div>
                                          <div class='pt__row'>16,000</div>
                                          <div class='pt__row'>5 Seats</div>
                                          <div class='pt__row'>5 Audiences</div>
                                          <div class='pt__row'>24/7 Email & Chat Support</div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class='swiper-slide pt__option__item'>
                                      <div class='pt__item'>
                                        <div class='pt__item__wrap'>
                                          <div class='pt__row'>Origin Funded Profesional</div>
                                          <div class='pt__row'>5,000</div>
                                          <div class='pt__row'>3 Seats</div>
                                          <div class='pt__row'>3 Audiences</div>
                                          <div class='pt__row'>24/7 Email & Chat Support</div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'>Limited</div>
                                          <div class='pt__row'><i class='fa-solid fa-check'></i></div>
                                          <div class='pt__row'>Limited</div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
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