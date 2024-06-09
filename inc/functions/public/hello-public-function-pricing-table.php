<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
// Fungsi untuk menampilkan tabel harga
function hello_pricing_table_shortcode() {
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


        <h1>Responsive Pricing Table, Table Columns in Desktop, Slider in Mobile</h1>

        <div class="pricing__table">
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
            <div class="pt__option__mobile__nav">
                <a id="navBtnLeft" href="#" class="mobile__nav__btn">
                  <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.1538 11.9819H1.81972" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11.9863 22.1535L1.82043 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
                <a id="navBtnRight" href="#" class="mobile__nav__btn">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1.81934 11.9819H22.1534" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M11.9863 22.1535L22.1522 11.9865L11.9863 1.81946" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <div class="pt__option__slider swiper" id="pricingTableSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide pt__option__item">
                  <div class="pt__item recommend">
                    <div class="pt__item__wrap">
                      <div class="pt__row">Premium</div>
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
                      <div class="pt__row">Standard</div>
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
                      <div class="pt__row">Essentials</div>
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
        
        <?php
        return ob_get_clean();
    } else {
        return '<p>Table pricing is not enabled.</p>';
    }
}
add_shortcode( 'hello_pricing_table', 'hello_pricing_table_shortcode' );

