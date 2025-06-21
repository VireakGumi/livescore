
<?php
/*
Plugin Name: WP Livescore Pro
Description: Displays live football scores via shortcode and admin-controlled crawler system.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly
defined('ABSPATH') || exit;

// Define constants
define('WP_LIVESCORES_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_LIVESCORES_PLUGIN_URL', plugin_dir_url(__FILE__));

define('WP_LIVESCORES_TRANSIENT_KEY', 'wp_livescore_matches');
// Include required files
include_once WP_LIVESCORES_PLUGIN_DIR . 'includes/class-wp-livescore-shortcode.php';
include_once WP_LIVESCORES_PLUGIN_DIR . 'includes/class-wp-livescore-admin.php';
include_once WP_LIVESCORES_PLUGIN_DIR . 'includes/class-wp-livescore-crawler.php';

// Initialize plugin
function wp_livescore_pro_init() {
    WP_Livescore_Shortcode::init();
    WP_Livescore_Admin::init();
    WP_Livescore_Crawler::init();
}
add_action('plugins_loaded', 'wp_livescore_pro_init');