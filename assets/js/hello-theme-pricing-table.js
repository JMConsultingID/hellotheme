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

    window.updateProductDetails = updateProductDetails;

    document.addEventListener("DOMContentLoaded", function() {
        tippy(".pricing-table-label-tooltips", {
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
