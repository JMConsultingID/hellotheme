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
        <!-- Monile TopBar Offcanvas -->
        <div class="d-flex justify-content-between mb-4 d-md-none dashboard-mobile-topbar p-3">
            <div class="dashboard-logo pt-2">
                <a href="/my-account/"><img src="https://yourrobotrader.com/wp-content/uploads/2022/08/new-logo-12-jan-14-1024x158.webp" alt="Your Robo Trader" class="img-fluid" width="180px"></a>
            </div>
            <!-- Hamburger Button for Mobile -->
            <button class="btn d-md-none nav-offcanvas float-end" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasMobile" aria-controls="offcanvasMobile">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <!-- Sidebar Navigation -->
        <div class="woocommerce-dashboard-navigation dashboard-column col-xl-2 col-lg-3 col-md-3 d-none d-md-block dashboard-sidebar fixed-sidebar">
            <?php 
                echo '<div class="dashboard-logo">';
		        echo '<a href="/my-account/"><img src="https://yourrobotrader.com/wp-content/uploads/2022/08/new-logo-12-jan-14-1024x158.webp" alt="Your Robo Trader" class="img-fluid mb-3" width="180px"></a>';
		        echo '</div>';
                do_action( 'woocommerce_account_navigation' ); 
            ?>
        </div>

        <!-- Main Content -->
        <div class="woocommerce-dashboard-content dashboard-column col-xl-10 col-lg-9 col-md-9 main-content">
        	<div class="d-flex justify-content-between mb-4 d-none d-md-flex">
                <h4 style="padding: 0;margin: 0;"><?php echo __('EA Licenses', 'ealicensewoocommerce'); ?></h4>
                <div class="welcome-text d-none d-md-block">
                    <p><?php echo __('Welcome, ', 'ealicensewoocommerce') . '<strong>' . wp_get_current_user()->display_name . '</strong>'; ?></p>
                </div>
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
                <button type="button" class="nav-offcanvas offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                </button>
			    <div class="offcanvas-header">
			        <div class="dashboard-logo">
		       			<a href="/my-account/"><img src="https://yourrobotrader.com/wp-content/uploads/2022/08/new-logo-12-jan-14-1024x158.webp" alt="Your Robo Trader" class="img-fluid" width="180px"></a>
		        	</div>
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

