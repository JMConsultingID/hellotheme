jQuery(document).ready(function($) {
    const categorySelection = document.querySelector('#category-selection');
    const challengeButtons = document.querySelectorAll('.challenge-option');
    const accountTypeSelection = document.querySelector('#account-type-selection');
    const addonsSelection = document.querySelector('#addons-selection');
    const checkoutButton = document.querySelector('#checkout-button');
    const productImage = document.querySelector('#product-image');
    const productTitle = document.querySelector('#product-title');
    const productDescription = document.querySelector('#product-description');
    const productPrice = document.querySelector('#product-price');

    // Preselect based on data attributes from the root element
    const form = document.querySelector('#challenge-selection-form');
    let selectedCategory = form.dataset.category;
    let selectedChallenge = form.dataset.challenge;
    let selectedAccountType = form.dataset.accountType;
    let selectedAddons = [];

    function resetAddonsSelection() {
        document.querySelectorAll('input[name="addons"]').forEach(function(checkbox) {
            checkbox.checked = false;
        });
        selectedAddons = [];
    }

    // Apply preselect based on URL parameters or defaults
    function applyPreselect() {
        // Set category selection
        document.querySelector(`input[name="category"][value="${selectedCategory}"]`).checked = true;

        // Set challenge button
        challengeButtons.forEach(btn => {
            btn.classList.remove('selected');
            if (btn.dataset.value === selectedChallenge) {
                btn.classList.add('selected');
            }
        });

        // Set account type selection
        document.querySelectorAll('input[name="account_type"]').forEach(function(radio) {
            radio.checked = radio.value === selectedAccountType;
        });

        // Set addons selection
        updateAddonsSelection();
    }

    // Update addons selection based on selected category
    function updateAddonsSelection() {
        addonsSelection.innerHTML = ''; // Clear previous addons

        if (selectedCategory === 'base-camp') {
            addonsSelection.innerHTML = `
                <label><input type="checkbox" name="addons" value="active-days"> Active Days: 21 days + 15% fee (standard: 1st 30 days, then 21 days)</label>
                <label><input type="checkbox" name="addons" value="profitsplit"> Profit Split: 50%/70%/80% + 20% fee (standard 50%/50%/80%)</label>
            `;
        } else if (selectedCategory === 'the-peak') {
            addonsSelection.innerHTML = `
                <label><input type="checkbox" name="addons" value="peak_active_days"> Active Days: bi-weekly: + 20% fee (standard: 1st 21 days, then 14 days)</label>
                <label><input type="checkbox" name="addons" value="tradingdays"> Trading Days: no minimum trading days + 15% fee (standard: 5 days)</label>
            `;
        }

        // Reset addons selection
        selectedAddons = [];
        document.querySelectorAll('input[name="addons"]').forEach(function(checkbox) {
            checkbox.checked = form.dataset[checkbox.value] === 'yes'; // Check based on URL parameter or default
            checkbox.addEventListener('change', function() {
                selectedAddons = Array.from(document.querySelectorAll('input[name="addons"]:checked')).map(el => el.value);
                updateCheckoutButton();
            });
        });

        updateCheckoutButton(); // Update checkout button after setting addons
    }

    // Event listener for category selection change
    categorySelection.addEventListener('change', function(e) {
        selectedCategory = e.target.value;

        // Reset preselect to default when category changes
        if (selectedCategory === 'base-camp' || selectedCategory === 'the-peak') {
            selectedChallenge = '10k';
            selectedAccountType = 'standard';

            // Set default selections
            applyPreselect();
        }

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

    // Event listener for account type selection change
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
            peak_active_days: selectedAddons.includes('peak_active_days') ? 'yes' : 'no',
            tradingdays: selectedAddons.includes('tradingdays') ? 'yes' : 'no'
        };

        $.post(ajax_object.ajaxurl, data, function(response) {
            if (response.success) {
                checkoutButton.href = '/checkout/?add-to-cart=' + response.data.product_id;
                checkoutButton.removeAttribute('disabled');

                // Update product image and price
                productImage.innerHTML = `<img src="${response.data.product_image}" alt="Product Image" />`;
                productTitle.innerHTML = `Title: ${response.data.product_title}`;
                productDescription.innerHTML = `Description: ${response.data.product_description}`;
                productPrice.innerHTML = `Price: ${response.data.product_price}`;
            } else {
                checkoutButton.href = '#';
                checkoutButton.setAttribute('disabled', 'disabled');
                productImage.innerHTML = '';
                productTitle.innerHTML = '';
                productDescription.innerHTML = '';
                productPrice.innerHTML = '';
            }
        });
    }

    resetAddonsSelection(); // Reset all addons checkboxes when page loads

    // Initialize addons and checkout button
    applyPreselect();
});
