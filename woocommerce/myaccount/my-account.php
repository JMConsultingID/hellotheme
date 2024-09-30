<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
?>


<div class="woocommerce-dashboard-container container-fluid">

    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="woocommerce-dashboard-navigation dashboard-column col-lg-2 col-md-3 d-none d-md-block dashboard-sidebar fixed-sidebar">
            <?php 
                echo '<h4>' . __('EA Licenses', 'ealicensewoocommerce') . '</h4>';
                do_action( 'woocommerce_account_navigation' ); 
            ?>
        </div>

        <!-- Main Content -->
        <div class="woocommerce-dashboard-content dashboard-column col-lg-10 col-md-9 main-content">
        	<div class="d-flex justify-content-between mb-4">
                <h3><?php echo __('EA Licenses', 'ealicensewoocommerce'); ?></h3>
                <div class="welcome-text d-none d-md-block">
                    <p><?php echo __('Welcome, ', 'ealicensewoocommerce') . '<strong>' . wp_get_current_user()->display_name . '</strong>'; ?></p>
                </div>
                <!-- Hamburger Button for Mobile -->
                <button class="btn d-md-none nav-offcanvas float-end" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasMobile" aria-controls="offcanvasMobile">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <div class="woocommerce-MyAccount-content">
                <?php
                    /**
                     * My Account content.
                     *
                     * @since 2.6.0
                     */
                    do_action( 'woocommerce_account_content' );
                ?>
                
        	</div>

	        <!-- Offcanvas Menu for Mobile -->
			<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMobile" aria-labelledby="offcanvasMobileLabel">
			    <div class="offcanvas-header">
			        <h5 class="offcanvas-title" id="offcanvasMobileLabel"><?php echo __('EA Licenses', 'ealicensewoocommerce'); ?></h5>
			        <button type="button" class="nav-offcanvas" data-bs-dismiss="offcanvas" aria-label="Close">
			            <i class="bi bi-x"></i>
			        </button>
			    </div>
			    <div class="offcanvas-body">
			        <?php 
			            do_action( 'woocommerce_account_navigation' ); 
			        ?>
			    </div>
			</div>

    	</div>
	</div>

</div>

