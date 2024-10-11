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
        <div class="d-flex justify-content-between mb-md-4 mb-sm-0 d-md-none dashboard-mobile-topbar position-fixed p-3">
            <div class="dashboard-logo pt-2">
                <a href="/my-account/"><img src="https://yourrobotrader.com/wp-content/uploads/2024/10/yourrobotrader.com_ea_dashboard_green.png" alt="Your Robo Trader" class="img-fluid" width="180px">
                </a>
            </div>
            <!-- Hamburger Button for Mobile -->
            <button class="btn d-md-none nav-offcanvas float-end" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasMobile" aria-controls="offcanvasMobile">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <!-- Sidebar Navigation -->
        <div class="woocommerce-dashboard-navigation dashboard-column col-xxl-2 col-xl-3 col-lg-3 col-md-3 d-none d-md-block dashboard-sidebar position-fixed top-0 start-0">
            <?php 
                echo '<div class="dashboard-logo px-md-3">';
		        echo '<a href="/my-account/"><img src="https://yourrobotrader.com/wp-content/uploads/2024/10/yourrobotrader.com_ea_dashboard_green.png" alt="Your Robo Trader" class="img-fluid" width="180px" style="margin-bottom:48px;"></a>';
		        echo '</div>';
                do_action( 'woocommerce_account_navigation' ); 
            ?>
        </div>

        <!-- Main Content -->
        <div class="woocommerce-dashboard-content dashboard-column col-xxl-10 col-xl-9 col-lg-9 col-md-9 main-content ms-sm-auto min-vh-100">
        	<div class="d-flex justify-content-between mb-1 d-md-flex text-md-start text-start px-md-2">
                <p class="p-0 m-0"><strong><?php echo ealicensewoocommerce_get_current_title(); ?></strong></p>
                <div class="welcome-text d-md-block d-flex text-end">
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
		       			<a href="/my-account/"><img src="https://yourrobotrader.com/wp-content/uploads/2024/10/yourrobotrader.com_ea_dashboard_green.png" alt="Your Robo Trader" class="img-fluid" width="180px"></a>
		        	</div>
			    </div>
			    <div class="offcanvas-body">
			        <?php 
			            do_action( 'woocommerce_account_navigation' ); 
			        ?>
			    </div>
			</div>

            <footer class="footer mt-auto">
              <div class="container text-center">
                <span class="text-muted">&copy; <?php echo date("Y"); ?> yourrobotrader.com. All rights reserved.</span>
              </div>
            </footer>

    	</div>
	</div>

</div>

