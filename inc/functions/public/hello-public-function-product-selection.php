<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * @package HelloTheme
 */

function hello_theme_challenge_selection_shortcode() {
    ob_start();
    ?>
    <div class="product-selection-container">
        <!-- Add your HTML here as per the uploaded design -->
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('challenge_selection', 'hello_theme_challenge_selection_shortcode');