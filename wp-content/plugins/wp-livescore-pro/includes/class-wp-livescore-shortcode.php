<?php
class WP_Livescore_Shortcode
{
    public static function init()
    {
        add_shortcode('wp_livescore', [__CLASS__, 'render']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_scripts']);
        add_action('wp_ajax_nopriv_wp_livescore_refresh', [__CLASS__, 'ajax_refresh']);
        add_action('wp_ajax_wp_livescore_refresh', [__CLASS__, 'ajax_refresh']);
    }

    public static function enqueue_scripts()
    {
        wp_enqueue_style('wp-livescore-style', WP_LIVESCORES_PLUGIN_URL . 'assets/css/style.css');
        wp_enqueue_script('wp-livescore-script', WP_LIVESCORES_PLUGIN_URL . 'assets/js/script.js', ['jquery'], null, true);
        wp_localize_script('wp-livescore-script', 'wpLivescore', [
            'ajax_url'    => admin_url('admin-ajax.php'),
            'plugin_url'  => WP_LIVESCORES_PLUGIN_URL,
        ]);
    }

    public static function render($atts)
    {
        ob_start();
?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="bg-white p-3 shadow-sm rounded">
                        <h5 class="fw-bold">Pinned Leagues</h5>
                        <ul class="list-unstyled mt-3 mb-0" id="league-list">
                            <li><a href="#" class="league-link text-dark" data-league="Premier League">Premier League</a></li>
                            <li><a href="#" class="league-link text-dark" data-league="Ligue 1">Ligue 1</a></li>
                            <li><a href="#" class="league-link text-dark" data-league="Bundesliga">Bundesliga</a></li>
                            <li><a href="#" class="league-link text-dark" data-league="Serie A">Serie A</a></li>
                            <li><a href="#" class="league-link text-dark" data-league="LaLiga">LaLiga</a></li>
                            <li><a href="#" class="league-link text-dark" data-league="Champions League">Champions League</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <button class="btn btn-dark btn-sm league-filter" data-league="All">All</button>
                        <button class="btn btn-outline-primary btn-sm league-filter" data-league="Live">Live</button>
                        <button class="btn btn-outline-success btn-sm league-filter" data-league="Finished">Finished</button>
                        <button class="btn btn-outline-warning btn-sm league-filter" data-league="Scheduled">Scheduled</button>
                        <!-- <input type="text" id="team-search" class="form-control form-control-sm ms-auto" placeholder="Search team..." style="max-width: 200px;"> -->
                    </div>
                    <div id="wp-livescore-output" class="d-grid gap-3">
                    </div>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }

    public static function ajax_refresh()
    {
        $matches = get_transient(WP_LIVESCORES_TRANSIENT_KEY);
        wp_send_json_success($matches ?: []);
    }
}
?>