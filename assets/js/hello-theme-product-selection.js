(function ($) {
  "use strict";

  $(document).ready(function () {
    const categorySelection = document.querySelector("#category-selection");
    const challengeButtons = document.querySelectorAll(".challenge-option");
    const accountTypeSelection = document.querySelector(
      "#account-type-selection"
    );
    const addonsSelection = document.querySelector("#addons-selection ul");
    const checkoutButton = document.querySelector("#checkout-button");
    const productImage = document.querySelector("#product-image");
    const productTitle = document.querySelector("#product-title");
    const productDescription = document.querySelector("#product-description");
    const productPrice = document.querySelector("#product-price");
    const standardTooltip = document.getElementById('standard-tooltip');
    const swingTooltip = document.getElementById('swing-tooltip');

    // Preselect based on data attributes from the root element
    const form = document.querySelector("#challenge-selection-form");
    let selectedCategory = form.dataset.category;
    let selectedChallenge = form.dataset.challenge;
    let selectedAccountType = form.dataset.accountType;
    let selectedAddons = [];

    // Progress Range
    const sacProgressRange = "#sac-progress-range";
    const btnPriceSelection = "#challenge-selection-bar .challenge-option";

    // Function to update tooltips based on selected category
    function updateAccountTooltips(selectedCategory) {
        if (selectedCategory === 'base-camp') {
            standardTooltip.setAttribute('data-tippy-content', 'No Weekend Holding, No News Trading, Up to 100:1 Leverage.');
            swingTooltip.setAttribute('data-tippy-content', 'Weekend Holding Allowed, News Trading Allowed, Up to 30:1 Leverage');
        } else if (selectedCategory === 'the-peak') {
            standardTooltip.setAttribute('data-tippy-content', 'No News Trading, Up to 100:1 Leverage');
            swingTooltip.setAttribute('data-tippy-content', 'News Trading Allowed, Up to 30:1 Leverage');
        }

        // Re-initialize Tippy.js to update the tooltips with new content
        tippy('.hello-theme-pcs-label-tooltips', {
            theme: 'light',
            placement: 'right',
            arrow: false,
            animation: 'fade',
            allowHTML: true,
            interactive: true,
            delay: [100, 100],
        });
    }

    updateAccountTooltips('base-camp'); 

    function setAccountTypeSelection() {
      // Set account type selection
      document
        .querySelectorAll('input[name="account_type"]')
        .forEach(function (radio) {
          radio.checked = radio.value === selectedAccountType;
        });

      // Set addons selection
      updateAddonsSelection();
    }

    // Apply preselect based on URL parameters or defaults
    function applyPreselect() {
      // Set category selection
      document.querySelector(
        `input[name="category"][value="${selectedCategory}"]`
      ).checked = true;

      // Set challenge button
      challengeButtons.forEach((btn) => {
        btn.classList.remove("selected");
        if (btn.dataset.value === selectedChallenge) {
          btn.classList.add("selected");
          //progress range
          const tabIndex = parseInt(btn.getAttribute("data-tab-index"));
          const range = document.querySelector(sacProgressRange);
          range.value = tabIndex;
          setTimeout(() => {
            range.dispatchEvent(new Event("input"));
          }, 100);
        }
      });
      setAccountTypeSelection();
    }

    // Update addons selection based on selected category
    function updateAddonsSelection() {
      addonsSelection.innerHTML = ""; // Clear previous addons

      if (selectedCategory === "base-camp") {
        addonsSelection.innerHTML = `
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="active-days" value="active-days"/><label for="active-days" class="">Active Days: 21 days + 15% fee</label><span class="hello-theme-pcs-label-tooltips" data-tippy-content="Standard: 1st 30 days, then 21 days"><i aria-hidden="true" class="fas fa-info-circle"></i></span></li>
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="profitsplit" value="profitsplit"/><label for="profitsplit" class="">ProfitSplit: 50%/70%/80% + 20% fee</label><span class="hello-theme-pcs-label-tooltips" data-tippy-content="Standard: 50%/50%/80%"><i aria-hidden="true" class="fas fa-info-circle"></i></span></li>
                `;
      } else if (selectedCategory === "the-peak") {
        addonsSelection.innerHTML = `
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="peak_active_days" value="peak_active_days"/><label for="peak_active_days" class="">Active Days: bi-weekly: + 20% fee</label><span class="hello-theme-pcs-label-tooltips" data-tippy-content="Standard: 1st 21 days, then 14 days"><i aria-hidden="true" class="fas fa-info-circle"></i></span></li>
                    <li><input type="checkbox" class="input-checkbox" name="addons" id="tradingdays" value="tradingdays"/><label for="tradingdays" class="">Trading Days: No minimum trading days + 15% fee</label><span class="hello-theme-pcs-label-tooltips" data-tippy-content="Standard: 5 days"><i aria-hidden="true" class="fas fa-info-circle"></i></span></li>
                `;
      }

      tippy(".hello-theme-pcs-label-tooltips", {
          theme: 'light',
          placement: 'right',
          arrow: false,
          animation: 'fade',
          allowHTML: true,
          interactive: true,
          delay: [100, 100],
      });

      // Reset addons selection
      selectedAddons = [];
      document
        .querySelectorAll('input[name="addons"]')
        .forEach(function (checkbox) {
          checkbox.checked = form.dataset[checkbox.value] === "yes"; // Check based on URL parameter or default
          checkbox.addEventListener("change", function () {
            selectedAddons = Array.from(
              document.querySelectorAll('input[name="addons"]:checked')
            ).map((el) => el.value);
            updateCheckoutButton();
          });
        });

      updateCheckoutButton(); // Update checkout button after setting addons
    }

    // Event listener for category selection change
    categorySelection.addEventListener("change", function (e) {
      selectedCategory = e.target.value;

      // Reset preselect to default when category changes
      if (selectedCategory === "base-camp" || selectedCategory === "the-peak") {
        selectedChallenge = "10k";
        selectedAccountType = "standard";

        // Set default selections
        applyPreselect();
      }

      // Update tooltips based on the selected category
      updateAccountTooltips(selectedCategory);

      // Reset addons
      updateAddonsSelection();

      // Update checkout button state
      updateCheckoutButton();
    });

    // Event listeners for challenge buttons
    challengeButtons.forEach((button) => {
      button.addEventListener("click", function () {
        selectedChallenge = button.getAttribute("data-value");
        challengeButtons.forEach((btn) => btn.classList.remove("selected"));
        button.classList.add("selected");
        updateCheckoutButton();
      });
    });

    // Event listener for account type selection change
    accountTypeSelection.addEventListener("change", function (e) {
      selectedAccountType = e.target.value;
      updateCheckoutButton();
    });

    // Update checkout button and display product details based on selections
    function updateCheckoutButton() {
      // Check if all selections are made
      if (!selectedCategory || !selectedChallenge || !selectedAccountType) {
        checkoutButton.href = "#";
        checkoutButton.setAttribute("disabled", "disabled");
        productImage.innerHTML = "";
        productTitle.innerHTML = "";
        productDescription.innerHTML = "";
        productPrice.innerHTML = "";
        return;
      }

      const data = {
        action: "get_custom_product_id",
        category: selectedCategory,
        account_type: selectedAccountType,
        challenge: selectedChallenge,
        active_days: selectedAddons.includes("active-days") ? "yes" : "no",
        profitsplit: selectedAddons.includes("profitsplit") ? "yes" : "no",
        peak_active_days: selectedAddons.includes("peak_active_days")
          ? "yes"
          : "no",
        tradingdays: selectedAddons.includes("tradingdays") ? "yes" : "no",
      };

      $.post(ajax_object.ajaxurl, data, function (response) {
        if (response.success) {
          checkoutButton.href =
            "/checkout/?add-to-cart=" + response.data.product_id;
          checkoutButton.removeAttribute("disabled");

          // Update product image, title, description, and price
          productImage.innerHTML = `<img src="${response.data.product_image}" alt="${response.data.product_title}" class="product-img" />`;
          productTitle.innerHTML = `<h5 class="sub-title">${response.data.product_title}</h5>`;
          productDescription.innerHTML = `${response.data.product_description}`;
          productPrice.innerHTML = `<span class="num-total">${response.data.product_price}</span>`;
        } else {
          checkoutButton.href = "#";
          checkoutButton.setAttribute("disabled", "disabled");
          productImage.innerHTML = "";
          productTitle.innerHTML = "";
          productDescription.innerHTML = "";
          productPrice.innerHTML = "";
        }
      });
    }

    /* Handling Progress Bar */
    function setupProgressBar(rangeSelector, tabsSelector) {
      const range = document.querySelector(rangeSelector);
      const tabs = document.querySelectorAll(tabsSelector);

      // Update max value of range input based on the number of tabs
      range.setAttribute("max", tabs.length);

      // Initialize progress bar
      range.style.backgroundSize =
        ((range.value - range.min) / (range.max - range.min)) * 100 + "% 100%";

      // Add event listener for range input
      range.addEventListener("input", () => {
        const currentVal = parseInt(range.value);
        const min = parseInt(range.min);
        const max = parseInt(range.max);

        range.style.backgroundSize =
          ((currentVal - min) / (max - min)) * 100 + "% 100%";

        tabs.forEach((tab, index) => {
          const tabIndex = index + 1;
          const isSelected = tabIndex === currentVal;
          if (isSelected) {
            selectedChallenge = tab.getAttribute("data-value");
            tab.classList.add("selected");
            setAccountTypeSelection();
          } else {
            tab.classList.remove("selected");
          }
        });
      });

      // Add event listener for clicking tabs
      tabs.forEach((tab) => {
        tab.addEventListener("click", (e) => {
          const tabIndex = parseInt(tab.getAttribute("data-tab-index"));
          range.value = tabIndex;
          setTimeout(() => {
            range.dispatchEvent(new Event("input"));
          }, 100);
          e.preventDefault();
        });
      });
    }
    setupProgressBar(sacProgressRange, btnPriceSelection);

    // Initialize addons and checkout button
    applyPreselect();
  });
})(jQuery);
