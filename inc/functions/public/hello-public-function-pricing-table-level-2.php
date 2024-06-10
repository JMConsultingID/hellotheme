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
                                <?php echo render_pricing_table($product); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products found in this category.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <script>
            let activeSlideIndex = 0; // Variable to store the active slide index

            // Function to initialize Swiper for each tab
            const initTabSwiper = (tabContent) => {
                if (window.innerWidth <= 991) {
                    const swiperInstance = new Swiper(tabContent.querySelector('.swiper'), {
                        slidesPerView: "auto",
                        spaceBetween: 5,
                        grabCursor: true,
                        keyboard: true,
                        autoHeight: false,
                        navigation: {
                            nextEl: tabContent.querySelector(".mobile__nav__btn:last-of-type"),
                            prevEl: tabContent.querySelector(".mobile__nav__btn:first-of-type"),
                        },
                        on: {
                            slideChange: () => {
                                activeSlideIndex = swiperInstance.activeIndex; // Update activeSlideIndex on slide change
                                updateNavButtons(swiperInstance, tabContent);
                            }
                        }
                    });

                    updateNavButtons(swiperInstance, tabContent);

                    return swiperInstance;
                }
            }

            // Function to update navigation buttons' disabled state
            const updateNavButtons = (swiperInstance, tabContent) => {
                const prevButton = tabContent.querySelector(".mobile__nav__btn:first-of-type");
                const nextButton = tabContent.querySelector(".mobile__nav__btn:last-of-type");

                if (swiperInstance.isBeginning) {
                    prevButton.classList.add('swiper-button-disabled');
                } else {
                    prevButton.classList.remove('swiper-button-disabled');
                }

                if (swiperInstance.isEnd) {
                    nextButton.classList.add('swiper-button-disabled');
                } else {
                    nextButton.classList.remove('swiper-button-disabled');
                }
            }

            // Tab functionality
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.hello-theme-tab-button').forEach(button => {
                    button.addEventListener('click', () => {
                        document.querySelectorAll('.hello-theme-tab-button').forEach(btn => btn.classList.remove('active'));
                        document.querySelectorAll('.hello-theme-tab-content').forEach(content => content.classList.remove('active'));

                        button.classList.add('active');
                        const tabId = button.dataset.tabId;
                        const activeTabContent = document.querySelector(`.hello-theme-tab-content[data-tab-id="${tabId}"]`);
                        activeTabContent.classList.add('active');

                        // Set the active slide index for the new tab
                        if (activeTabContent.swiperInstance) {
                            activeTabContent.swiperInstance.slideTo(activeSlideIndex, 0); // Use slideTo with no animation
                        } else {
                            activeTabContent.swiperInstance = initTabSwiper(activeTabContent);
                            activeTabContent.swiperInstance.slideTo(activeSlideIndex, 0);
                        }

                        // Initialize sub-tabs for the active main tab
                        initSubTabs(activeTabContent);
                    });
                });

                const initAllSwipers = () => {
                    document.querySelectorAll('.hello-theme-tab-content').forEach(tabContent => {
                        if (tabContent.classList.contains('active')) {
                            if (!tabContent.swiperInstance) {
                                tabContent.swiperInstance = initTabSwiper(tabContent);
                                tabContent.swiperInstance.slideTo(activeSlideIndex, 0);
                            }
                        } else if (tabContent.swiperInstance) {
                            tabContent.swiperInstance.destroy();
                            tabContent.swiperInstance = null;
                        }
                    });
                }

                // Initialize sub-tabs for the active main tab
                const initSubTabs = (mainTab) => {
                    const subTabButtons = mainTab.querySelectorAll('.hello-theme-sub-tab-button');
                    const subTabContents = mainTab.querySelectorAll('.hello-theme-sub-tab-content');

                    subTabButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            subTabButtons.forEach(btn => btn.classList.remove('active'));
                            subTabContents.forEach(content => content.classList.remove('active'));

                            button.classList.add('active');
                            const subTabId = button.dataset.subTabId;
                            const activeSubTabContent = mainTab.querySelector(`.hello-theme-sub-tab-content[data-sub-tab-id="${subTabId}"]`);
                            activeSubTabContent.classList.add('active');

                            // Set the active slide index for the new sub-tab
                            if (activeSubTabContent.swiperInstance) {
                                activeSubTabContent.swiperInstance.slideTo(activeSlideIndex, 0); // Use slideTo with no animation
                            } else {
                                activeSubTabContent.swiperInstance = initTabSwiper(activeSubTabContent);
                                activeSubTabContent.swiperInstance.slideTo(activeSlideIndex, 0);
                            }
                        });
                    });

                    // Initialize swiper for the active sub-tab
                    const activeSubTabContent = mainTab.querySelector('.hello-theme-sub-tab-content.active');
                    if (activeSubTabContent && !activeSubTabContent.swiperInstance) {
                        activeSubTabContent.swiperInstance = initTabSwiper(activeSubTabContent);
                        activeSubTabContent.swiperInstance.slideTo(activeSlideIndex, 0);
                    }
                }

                initAllSwipers();
                window.addEventListener('resize', initAllSwipers);
                document.querySelectorAll('.hello-theme-tab-button').forEach(button => {
                    button.addEventListener('click', initAllSwipers);
                });

                // Initialize sub-tabs for the initially active main tab
                initSubTabs(document.querySelector('.hello-theme-tab-content.active'));
            });
        </script>
        <?php
        return ob_get_clean();
    }
}
add_shortcode( 'hello_pricing_table_level_2', 'hello_pricing_table_level_2_shortcode' );
