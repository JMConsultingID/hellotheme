<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */
function hello_pricing_table_level_2_shortcode() {
    if ( get_option( 'hello_theme_enable_table_pricing' ) === '1' ) {
        ob_start();
        ?>
        <div class="hello-theme-container hello-theme-table-pricing hello-theme-with-tab">
        <!-- Main Tabs -->
        <div class="hello-theme-tab-buttons">
            <div class="hello-theme-tab-button active" data-tab-id="tab1">Original</div>
            <div class="hello-theme-tab-button" data-tab-id="tab2">Evolution</div>
        </div>

        <!-- Tab 1 Contents -->
        <div id="tab1" class="hello-theme-tab-content active" data-tab-id="tab1">
            <!-- Sub Tabs for Tab 1 -->
            <div class="hello-theme-sub-tab-buttons">
                <div class="hello-theme-sub-tab-button active" data-sub-tab-id="subtab1-1">Original 5K</div>
                <div class="hello-theme-sub-tab-button" data-sub-tab-id="subtab1-2">Original 10K</div>
                <div class="hello-theme-sub-tab-button" data-sub-tab-id="subtab1-3">Original 15K</div>
            </div>

            <!-- Sub Tab 1.1 Content -->
            <div id="subtab1-1" class="hello-theme-sub-tab-content active" data-sub-tab-id="subtab1-1">
                <?php echo render_pricing_table('Original 5K'); ?>
            </div>
            <!-- Sub Tab 1.2 Content -->
            <div id="subtab1-2" class="hello-theme-sub-tab-content" data-sub-tab-id="subtab1-2">
                <?php echo render_pricing_table('Original 10K'); ?>
            </div>
            <!-- Sub Tab 1.3 Content -->
            <div id="subtab1-3" class="hello-theme-sub-tab-content" data-sub-tab-id="subtab1-3">
                <?php echo render_pricing_table('Original 15K'); ?>
            </div>
        </div>

        <!-- Tab 2 Contents -->
        <div id="tab2" class="hello-theme-tab-content" data-tab-id="tab2">
            <!-- Sub Tabs for Tab 2 -->
            <div class="hello-theme-sub-tab-buttons">
                <div class="hello-theme-sub-tab-button active" data-sub-tab-id="subtab2-1">Evolution 5K</div>
                <div class="hello-theme-sub-tab-button" data-sub-tab-id="subtab2-2">Evolution 10K</div>
                <div class="hello-theme-sub-tab-button" data-sub-tab-id="subtab2-3">Evolution 15K</div>
            </div>

            <!-- Sub Tab 2.1 Content -->
            <div id="subtab2-1" class="hello-theme-sub-tab-content active" data-sub-tab-id="subtab2-1">
                <?php echo render_pricing_table('Evolution 5K'); ?>
            </div>
            <!-- Sub Tab 2.2 Content -->
            <div id="subtab2-2" class="hello-theme-sub-tab-content" data-sub-tab-id="subtab2-2">
                <?php echo render_pricing_table('Evolution 10K'); ?>
            </div>
            <!-- Sub Tab 2.3 Content -->
            <div id="subtab2-3" class="hello-theme-sub-tab-content" data-sub-tab-id="subtab2-3">
                <?php echo render_pricing_table('Evolution 15K'); ?>
            </div>
        </div>
        </div>

        <?php
        return ob_get_clean();
    } else {
        return '<p>Table pricing is not enabled.</p>';
    }
}
add_shortcode( 'hello_pricing_table_level_2', 'hello_pricing_table_level_2_shortcode' );

