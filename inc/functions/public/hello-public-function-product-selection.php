<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

function hello_theme_challenge_selection_shortcode($atts) {
    $enabled_pricing_table = get_option('hello_theme_enable_table_pricing');
    $atts = shortcode_atts(
        array(
            'mode' => 'mode-1',
            'category' => '',
        ),
        $atts,
        'hello_challenge_selection'
    );

    if ($enabled_pricing_table !== '1') {
        return;
    }
    ob_start();
    ?>
    <div class="hello-theme-product selection product-selection-container product-id">
        <!-- Add your HTML here as per the uploaded design -->
        <p>No products found in this category.</p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('hello_challenge_selection', 'hello_theme_challenge_selection_shortcode');