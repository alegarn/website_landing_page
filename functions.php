<?php
/**
 * Go functions and definitions - Performance Optimized
 *
 * @package Go
 */

function is_landing_page() {
    // Don't run during AJAX or admin requests
    if ((defined('DOING_AJAX') && DOING_AJAX) || is_admin()) {
        return false;
    }
    
    // Use WordPress functions after WordPress is loaded
    if (function_exists('is_front_page')) {
        return is_front_page();
    }
    
    // Fallback to URI check if WordPress functions aren't available yet
    $request_uri = $_SERVER['REQUEST_URI'];
    $clean_uri = rtrim(parse_url($request_uri, PHP_URL_PATH), '/');
    return ($clean_uri === '' || $clean_uri === '/');
}

/**
 * Load parent theme conditionally
 */
function load_parent_theme_conditionally() {
    if (!is_landing_page()) {
        // Load parent theme files
        require_once get_parent_theme_file_path( 'includes/amp.php' );
        require_once get_parent_theme_file_path( 'includes/core.php' );
        require_once get_parent_theme_file_path( 'includes/customizer.php' );
        require_once get_parent_theme_file_path( 'includes/template-tags.php' );
        require_once get_parent_theme_file_path( 'includes/pluggable.php' );
        require_once get_parent_theme_file_path( 'includes/tgm.php' );
        require_once get_parent_theme_file_path( 'includes/woocommerce.php' );
        require_once get_parent_theme_file_path( 'includes/title-meta.php' );
        require_once get_parent_theme_file_path( 'includes/classes/admin/class-go-theme-deactivation.php' );
        
        // Layouts
        foreach ( glob( get_parent_theme_file_path( 'partials/layouts/*.php' ) ) as $filename ) {
            require_once $filename;
        }
        
        // Run setup functions
        Go\AMP\setup();
        Go\Core\setup();
        Go\TGM\setup();
        Go\Customizer\setup();
        Go\WooCommerce\setup();
        Go\Title_Meta\setup();
    }
}
add_action('after_setup_theme', 'load_parent_theme_conditionally', 5);

/**
 * AJAX handlers for landing page parts
 */
function load_landing_part1() {
    error_log('load_landing_part1 called');

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'landing_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    $file_path = get_stylesheet_directory() . '/landing-parts/landing-part1.min.html';
    error_log('Looking for file: ' . $file_path);

    if (file_exists($file_path)) {
        echo file_get_contents($file_path);
    } else {
        error_log('File not found: ' . $file_path);
        wp_die('File not found');
    }
    
    wp_die();
}

function load_landing_part2() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'landing_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    $file_path = get_stylesheet_directory() . '/landing-parts/landing-part2.min.html';
    
    if (file_exists($file_path)) {
        echo file_get_contents($file_path);
    } else {
        error_log('File not found: ' . $file_path);
        wp_die('File not found');
    }
    
    wp_die();
}

// Register AJAX actions (these need to be available regardless of page)
add_action('wp_ajax_load_landing_part1', 'load_landing_part1');
add_action('wp_ajax_nopriv_load_landing_part1', 'load_landing_part1');
add_action('wp_ajax_load_landing_part2', 'load_landing_part2');
add_action('wp_ajax_nopriv_load_landing_part2', 'load_landing_part2');

/**
 * Outputs a script tag with localized data for the landing page.
 * This is called directly from header-landing.php
 */
function landing_page_js_data() {
    $ajax_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('landing_ajax_nonce')
    );
    echo '<script type="text/javascript">var ajax_object = ' . wp_json_encode( $ajax_data ) . ';</script>' . "\n";
}

/**
 * Landing page specific setup
 */
if (is_landing_page()) {
  // Only load essential WordPress functions for landing page
  if ( ! function_exists( 'wp_body_open' ) ) :
      function wp_body_open() {
          do_action( 'wp_body_open' );
      }
  endif;
}