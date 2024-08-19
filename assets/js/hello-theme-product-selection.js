jQuery(document).ready(function($) {
    $('.category-button').on('click', function() {
        var category = $(this).data('category');

        $.ajax({
            url: productSelectionParams.ajax_url,
            type: 'POST',
            data: {
                action: 'load_products_by_category',
                nonce: productSelectionParams.nonce,
                category: category
            },
            success: function(response) {
                $('#product-list').html(response);
            },
            error: function() {
                alert('There was an error loading the products.');
            }
        });
    });
});
