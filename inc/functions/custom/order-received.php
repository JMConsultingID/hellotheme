<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

// Shortcode to show order status - Order Received page
function get_order_id_from_url()
{
  if (is_wc_endpoint_url('order-received')) {
    // Get the current URL
    $url = $_SERVER['REQUEST_URI'];

    // Use regex to extract the order ID
    if (preg_match('/\/order-received\/(\d+)\//', $url, $matches)) {
      return intval($matches[1]);
    }
  }
  return 0; // Return 0 if no order ID is found
}
function display_order_status_shortcode()
{
  if (is_wc_endpoint_url('order-received')) {
    // load style
    wp_enqueue_style('hello-theme-order-received', get_stylesheet_directory_uri() . '/assets/css/custom/order-received.css');

    $order_id = get_order_id_from_url();

    $status_icon_complete = '<svg aria-hidden="true" class="e-font-icon-svg e-fas-check-circle" viewBox="0 0 512 512"
      xmlns="http://www.w3.org/2000/svg">
      <path
        d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
      </path>
    </svg>';
    $status_icon_onhold = '<svg aria-hidden="true" class="e-font-icon-svg e-fas-clock" viewBox="0 0 512 512"
      xmlns="http://www.w3.org/2000/svg">
      <path
        d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm92.49,313h0l-20,25a16,16,0,0,1-22.49,2.5h0l-67-49.72a40,40,0,0,1-15-31.23V112a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16V256l58,42.5A16,16,0,0,1,348.49,321Z">
      </path>
    </svg>';
    $status_icon_pending = '<svg aria-hidden="true" class="e-font-icon-svg e-fas-hourglass-half" viewBox="0 0 384 512"
      xmlns="http://www.w3.org/2000/svg">
      <path
        d="M360 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24 0 90.965 51.016 167.734 120.842 192C75.016 280.266 24 357.035 24 448c-13.255 0-24 10.745-24 24v16c0 13.255 10.745 24 24 24h336c13.255 0 24-10.745 24-24v-16c0-13.255-10.745-24-24-24 0-90.965-51.016-167.734-120.842-192C308.984 231.734 360 154.965 360 64c13.255 0 24-10.745 24-24V24c0-13.255-10.745-24-24-24zm-75.078 384H99.08c17.059-46.797 52.096-80 92.92-80 40.821 0 75.862 33.196 92.922 80zm.019-256H99.078C91.988 108.548 88 86.748 88 64h208c0 22.805-3.987 44.587-11.059 64z">
      </path>
    </svg>';
    $status_icon_processing = '<svg aria-hidden="true" class="e-font-icon-svg e-fas-hourglass-half" viewBox="0 0 384 512"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M360 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24 0 90.965 51.016 167.734 120.842 192C75.016 280.266 24 357.035 24 448c-13.255 0-24 10.745-24 24v16c0 13.255 10.745 24 24 24h336c13.255 0 24-10.745 24-24v-16c0-13.255-10.745-24-24-24 0-90.965-51.016-167.734-120.842-192C308.984 231.734 360 154.965 360 64c13.255 0 24-10.745 24-24V24c0-13.255-10.745-24-24-24zm-75.078 384H99.08c17.059-46.797 52.096-80 92.92-80 40.821 0 75.862 33.196 92.922 80zm.019-256H99.078C91.988 108.548 88 86.748 88 64h208c0 22.805-3.987 44.587-11.059 64z">
        </path>
      </svg>';
    $status_icon_cancelled = '<svg aria-hidden="true" class="e-font-icon-svg e-fas-times-circle" viewBox="0 0 512 512"
      xmlns="http://www.w3.org/2000/svg">
      <path
        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z">
      </path>
    </svg>';
    $status_icon_failed = '<svg aria-hidden="true" class="e-font-icon-svg e-fas-exclamation-triangle" viewBox="0 0 576 512"
      xmlns="http://www.w3.org/2000/svg">
      <path
        d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z">
      </path>
    </svg>';

    $status_title_ty = 'Thank You!';
    $status_desc_ty = 'Everything is ready! You will receive a confirmation email soon with your booking details.';
    $status_title_failed = 'Payment Failed';
    $status_desc_failed = 'Payment on your order has failed or declined, please use other payment method or you can contact our support';

    if ($order_id > 0) {
      $order = wc_get_order($order_id);

      if ($order) {
        // Get the order status
        $status = wc_get_order_status_name($order->get_status());

        $layout_so = '<div class="status-section">';
        if ($status == 'Pending payment') {
          $status_icon = $status_icon_pending;
        }
        if ($status == 'Processing') {
          $status_icon = $status_icon_processing;
        }
        if ($status == 'On hold') {
          $status_icon = $status_icon_onhold;
        }
        if ($status == 'Completed') {
          $status_icon = $status_icon_complete;
        }
        if ($status == 'Cancelled') {
          $status_icon = $status_icon_cancelled;
        }
        if ($status == 'Failed') {
          $status_icon = $status_icon_failed;
        }

        $status_title = ($status == 'Failed') ? $status_title_failed : $status_title_ty;
        $status_desc = ($status == 'Failed') ? $status_desc_failed : $status_desc_ty;

        $layout_so .= '<div class="status_img-icon">' . $status_icon . '</div>';
        $layout_so .= '<h1 class="status_title">' . $status_title . '</h1>';
        $layout_so .= '<p class="status_desc">' . $status_desc . '</p>';
        $layout_so .= '<div class="status_order">Order ' . esc_html($status) . '</div>';
        $layout_so .= '</div>';

        return $layout_so;

      } else {
        return 'Invalid order ID.';
      }
    } else {
      return 'Order ID not found.';
    }
  }
  return '';
}
add_shortcode('order_status', 'display_order_status_shortcode');