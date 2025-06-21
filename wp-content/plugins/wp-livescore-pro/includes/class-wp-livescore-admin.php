<?php
// Admin class
class WP_Livescore_Admin {
    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function add_menu() {
        add_menu_page('Livescore Settings', 'Livescore Pro', 'manage_options', 'wp-livescore-settings', [__CLASS__, 'settings_page']);
    }

    public static function register_settings() {
        register_setting('wp_livescore_options', 'wp_livescore_settings');
    }

    public static function settings_page() {
        $settings = get_option('wp_livescore_settings', []);
        echo '<div class="wrap"><h1>WP Livescore Settings</h1><form method="post" action="options.php">';
        settings_fields('wp_livescore_options');
        echo '<table class="form-table">
                <tr><th scope="row">Update Frequency (minutes)</th><td><input type="number" name="wp_livescore_settings[frequency]" value="' . esc_attr($settings['frequency'] ?? 5) . '" min="1"></td></tr>
                <tr><th scope="row">Max Matches</th><td><input type="number" name="wp_livescore_settings[max_matches]" value="' . esc_attr($settings['max_matches'] ?? 50) . '"></td></tr>
              </table>';
        submit_button();
        echo '</form></div>';
    }
}
