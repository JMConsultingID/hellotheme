jQuery(document).ready(function($) {
    const categorySelection = document.querySelector('#category-selection');
    const challengeButtons = document.querySelectorAll('.challenge-option');
    const accountTypeSelection = document.querySelector('#account-type-selection');
    const addonsSelection = document.querySelector('#addons-selection');
    const checkoutButton = document.querySelector('#checkout-button');

    let selectedCategory = document.querySelector('input[name="category"]:checked').value;
    let selectedChallenge = '10k'; // Default value
    let selectedAccountType = document.querySelector('input[name="account_type"]:checked').value;
    let selectedAddons = [];

    // Update addons selection based on selected category
    function updateAddonsSelection() {
        addonsSelection.innerHTML = ''; // Clear previous addons

        if (selectedCategory === 'base-camp') {
            addonsSelection.innerHTML = `
                <label><input type="checkbox" name="addons" value="active-days"> Active Days</label>
                <label><input type="checkbox" name="addons" value="profitsplit"> Profit Split</label>
            `;
        } else if (selectedCategory === 'the-peak') {
            addonsSelection.innerHTML = `
                <label><input type="checkbox" name="addons" value="active-days"> Active Days</label>
                <label><input type="checkbox" name="addons" value="tradingdays"> Trading Days</label>
            `;
        }

        // Update selected addons array
        document.querySelectorAll('input[name="addons"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                selectedAddons = Array.from(document.querySelectorAll('input[name="addons"]:checked')).map(el => el.value);
                updateCheckoutButton();
            });
        });
    }

    // Event listeners for category selection
    categorySelection.addEventListener('change', function(e) {
        selectedCategory = e.target.value;
        updateAddonsSelection();
        updateCheckoutButton();
    });

    // Event listeners for challenge buttons
    challengeButtons.forEach(button => {
        button.addEventListener('click', function() {
            selectedChallenge = button.getAttribute('data-value');
            challengeButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            updateCheckoutButton();
        });
    });

    // Event listeners for account type selection
    accountTypeSelection.addEventListener('change', function(e) {
        selectedAccountType = e.target.value;
        updateCheckoutButton();
    });

    // Update checkout button based on selections
    function updateCheckoutButton() {
        const data = {
            action: 'get_custom_product_id',
            category: selectedCategory,
            account_type: selectedAccountType,
            challenge: selectedChallenge,
            active_days: selectedAddons.includes('active-days') ? 'yes' : 'no',
            profitsplit: selectedAddons.includes('profitsplit') ? 'yes' : 'no',
            tradingdays: selectedAddons.includes('tradingdays') ? 'yes' : 'no'
        };

        $.post(ajax_object.ajaxurl, data, function(response) {
            if (response.success) {
                checkoutButton.href = '/checkout/?add-to-cart=' + response.data.product_id;
                checkoutButton.removeAttribute('disabled');
            } else {
                checkoutButton.href = '#';
                checkoutButton.setAttribute('disabled', 'disabled');
            }
        });
    }

    // Initialize addons and checkout button
    updateAddonsSelection();
    updateCheckoutButton();
});