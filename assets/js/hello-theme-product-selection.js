(function( $ ) {
    'use strict';

    $(document).ready(function() {
        const categorySelection = document.querySelector('#category-selection');
        const challengeButtons = document.querySelectorAll('.challenge-option');
        const accountTypeSelection = document.querySelector('#account-type-selection');
        const addonsSelection = document.querySelector('#addons-selection ul');
        const checkoutButton = document.querySelector('#checkout-button');
        const productImage = document.querySelector('#product-image');
        const productTitle = document.querySelector('#product-title');
        const productDescription = document.querySelector('#product-description');
        const productPrice = document.querySelector('#product-price');

        // Function to get URL parameter value
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            const results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Check if there are parameters in the URL
        const urlCategory = getUrlParameter('category');
        const urlChallenge = getUrlParameter('challenge');
        const urlAccountType = getUrlParameter('account_type');

        // Preselect based on URL parameters or Local Storage
        const form = document.querySelector('#challenge-selection-form');
        let selectedCategory = urlCategory || form.dataset.category;
        let selectedChallenge = urlChallenge || form.dataset.challenge;
        let selectedAccountType = urlAccountType || form.dataset.accountType;

        // If URL parameters exist, clear Local Storage to avoid conflicts
        if (urlCategory || urlChallenge || urlAccountType) {
            localStorage.removeItem('productSelections');
        }

        // Attempt to load selectedAddons from Local Storage or initialize as an empty array
        let selectedAddons = JSON.parse(localStorage.getItem('productSelections'))?.addons || [];

        // Function to save selections to Local Storage
        function saveSelections() {
            const selections = {
                category: selectedCategory,
                challenge: selectedChallenge,
                accountType: selectedAccountType,
                addons: selectedAddons
            };
            localStorage.setItem('productSelections', JSON.stringify(selections));
        }

        // Function to load selections from Local Storage
        function loadSelections() {
            const selections = JSON.parse(localStorage.getItem('productSelections'));
            if (selections) {
                selectedCategory = selections.category;
                selectedChallenge = selections.challenge;
                selectedAccountType = selections.accountType;
                selectedAddons = selections.addons || [];

                applyPreselect();
            }
        }

        // Apply preselection based on URL parameters, defaults, or Local Storage
        function applyPreselect() {
            if (selectedCategory) {
                document.querySelector(`input[name="category"][value="${selectedCategory}"]`).checked = true;
            }

            challengeButtons.forEach(btn => {
                btn.classList.remove('selected');
                if (btn.dataset.value === selectedChallenge) {
                    btn.classList.add('selected');
                }
            });

            document.querySelectorAll('input[name="account_type"]').forEach(function(radio) {
                radio.checked = radio.value === selectedAccountType;
            });

            updateAddonsSelection();
        }

        // Update addons selection based on the selected category
        function updateAddonsSelection() {
            addonsSelection.innerHTML = ''; // Clear previous addons

            if (selectedCategory === 'base-camp') {
                addonsSelection.innerHTML = `
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="active-days" value="active-days"/><label for="active-days" class="">Active Days: 21 days + 15% fee</label></li>
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="profitsplit" value="profitsplit"/><label for="profitsplit" class="">Profit Split: 50%/70%/80% + 20% fee</label></li>
                `;
            } else if (selectedCategory === 'the-peak') {
                addonsSelection.innerHTML = `
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="peak_active_days" value="peak_active_days"/><label for="peak_active_days" class="">Active Days: bi-weekly: + 20% fee</label></li>
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="tradingdays" value="tradingdays"/><label for="tradingdays" class="">Trading Days: no minimum trading days + 15% fee</label></li>
                `;
            }

            // Set selected addons based on loaded selections
            document.querySelectorAll('input[name="addons"]').forEach(function(checkbox) {
                checkbox.checked = selectedAddons.includes(checkbox.value); // Load addons from Local Storage
                checkbox.addEventListener('change', function() {
                    selectedAddons = Array.from(document.querySelectorAll('input[name="addons"]:checked')).map(el => el.value);
                    saveSelections(); // Save selections to Local Storage
                    updateCheckoutButton();
                });
            });

            updateCheckoutButton(); // Update checkout button after setting addons
        }

        // Event listener for category selection change
        categorySelection.addEventListener('change', function(e) {
            selectedCategory = e.target.value;
            saveSelections(); // Save selections after change
            updateAddonsSelection();
        });

        // Event listeners for challenge buttons
        challengeButtons.forEach(button => {
            button.addEventListener('click', function() {
                selectedChallenge = button.getAttribute('data-value');
                challengeButtons.forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                saveSelections(); // Save selections after change
                updateCheckoutButton();
            });
        });

        // Event listener for account type selection change
        accountTypeSelection.addEventListener('change', function(e) {
            selectedAccountType = e.target.value;
            saveSelections(); // Save selections after change
            updateCheckoutButton();
        });

        // Update checkout button and display product details based on selections
        function updateCheckoutButton() {
            // Check if all selections are made
            if (!selectedCategory || !selectedChallenge || !selectedAccountType) {
                checkoutButton.href = '#';
                checkoutButton.setAttribute('disabled', 'disabled');
                productImage.innerHTML = '';
                productTitle.innerHTML = '';
                productDescription.innerHTML = '';
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

                    // Update product image, title, description, and price
                    productImage.innerHTML = `<img src="${response.data.product_image}" alt="${response.data.product_title}" class="product-img" />`;
                    productTitle.innerHTML = `<h5 class="sub-title">${response.data.product_title}</h5>`;
                    productDescription.innerHTML = `${response.data.product_description}`;
                    productPrice.innerHTML = `<span class="num-total">${response.data.product_price}</span>`;
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

        // Load selections when the page loads
        loadSelections();
    });

})( jQuery );