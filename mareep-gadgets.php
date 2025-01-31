<?php
/**
 * Plugin Name:       Mareep's Gadgets
 * Description:       Show some data 
 * Version:           0.1.0
 * Requires at least: 6.7
 * Author:            Mareep
 * License:           GPL-2.0
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mareep-gadgets
 *
 * @package CreateBlock
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
require_once plugin_dir_path(__FILE__) . 'includes/class-music-data.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-coding-data.php';

// 添加管理菜单
add_action('admin_menu', function() {
    add_options_page(
        'Mareep的小工具',
        'Mareep的小工具',
        'manage_options',
        'mareep-gadgets',
        'music_stats_settings_page'
    );
});
// 注册设置
add_action('admin_init', function() {
    //服务器地址
    register_setting('manage_options', 'music_server_url');
    //用户名
    register_setting('manage_options', 'music_username');
    //Token
    register_setting('manage_options', 'music_access_token');
    //显示几个排行
    register_setting('manage_options', 'music_top_tracks_count');

});
// 设置页面
function music_stats_settings_page() {
    // 获取设置值
    $settings = [
        'server_url'        => get_option('music_server_url'),
        'username'         => get_option('music_username'),
        'access_token'     => get_option('music_access_token'),
        'top_tracks_count' => get_option('music_top_tracks_count')
    ];

    // 渲染模板
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/admin-settings-template.php';
    echo ob_get_clean();
}

// 注册区块
function register_blocks() {
    register_block_type(__DIR__ . '/build/music-stats');
    register_block_type(__DIR__ . '/build/coding-stats');
}
add_action('init', 'register_blocks');



