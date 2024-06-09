(function( $ ) {
	'use strict';
    // Tab functionality
    document.querySelectorAll('.hello-theme-tab-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.hello-theme-tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.hello-theme-tab-content').forEach(content => content.classList.remove('active'));

            button.classList.add('active');
            const tabId = button.dataset.tabId;
            document.querySelector(`.hello-theme-tab-content[data-tab-id="${tabId}"]`).classList.add('active');
        });
    });

    // Swiper initialization for each tab
    const initTabSwiper = (tabContent) => {
        if (window.innerWidth <= 991) {
            return new Swiper(tabContent.querySelector('.swiper'), {
                slidesPerView: "auto",
                spaceBetween: 5,
                grabCursor: true,
                keyboard: true,
                autoHeight: false,
                navigation: {
                    nextEl: ".mobile__nav__btn:last-of-type",
                    prevEl: ".mobile__nav__btn:first-of-type",
                },
            });
        }
    }

    const initAllSwipers = () => {
        document.querySelectorAll('.hello-theme-tab-content').forEach(tabContent => {
            if (tabContent.classList.contains('active')) {
                if (!tabContent.swiperInstance) {
                    tabContent.swiperInstance = initTabSwiper(tabContent);
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


})( jQuery );
