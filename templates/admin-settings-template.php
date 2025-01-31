<?php
$music_server_url = get_option('music_server_url');
$music_username = get_option('music_username');
$music_access_token = get_option('music_access_token');
$music_top_tracks_count = get_option('music_top_tracks_count');
?>
<div class="wrap">
    <h2>音乐情况设置</h2>
    <form method="post" action="options.php">
        <?php settings_fields('manage_options'); ?>
        <table class="form-table">
            <tr>
                <th>服务器地址</th>
                <td>
                    <input type="text" name="music_server_url" 
                           value="<?php echo esc_attr($music_server_url); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th>用户名</th>
                <td>
                    <input type="text" name="music_username" 
                           value="<?php echo esc_attr($music_username); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th>Token</th>
                <td>
                    <input type="text" name="music_access_token" 
                           value="<?php echo esc_attr($music_access_token); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th>显示几个排行</th>
                <td>
                    <input type="number" name="music_top_tracks_count" 
                           value="<?php echo esc_attr($music_top_tracks_count); ?>" 
                           class="small-text">
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>