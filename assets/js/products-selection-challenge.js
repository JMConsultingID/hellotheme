jQuery(document).ready(function($) {
    // Handle category selection
    $('input[name="product-category"]').change(function() {
        var selectedCategory = $(this).val();

        // Make AJAX request to fetch products based on selected category
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'fetch_products_by_category',
                category: selectedCategory
            },
            success: function(response) {
                // Update the product options section with the response data
                $('#product-options').html(response);
                
                // Re-enable the checkout button if products are available
                $('#checkout-button').prop('disabled', false);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });

    // Handle product selection and add-ons logic here (to be added later)
});
