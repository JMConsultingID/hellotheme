(function( $ ) {
    'use strict';
    function updateProductDetails(category) {
        const select = document.getElementById('product-select-' + category);
        const selectedProduct = select.value;
        document.querySelectorAll('.product-detail.' + category).forEach(detail => {
            detail.style.display = 'none';
        });
        document.getElementById('product-detail-' + selectedProduct).style.display = 'block';
    }

    // Export the function to global scope
    window.updateProductDetails = updateProductDetails;

    // Function to update scaling product details for mobile
    function updateScalingProductDetailsMobile(category) {
        const select = document.getElementById('product-select-' + category);
        const selectedProduct = select.value;
        document.querySelectorAll('.product-detail.' + category).forEach(detail => {
            detail.style.display = 'none';
        });
        const productDetail = document.getElementById('product-detail-' + selectedProduct);
        if (productDetail) {
            productDetail.style.display = 'block';
            // Initialize swiper for the selected product
            new Swiper('#swiper-' + selectedProduct, {
                slidesPerView: 1,
                spaceBetween: 10,
                navigation: {
                    nextEl: '#swiper-' + selectedProduct + ' .swiper-button-next',
                    prevEl: '#swiper-' + selectedProduct + ' .swiper-button-prev',
                },
                allowTouchMove: false,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                }
            });
        } else {
            console.error('Selected product detail not found for ID:', selectedProduct);
        }
    }

    // Function to initialize Swiper for visible tables
    function initSwiperForVisibleTables() {
        jQuery('.product-detail:visible .swiper-container').each(function() {
            new Swiper(this, {
                slidesPerView: 1,
                spaceBetween: 10,
                navigation: {
                    nextEl: jQuery(this).find('.swiper-button-next')[0],
                    prevEl: jQuery(this).find('.swiper-button-prev')[0],
                },
                allowTouchMove: false,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                }
            });
        });
    }

    // Export the function to global scope
    window.updateScalingProductDetailsMobile = updateScalingProductDetailsMobile;

    // Initialize tippy tooltips
    document.addEventListener("DOMContentLoaded", function() {
        tippy(".pricing-table-label-tooltips, .scalling-table-label-tooltips", {
            theme: 'light',
            placement: 'right',
            arrow: false,
            animation: 'fade',
            allowHTML: true,
            interactive: true,
            delay: [100, 100],
        });
    });


})( jQuery );
