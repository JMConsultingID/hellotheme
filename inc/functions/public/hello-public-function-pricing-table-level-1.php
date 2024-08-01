<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
function hello_pricing_table_level_1_shortcode() {
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
add_shortcode( 'hello_pricing_table_level_1', 'hello_pricing_table_level_1_shortcode' );

