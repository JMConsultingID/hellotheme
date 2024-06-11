<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
//Theme Activation
function hello_theme_display_swiper_navigation_buttons($left_button_id, $right_button_id) {
    ?>
    <div class="pt__option__mobile__nav">
        <a id="<?php echo esc_attr($left_button_id); ?>" href="#" class="mobile__nav__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <a id="<?php echo esc_attr($right_button_id); ?>" href="#" class="mobile__nav__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <?php
}

function render_pricing_table($product) {
    ob_start();
    hello_theme_display_swiper_navigation_buttons('navBtnLeft', 'navBtnRight');
    $navigationButtons = ob_get_clean();
    $product_id = $product->get_id();
    $product_price = wc_price($product->get_price()); // Get product price with currency symbol
    $checkout_url = "/checkout/?add-to-cart={$product_id}"; // Generate checkout URL

    return "<div class='pricing__table hello-theme-product-id'>
          <div class='pt__title'>
            <div class='pt__title__wrap'>
              <div class='pt__row'>{$product->get_name()}</div>
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
          <div class='pt__option'>

            {$navigationButtons}

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
        <div class='hello-theme-checkout-button'>
            <a href='{$checkout_url}'>Purchase Now ({$product_price})</a>
        </div>";
}

function render_product_pricing_table($product) {
    // Adjust this function to display the pricing table content for each product.
    $content = "
    <div class='pricing__table hello-theme-product-id'>
        <div class='pt__title'>
            <div class='pt__title__wrap'>
                <div class='pt__row'>{$product->get_name()}</div>
                <div class='pt__row'>Monthly Email Sends</div>
                <div class='pt__row'>Users</div>
                <div class='pt__row'>Audiences</div>
            </div>
        </div>
        <div class='pt__option'>
            <div class='pt__option__mobile__nav'>
                <a class='mobile__nav__btn'>
                    <svg viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M22.1538 11.9819H1.81972' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/>
                        <path d='M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/>
                    </svg>
                </a>
                <a class='mobile__nav__btn'>
                    <svg viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M1.81934 11.9819H22.1534' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/>
                        <path d='M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/>
                    </svg>
                </a>
            </div>
            <div class='pt__option__slider swiper'>
                <div class='swiper-wrapper'>
                    <div class='swiper-slide pt__option__item'>
                        <div class='pt__item recommend'>
                            <div class='pt__item__wrap'>
                                <div class='pt__row'>Premium</div>
                                <div class='pt__row'>150,000</div>
                                <div class='pt__row'>Unlimited</div>
                                <div class='pt__row'>Unlimited</div>
                                <div class='pt__row'>
                                    <a href='{$product->get_permalink()}'>Purchase Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='swiper-slide pt__option__item'>
                        <div class='pt__item'>
                            <div class='pt__item__wrap'>
                                <div class='pt__row'>Standard</div>
                                <div class='pt__row'>16,000</div>
                                <div class='pt__row'>5 Seats</div>
                                <div class='pt__row'>Unlimited</div>
                                <div class='pt__row'>
                                    <a href='{$product->get_permalink()}'>Purchase Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='swiper-slide pt__option__item'>
                        <div class='pt__item'>
                            <div class='pt__item__wrap'>
                                <div class='pt__row'>Essentials</div>
                                <div class='pt__row'>5,000</div>
                                <div class='pt__row'>3 Seats</div>
                                <div class='pt__row'>Unlimited</div>
                                <div class='pt__row'>
                                    <a href='{$product->get_permalink()}'>Purchase Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    return $content;
}

// Add Kosovo as a checkout country
add_filter('woocommerce_countries', 'hello_theme_add_kosovo');
function hello_theme_add_kosovo($countries) {
    // Add Kosovo to the list of countries
    $countries['XK'] = __('Kosovo', 'woocommerce');
    return $countries;
}

// Add Kosovo to the list of continents (EU)
add_filter('woocommerce_continents', 'hello_theme_add_kosovo_to_continents');
function hello_theme_add_kosovo_to_continents($continents) {
    // Add Kosovo to the list of European countries
    $continents['EU']['countries'][] = 'XK';
    return $continents;
}

// Add states (cities) for Kosovo
add_filter('woocommerce_states', 'add_kosovo_states');
function add_kosovo_states($states) {
    // Define the states (cities) in Kosovo
    $states['XK'] = array(
        '' => __('Your State Name', 'woocommerce'), // Replace with your own state name
        'pristina' => __('Pristina', 'woocommerce'),
        'peja' => __('Peja', 'woocommerce'),
        'prizren' => __('Prizren', 'woocommerce'),
        'mitrovica' => __('Mitrovica', 'woocommerce'),
        'gjilan' => __('Gjilan', 'woocommerce'),
        'gjakova' => __('Gjakova', 'woocommerce'),
        'ferizaj' => __('Ferizaj', 'woocommerce'),
        // Add more cities here
    );
    return $states;
}