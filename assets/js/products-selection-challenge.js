jQuery(document).ready(function($) {
    function updateProductSelection() {
        // Get selected category
        var category = $('#category-select').val();
        // Get selected account type
        var accountType = $('input[name="account_type"]:checked').val();
        // Get selected add-ons
        var activeDays = $('#addon-active-days').is(':checked') ? 'yes' : 'no';
        var profitSplit = $('#addon-profit-split').is(':checked') ? 'yes' : 'no';
        var tradingDays = $('#addon-trading-days').is(':checked') ? 'yes' : 'no';

        // AJAX call to get the product ID based on the selections
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_product_id_based_on_selection',
                category: category,
                account_type: accountType,
                active_days: activeDays,
                profit_split: profitSplit,
                trading_days: tradingDays
            },
            success: function(response) {
                if (response.success) {
                    // Update the checkout button href
                    $('#checkout-button').attr('href', '/checkout/?add-to-cart=' + response.data.product_id);
                    $('#checkout-button').removeAttr('disabled');
                } else {
                    // Disable the checkout button if no product is found
                    $('#checkout-button').attr('href', '#');
                    $('#checkout-button').attr('disabled', true);
                }
            }
        });
    }

    // Event listeners
    $('#category-select, input[name="account_type"], #addon-active-days, #addon-profit-split, #addon-trading-days').on('change', function() {
        updateProductSelection();
    });

    // Initial call to set up the form
    updateProductSelection();
});
