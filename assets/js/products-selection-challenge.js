jQuery(document).ready(function($) {
    // Handle category selection change
    $("input[name='challenge_category']").change(function() {
        var category = $(this).val();
        $.ajax({
            url: ajax_object.ajaxurl,  // Use localized ajaxurl
            type: "POST",
            data: {
                action: "load_products_by_category",
                category: category
            },
            success: function(response) {
                $("#challenge-product-selection").html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    });
});
