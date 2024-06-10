(function( $ ) {
    'use strict';
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

    // Initialize sub-tabs for the active main tab
    const initSubTabs = (mainTab) => {
        if (!mainTab) return;

        const subTabButtons = mainTab.querySelectorAll('.hello-theme-sub-tab-button');
        const subTabContents = mainTab.querySelectorAll('.hello-theme-sub-tab-content');

        if (!subTabButtons.length || !subTabContents.length) {
            return;
        }

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

    // Tab functionality
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

    initAllSwipers();
    window.addEventListener('resize', initAllSwipers);
    document.querySelectorAll('.hello-theme-tab-button').forEach(button => {
        button.addEventListener('click', initAllSwipers);
    });

    // Initialize sub-tabs for the initially active main tab
    const activeMainTab = document.querySelector('.hello-theme-tab-content');
    if (activeMainTab) {
        activeMainTab.classList.add('active');
        initSubTabs(activeMainTab);
    }
})( jQuery );