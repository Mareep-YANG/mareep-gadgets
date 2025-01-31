<?php
// 将区块属性转换为数据属性
$block_data = array(
    'apiEndpoint' => rest_url('mareep-gadgets/v1/data'),
    'showNowPlaying' => $attributes['showNowPlaying'],
    'showWeeklyStats' => $attributes['showWeeklyStats'],
);
?>

<div 
    class="wp-block-music-stats" 
    data-settings="<?php echo esc_attr(json_encode($block_data)); ?>"
>
    <div class="music-stats-loading">加载中...</div>
</div>