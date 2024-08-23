jQuery(document).ready(function($) {
    // Handle category selection
    $('.category-btn').click(function() {
        var category = $(this).data('category');
        loadProducts(category);
        loadAddons(category);
    });

    // Handle product and addon selection, update the checkout button
    $(document).on('change', '#product-selection input, #type-account-selection input, #addons-selection input', function() {
        updateCheckoutLink();
    });

    function loadProducts(category) {
        // Implement AJAX request to load products based on the selected category
        $.ajax({
            url: ajax_object.ajaxurl, // Use the localized ajaxurl
            type: 'POST',
            data: {
                action: 'load_products',
                category: category
            },
            success: function(response) {
                $('#product-selection').html(response);
            }
        });
    }

    function loadAddons(category) {
        // Implement AJAX request to load addons based on the selected category
        $.ajax({
            url: ajax_object.ajaxurl, // Use the localized ajaxurl
            type: 'POST',
            data: {
                action: 'load_addons',
                category: category
            },
            success: function(response) {
                $('#addons-selection').html(response);
            }
        });
    }

    function updateCheckoutLink() {
        // Collect selected values
        var product_id = $('#product-selection input:checked').val();
        var account_type = $('#type-account-selection input:checked').val();
        var addons = [];
        $('#addons-selection input:checked').each(function() {
            addons.push($(this).val());
        });

        // Generate the final checkout URL
        var checkout_url = '/checkout/?add-to-cart=' + product_id;
        if (addons.length > 0) {
            checkout_url += '+' + addons.join('+');
        }

        // Update the checkout button
        $('#checkout-button').attr('href', checkout_url);
    }
});
