(function( $ ) {
    'use strict';
    let activeSlideIndex = 0; // Variable to store the active slide index

    // Function to initialize Swiper for each main tab
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

    // Initialize main tabs
    const initMainTabs = () => {
        const tabButtons = document.querySelectorAll('.hello-theme-tab-button');
        const tabContents = document.querySelectorAll('.hello-theme-tab-content');

        if (!tabButtons.length || !tabContents.length) {
            return;
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                const tabId = button.dataset.tabId;
                const activeTabContent = document.querySelector(`.hello-theme-tab-content[data-tab-id="${tabId}"]`);
                activeTabContent.classList.add('active');

                // Set the active slide index for the new tab
                if (activeTabContent.swiperInstance) {
                    activeTabContent.swiperInstance.slideTo(activeSlideIndex, 0); // Use slideTo with no animation
                } else if (window.innerWidth <= 991) {
                    activeTabContent.swiperInstance = initTabSwiper(activeTabContent);
                    activeTabContent.swiperInstance.slideTo(activeSlideIndex, 0);
                }
            });
        });

        // Initialize swiper for the active main tab
        const activeTabContent = document.querySelector('.hello-theme-tab-content.active');
        if (activeTabContent && !activeTabContent.swiperInstance && window.innerWidth <= 991) {
            activeTabContent.swiperInstance = initTabSwiper(activeTabContent);
            activeTabContent.swiperInstance.slideTo(activeSlideIndex, 0);
        }
    }

    const initAllSwipers = () => {
        document.querySelectorAll('.hello-theme-tab-content').forEach(tabContent => {
            if (tabContent.classList.contains('active')) {
                if (!tabContent.swiperInstance && window.innerWidth <= 991) {
                    tabContent.swiperInstance = initTabSwiper(tabContent);
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
    document.querySelectorAll('.hello-theme-tab-button').forEach(button => {
        button.addEventListener('click', initAllSwipers);
    });

    // Initialize main tabs
    initMainTabs();
})( jQuery );