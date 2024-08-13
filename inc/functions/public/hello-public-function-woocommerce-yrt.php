<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

// Yourrobotrader Functions
// Add a custom field to the WooCommerce checkout page for the account number
add_action('woocommerce_after_checkout_billing_form', 'yrt_account_number_checkout_field');
function yrt_account_number_checkout_field($checkout) {
    woocommerce_form_field('account_number', array(
        'type' => 'text',
        'class' => array('account-number-field form-row-wide'),
        'label' => __('MetaTrader Account Number'),
        'placeholder' => __('Enter your MetaTrader Account Number'),
        'required' => true,
    ), $checkout->get_value('account_number'));
}
// Save the custom field value when the order is processed
add_action('woocommerce_checkout_update_order_meta', 'yrt_save_account_number_checkout_field');
function yrt_save_account_number_checkout_field($order_id) {
    if (!empty($_POST['account_number'])) {
        update_post_meta($order_id, 'account_number', sanitize_text_field($_POST['account_number']));
    }
}

// Display the account number in the order details (admin side)
add_action('woocommerce_admin_order_data_after_billing_address', 'yrt_display_account_number_admin_order_meta', 10, 1);
function yrt_display_account_number_admin_order_meta($order) {
    $account_number = get_post_meta($order->get_id(), 'account_number', true);
    if ($account_number) {
        echo '<p><strong>' . __('MetaTrader Account Number') . ':</strong> ' . $account_number . '</p>';
    }
}

// Hook into the license generation process
add_action('lmfwc_license_generated', 'associate_account_number_with_license', 10, 2);
function associate_account_number_with_license($license_key, $order) {
    // Get the account number from the order meta
    $account_number = get_post_meta($order->get_id(), 'account_number', true);
    if ($account_number) {
        // Store the account number in the license meta
        update_post_meta($license_key->get_id(), 'account_number', $account_number);
    }
}

function validate_license(WP_REST_Request $request) {
    $license_key = $request->get_param('license_key');
    $account_id = $request->get_param('account_id');
    global $wpdb;
    $table_name = $wpdb->prefix . 'licenses';
    $license = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE license_key = %s AND account_id = %d AND status = 'active'",
        $license_key, $account_id
    ));
    if ($license) {
        return new WP_REST_Response('valid', 200);
    } else {
        return new WP_REST_Response('invalid', 403);
    }
}