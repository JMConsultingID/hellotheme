jQuery(document).ready(function($) {
    const categorySelection = document.querySelector('#category-selection');
    const challengeButtons = document.querySelectorAll('.challenge-option');
    const accountTypeSelection = document.querySelector('#account-type-selection');
    const addonsSelection = document.querySelector('#addons-selection');
    const checkoutButton = document.querySelector('#checkout-button');
    const productImage = document.querySelector('#product-image');
    const productPrice = document.querySelector('#product-price');

    let selectedCategory = document.querySelector('input[name="category"]:checked').value;
    let selectedChallenge = null; // Set to null initially
    let selectedAccountType = null; // Set to null initially
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

        // Reset addons selection
        selectedAddons = [];
        document.querySelectorAll('input[name="addons"]').forEach(function(checkbox) {
            checkbox.checked = false;  // Unselect all checkboxes
            checkbox.addEventListener('change', function() {
                selectedAddons = Array.from(document.querySelectorAll('input[name="addons"]:checked')).map(el => el.value);
                updateCheckoutButton();
            });
        });
    }

    // Event listener for category selection
    categorySelection.addEventListener('change', function(e) {
        selectedCategory = e.target.value;

        // Unselect Button Selection Bar (Challenge)
        selectedChallenge = null;
        challengeButtons.forEach(btn => btn.classList.remove('selected'));

        // Unselect Button Type of Account
        selectedAccountType = null;
        document.querySelectorAll('input[name="account_type"]').forEach(function(radio) {
            radio.checked = false;
        });

        // Reset addons
        updateAddonsSelection();
        
        // Update checkout button state
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

    // Event listener for account type selection
    accountTypeSelection.addEventListener('change', function(e) {
        selectedAccountType = e.target.value;
        updateCheckoutButton();
    });

    // Update checkout button and display product details based on selections
    function updateCheckoutButton() {
        // Check if all selections are made
        if (!selectedCategory || !selectedChallenge || !selectedAccountType) {
            checkoutButton.href = '#';
            checkoutButton.setAttribute('disabled', 'disabled');
            productImage.innerHTML = '';
            productPrice.innerHTML = '';
            return;
        }

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

                // Update product image and price
                productImage.innerHTML = `<img src="${response.data.product_image}" alt="Product Image" />`;
                productPrice.innerHTML = `Price: ${response.data.product_price}`;

            } else {
                checkoutButton.href = '#';
                checkoutButton.setAttribute('disabled', 'disabled');
                productImage.innerHTML = '';
                productPrice.innerHTML = '';
            }
        });
    }

    // Initialize addons and checkout button
    updateAddonsSelection();
    document.querySelectorAll('input[name="account_type"]').forEach(function(radio) {
        radio.checked = false;  // Unselect all radio buttons for account type on load
    });
    updateCheckoutButton();
});
