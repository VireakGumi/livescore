<?php
// Crawler class
class WP_Livescore_Crawler
{
    public static function init()
    {
        // Register the crawl event
        add_action('wp_livescore_crawl_event', [__CLASS__, 'crawl']);

        // Schedule the cron job if not already scheduled
        if (!wp_next_scheduled('wp_livescore_crawl_event')) {
            wp_schedule_event(time(), 'every_five_minutes', 'wp_livescore_crawl_event');
        }

        // Add custom interval for cron
        add_filter('cron_schedules', function ($schedules) {
            $schedules['every_five_minutes'] = [
                'interval' => 300,
                'display'  => __('Every 5 Minutes')
            ];
            return $schedules;
        });
    }

    public static function crawl()
    {
        // Load match data from local JSON file
        $file = plugin_dir_path(__FILE__) . '../data/data.json';

        if (file_exists($file)) {
            $json = file_get_contents($file);
            $matches = json_decode($json, true);

            if (is_array($matches)) {
                set_transient(WP_LIVESCORES_TRANSIENT_KEY, $matches, 60);
            } else {
                error_log('WP_Livescore_Crawler: Invalid JSON structure.');
            }
        } else {
            error_log("WP_Livescore_Crawler: File not found at $file");
        }
    }
}
