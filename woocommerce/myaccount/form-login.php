<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="woocommerce-dashboard-login container-fluid login-container">
    <!-- Image Section (Left) -->
    <div class="col-md-8 login-image d-none d-md-block">
        <!-- Placeholder for image -->
    </div>

    <!-- Login Form (Right) -->
    <div class="col-md-4 col-12 login-form text-center">
    	<div class="">
    		<?php do_action( 'woocommerce_before_customer_login_form' );  ?>
    	</div>
        <div class="dashboard-logo mb-5">
            <a href="/"><img src="/wp-content/uploads/2024/10/yrt_new_logo-_2-jan-09.png" alt="Your Robo Trader" class="img-fluid" width="180px"></a>
        </div>

        <h1 class="mb-0"><?php esc_html_e( 'Welcome back', 'woocommerce' ); ?></h1>
        <p class="text-muted"><?php esc_html_e( 'Log in to your account', 'woocommerce' ); ?></p>

        <form class="woocommerce-form woocommerce-form-login login" method="post">

        <?php do_action( 'woocommerce_login_form_start' ); ?>


        <!-- Email Input -->
        <div class="mb-3">
            <label for="username" class="form-label"><?php esc_html_e( 'Email', 'woocommerce' ); ?></label>
            <input type="text" class="form-control" name="username" id="username" autocomplete="username" placeholder="<?php esc_html_e( 'Email', 'woocommerce' ); ?>" value="<?php echo (!empty($_POST['username'])) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>">
        </div>

        <!-- Password Input -->
        <div class="mb-3">
            <label for="password" class="form-label"><?php esc_html_e( 'Password', 'woocommerce' ); ?></label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>">
            </div>
        </div>

        <!-- Forgot Password -->
        <div class="d-flex justify-content-end mb-4">
            <a href="#"><?php esc_html_e( 'Forgot your password?', 'woocommerce' ); ?></a>
        </div>

        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
        
        <!-- Login Button -->
        <button type="submit" class="btn btn-primary w-100" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
            <?php esc_html_e( 'LOG IN', 'woocommerce' ); ?>
        </button>

        <?php do_action( 'woocommerce_login_form_end' ); ?>

    	</form>

        <!-- Signup Link -->
        <p class="text-center mt-3"><?php esc_html_e( "Don't have an account yet?", 'woocommerce' ); ?>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Sign up', 'woocommerce' ); ?></a>
        </p>

    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>