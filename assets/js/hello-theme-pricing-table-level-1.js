(function( $ ) {
    'use strict';
    let activeSlideIndex = 0; // Variable to store the active slide index

    // Function to initialize Swiper for each product tab
    const initProductSwiper = (tabContent) => {
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

    // Initialize product tabs
    const initProductTabs = () => {
        const productTabButtons = document.querySelectorAll('.hello-theme-sub-tab-button');
        const productTabContents = document.querySelectorAll('.hello-theme-sub-tab-content');

        if (!productTabButtons.length || !productTabContents.length) {
            return;
        }

        productTabButtons.forEach(button => {
            button.addEventListener('click', () => {
                productTabButtons.forEach(btn => btn.classList.remove('active'));
                productTabContents.forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                const subTabId = button.dataset.subTabId;
                const activeProductTabContent = document.querySelector(`.hello-theme-sub-tab-content[data-sub-tab-id="${subTabId}"]`);
                activeProductTabContent.classList.add('active');

                // Set the active slide index for the new sub-tab
                if (activeProductTabContent.swiperInstance) {
                    activeProductTabContent.swiperInstance.slideTo(activeSlideIndex, 0); // Use slideTo with no animation
                } else if (window.innerWidth <= 991) {
                    activeProductTabContent.swiperInstance = initProductSwiper(activeProductTabContent);
                    activeProductTabContent.swiperInstance.slideTo(activeSlideIndex, 0);
                }
            });
        });

        // Initialize swiper for the active product tab
        const activeProductTabContent = document.querySelector('.hello-theme-sub-tab-content.active');
        if (activeProductTabContent && !activeProductTabContent.swiperInstance && window.innerWidth <= 991) {
            activeProductTabContent.swiperInstance = initProductSwiper(activeProductTabContent);
            activeProductTabContent.swiperInstance.slideTo(activeSlideIndex, 0);
        }
    }

    const initAllSwipers = () => {
        document.querySelectorAll('.hello-theme-sub-tab-content').forEach(tabContent => {
            if (tabContent.classList.contains('active')) {
                if (!tabContent.swiperInstance && window.innerWidth <= 991) {
                    tabContent.swiperInstance = initProductSwiper(tabContent);
                    tabContent.swiperInstance.slideTo(activeSlideIndex, 0);
                }
            } else if (tabContent.swiperInstance) {
                tabContent.swiperInstance.destroy();
                tabContent.swiperInstance = null;
            }
        });
    }

    initAllSwipers();
    window.addEventListener('resize', initAllSwipers);
    document.querySelectorAll('.hello-theme-sub-tab-button').forEach(button => {
        button.addEventListener('click', initAllSwipers);
    });

    // Initialize product tabs
    initProductTabs();
})( jQuery );