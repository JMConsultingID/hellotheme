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
        <div class="woocommerce-dashboard-navigation dashboard-column col-md-3 d-none d-md-block dashboard-sidebar">
            <?php 
                echo '<h4>' . __('EA Licenses', 'ealicensewoocommerce') . '</h4>';
                do_action( 'woocommerce_account_navigation' ); 
            ?>
        </div>

        <!-- Main Content -->
        <div class="woocommerce-dashboard-content dashboard-column col-md-9 main-content">
        	<div class="d-flex justify-content-between mb-4">
                <h3><?php echo __('EA Licenses', 'ealicensewoocommerce'); ?></h3>
                <div class="welcome-text d-none d-md-block">
                    <p><?php echo __('Welcome, ', 'ealicensewoocommerce') . '<strong>' . wp_get_current_user()->display_name . '</strong>'; ?></p>
                </div>
                <!-- Hamburger Button for Mobile -->
                <button class="btn d-md-none offcanvas" type="button" data-bs-toggle="offcanvas"
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
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-youtube meta-icon"></i>
                    <p class="mb-0 ms-3">Feeling a bit lost? <a href="#">Click here to watch a tutorial video</a></p>
                </div>

                <div class="row g-3">
                    <!-- Card 1 -->
                    <div class="col-md-4">
                        <div class="card card-dashboard p-3">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="PerceptTrader">
                            <div class="card-body">
                                <h5 class="card-title">PERCEPTTRADER AI</h5>
                                <p class="card-text">Last version: 2.23</p>
                                <a href="#" class="btn btn-custom w-100 mb-2">Download</a>
                                <a href="#" class="btn btn-outline-dark w-100 mb-2">Tutorial</a>
                                <a href="#" class="btn btn-outline-dark w-100">Start Trial</a>
                            </div>
                        </div>
                    </div>

                     <!-- Card 2 -->
                    <div class="col-md-4">
                        <div class="card card-dashboard p-3">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="GoldenPickaxe">
                            <div class="card-body">
                                <h5 class="card-title">GOLDEN PICKAXE</h5>
                                <p class="card-text">Last version: 2.23</p>
                                <a href="#" class="btn btn-custom w-100 mb-2">Download</a>
                                <a href="#" class="btn btn-outline-dark w-100 mb-2">Tutorial</a>
                                <a href="#" class="btn btn-outline-dark w-100">Start Trial</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-4">
                        <div class="card card-dashboard p-3">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="WakaWaka">
                            <div class="card-body">
                                <h5 class="card-title">WAKAWAKA</h5>
                                <p class="card-text">Last version: 4.43</p>
                                <a href="#" class="btn btn-custom w-100 mb-2">Download</a>
                                <a href="#" class="btn btn-outline-dark w-100 mb-2">Tutorial</a>
                                <a href="#" class="btn btn-outline-dark w-100">Start Trial</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-md-4">
                        <div class="card card-dashboard p-3">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="NewsCatcher">
                            <div class="card-body">
                                <h5 class="card-title">NEWSCATCHER PRO</h5>
                                <p class="card-text">Last version: 4.24</p>
                                <a href="#" class="btn btn-custom w-100 mb-2">Download</a>
                                <a href="#" class="btn btn-outline-dark w-100 mb-2">Tutorial</a>
                                <a href="#" class="btn btn-outline-dark w-100">Start Trial</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="col-md-4">
                        <div class="card card-dashboard p-3">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="EveningScalper">
                            <div class="card-body">
                                <h5 class="card-title">EVENING SCALPER</h5>
                                <p class="card-text">Last version: 2.56</p>
                                <a href="#" class="btn btn-custom w-100 mb-2">Download</a>
                                <a href="#" class="btn btn-outline-dark w-100 mb-2">Tutorial</a>
                                <a href="#" class="btn btn-outline-dark w-100">Start Trial</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="col-md-4">
                        <div class="card card-dashboard p-3">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="NightHunterPro">
                            <div class="card-body">
                                <h5 class="card-title">NIGHTHUNTER PRO</h5>
                                <p class="card-text">Last version: 2.23</p>
                                <a href="#" class="btn btn-custom w-100 mb-2">Download</a>
                                <a href="#" class="btn btn-outline-dark w-100 mb-2">Tutorial</a>
                                <a href="#" class="btn btn-outline-dark w-100">Start Trial</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <!-- Offcanvas Menu for Mobile -->
		<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMobile" aria-labelledby="offcanvasMobileLabel">
		    <div class="offcanvas-header">
		        <h5 class="offcanvas-title" id="offcanvasMobileLabel"><?php echo __('EA Licenses', 'ealicensewoocommerce'); ?></h5>
		        <button type="button" class="btn-close offcanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		    </div>
		    <div class="offcanvas-body">
		        <?php 
		            do_action( 'woocommerce_account_navigation' ); 
		        ?>
		    </div>
		</div>
    </div>
</div>

