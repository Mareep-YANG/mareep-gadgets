<?php
if (!defined('ABSPATH')) exit;

class Mareep_Music_Data {
    // 单例模式
    private static $instance;

    public static function get_instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('rest_api_init', [$this, 'register_rest_routes']);
    }

    // 注册REST端点
    public function register_rest_routes() {
        register_rest_route('mareep-gadgets/v1', '/data', [
            'methods' => 'GET',
            'callback' => [$this, 'get_music_data'],
            'permission_callback' => '__return_true',
        ]);
    }

    // 获取音乐数据
    public function get_music_data() {
        $server_url = get_option('music_server_url');
        $username = get_option('music_username');
        $token = get_option('music_access_token');
        $music_top_tracks_count = get_option('music_top_tracks_count');

        if (empty($server_url) || empty($username) || empty($token) || empty($music_top_tracks_count)) {
            return new WP_Error('missing_config', '配置缺失');
        }

        $music_info = $this->fetch_music_info($server_url, $username, $token);
        if (is_wp_error($music_info)) {
            return $music_info;
        }

        return $this->format_response_data($music_info);
    }

    // 从远程API获取数据
    private function fetch_music_info($server_url, $username, $token) {
        $response = wp_remote_get(
            sprintf('%s/apigw/info/?username=%s', $server_url, $username),
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'WordPress',
                ],
                'timeout' => 15
            ]
        );

        if (is_wp_error($response)) {
            return $response;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (!$body || json_last_error() !== JSON_ERROR_NONE) {
            return new WP_Error('invalid_json', '无效的响应格式');
        }

        return $body;
    }

    // 格式化响应数据
    private function format_response_data($music_info) {
        $data = [
            'nowPlaying' => null,
            'trackCount' => $music_info['track_count'] ?? 0,
        ];

        if (!empty($music_info['now_playing'])) {
            $parts = explode(' - ', $music_info['now_playing'], 2);
            $data['nowPlaying'] = [
                'artist' => $parts[0] ?? '',
                'name' => $parts[1] ?? $music_info['now_playing']
            ];
        }

        return $data;
    }
}

// 初始化音乐数据模块
Mareep_Music_Data::get_instance();