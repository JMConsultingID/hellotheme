<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

defined( 'ABSPATH' ) || exit;
wc_print_notice( esc_html__( 'Password reset email has been sent.', 'woocommerce' ) );
?>

<div class="woocommerce-dashboard-login container-fluid login-container">
    <!-- Image Section (Left) -->
    <div class="col-md-8 login-image d-none d-md-block">
        <!-- Placeholder for image -->
    </div>

    <!-- Login Form (Right) -->
    <div class="col-md-4 col-12 login-form text-center">
    	<div class="">
    		<?php 
    			
    			<?php do_action( 'woocommerce_before_lost_password_confirmation_message' ); ?>
    		?>
    	</div>
        <div class="dashboard-logo mb-5">
            <a href="/"><img src="/wp-content/uploads/2024/10/yrt_new_logo-_2-jan-09.png" alt="Your Robo Trader" class="img-fluid" width="220px"></a>
        </div>

        <p><?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', esc_html__( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' ) ) ); ?></p>

    </div>
</div>

<?php do_action( 'woocommerce_after_lost_password_confirmation_message' ); ?>
