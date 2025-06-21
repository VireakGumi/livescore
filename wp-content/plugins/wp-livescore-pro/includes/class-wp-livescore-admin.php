<?php
// Admin class
class WP_Livescore_Admin
{
    public static function init()
    {
        add_action('admin_menu', [__CLASS__, 'add_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function add_menu()
    {
        add_menu_page('Livescore Settings', 'Livescore Pro', 'manage_options', 'wp-livescore-settings', [__CLASS__, 'settings_page']);
    }

    public static function register_settings()
    {
        register_setting('wp_livescore_options', 'wp_livescore_settings');
    }

    public static function settings_page()
    {
        $data_file = WP_LIVESCORES_PLUGIN_DIR . '/data/data.json';
        $matches = file_exists($data_file) ? json_decode(file_get_contents($data_file), true) : [];
        if (!empty($_POST['new_match'])) {
            $new = array_map('sanitize_text_field', $_POST['new_match']);
            $matches[] = $new;
            file_put_contents($data_file, json_encode($matches, JSON_PRETTY_PRINT));
            echo '<div class="updated"><p>New match added.</p></div>';
        }
        if (isset($_POST['delete_index'])) {
            $index = intval($_POST['delete_index']);
            if (isset($matches[$index])) {
                unset($matches[$index]);
                $matches = array_values($matches);
                file_put_contents($data_file, json_encode($matches, JSON_PRETTY_PRINT));
                echo '<div class="updated"><p>Match deleted.</p></div>';
            }
        }
        if (isset($_POST['update_index']) && isset($_POST['update_match']) && is_array($_POST['update_match'])) {
            $index = intval($_POST['update_index']);
            if (isset($matches[$index])) {
                $matches[$index] = array_map('sanitize_text_field', $_POST['update_match']);
                file_put_contents($data_file, json_encode($matches, JSON_PRETTY_PRINT));
                echo '<div class="updated"><p>Match updated.</p></div>';
            }
        }
        ob_start();
?>
        <div class="wrap">
            <h1>Manage Matches</h1>
            <h2>Add New Match</h2>
            <form method="post">
                <table class="form-table">
                    <tr>
                        <th>League</th>
                        <td><input type="text" name="new_match[league]" required></td>
                    </tr>
                    <tr>
                        <th>Home Team</th>
                        <td><input type="text" name="new_match[home_team]" required></td>
                    </tr>
                    <tr>
                        <th>Away Team</th>
                        <td><input type="text" name="new_match[away_team]" required></td>
                    </tr>
                    <tr>
                        <th>Score</th>
                        <td><input type="text" name="new_match[score]"></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td><input type="time" name="new_match[time]" required placeholder="e.g. 20:00 or FT"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <select name="new_match[status]" required>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Live">Live</option>
                                <option value="Finished">Finished</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button('Add Match'); ?>
            </form>
            <h2>Existing Matches</h2>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th>League</th>
                        <th>Home</th>
                        <th>Away</th>
                        <th>Score</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($matches)) : ?>
                        <?php foreach (array_reverse($matches) as $reverse_index => $match) : ?>
                            <?php $index = count($matches) - 1 - $reverse_index; ?>
                            <tr>
                                <form method="post">
                                    <td><input type="text" name="update_match[league]" value="<?= esc_attr($match['league']) ?>" required></td>
                                    <td><input type="text" name="update_match[home_team]" value="<?= esc_attr($match['home_team']) ?>" required></td>
                                    <td><input type="text" name="update_match[away_team]" value="<?= esc_attr($match['away_team']) ?>" required></td>
                                    <td><input type="text" name="update_match[score]" value="<?= esc_attr($match['score']) ?>"></td>
                                    <td><input type="time" name="update_match[time]" value="<?= esc_attr($match['time']) ?>" required></td>
                                    <td>
                                        <select name="update_match[status]">
                                            <option value="Scheduled" <?= selected($match['status'], 'Scheduled', false) ?>>Scheduled</option>
                                            <option value="Live" <?= selected($match['status'], 'Live', false) ?>>Live</option>
                                            <option value="Finished" <?= selected($match['status'], 'Finished', false) ?>>Finished</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="update_index" value="<?= $index ?>">
                                        <button type="submit" name="update_button" class="button button-primary">Update</button>
                                        <button type="submit" name="delete_index" value="<?= $index ?>" class="button delete">Delete</button>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">No matches found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
<?php
        echo ob_get_clean();
    }
}
