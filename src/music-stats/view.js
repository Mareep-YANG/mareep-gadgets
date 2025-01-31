// 使用立即执行函数封装作用域
(function($, pjax) {
    // 存储音乐组件状态
    let musicWidget = {
      timer: null,
      container: null,
      settings: null
    };
  
    // 主初始化函数
    function initMusicWidget() {
      // 获取最新容器（兼容 Pjax 场景）
      musicWidget.container = document.querySelector('.wp-block-music-stats');
      
      // 容器不存在时清理资源
      if (!musicWidget.container) {
        destroyMusicWidget();
        return;
      }
  
      // 避免重复初始化
      if (musicWidget.container.dataset.initialized) return;
      musicWidget.container.dataset.initialized = "true";
      
      // 解析设置
      musicWidget.settings = JSON.parse(musicWidget.container.dataset.settings);
  
      // 创建播放容器（条件判断优化）
      if (!document.getElementById('now-playing-wrapper')) {
        const playerContainer = document.createElement('div');
        playerContainer.id = 'now-playing-wrapper';
        musicWidget.container.appendChild(playerContainer);
      }
  
      // 启动数据更新
      startPolling();
    }
  
    // 数据轮询逻辑
    function startPolling() {
      // 先立即执行一次
      updateMusicData();
      
      // 清除旧定时器
      if (musicWidget.timer) clearInterval(musicWidget.timer);
      
      // 设置新定时器
      musicWidget.timer = setInterval(updateMusicData, 30000);
    }
  
    // 数据更新逻辑
    async function updateMusicData() {
      try {
        const response = await fetch(musicWidget.settings.apiEndpoint);
        const data = await response.json();
        
        // 构建完整 HTML 结构
        let html = '';
        if (musicWidget.settings.showNowPlaying) {
            if (data.nowPlaying) {
                html += `
          <div class="music-count">
              <span class="count-number">${data.trackCount}段</span>
              <span class="count-text">旋律在潮汐中沉浮</span>
          </div>
      `;
                html += `
          <div class="music-now-playing">
              <div class="now-playing-header">耳畔潮汐</div>
              <div class="now-playing-content">
                  <div class="track-info">
                      <div class="track-name">${data.nowPlaying.name}</div>
                      <div class="artist-name">${data.nowPlaying.artist}</div>
                  </div>
              </div>
          </div>`;
            } else {
                html += `
          <div class="music-count">
              <span class="count-number">${data.trackCount}首</span>
              <span class="count-text">暗礁下的休眠珊瑚</span>
          </div>
      `;
                html += `
          <div class="music-now-playing">
              <div class="now-playing-header">耳畔暗礁</div>
              <div class="now-playing-content">
                  <div class="track-info">
                      <div class="track-name">我没有听歌呢</div>
                      <div class="artist-name">快给我推些歌听吧</div>
                  </div>
              </div>
          </div>`;
            }
        }
        else {
            html += `
      <div class="music-count">
          <span class="count-number">${data.trackCount}首</span>
          <span class="count-text">暗礁下的休眠珊瑚</span>
      </div>
  `;
        }
        // 一次性更新容器
        musicWidget.container.innerHTML = html;
        musicWidget.container.classList.remove('loading');
        
      } catch (error) {
        console.error('获取数据失败:', error);
      }
    }
  
    // 销毁组件
    function destroyMusicWidget() {
      if (musicWidget.timer) {
        clearInterval(musicWidget.timer);
        musicWidget.timer = null;
      }
      if (musicWidget.container) {
        delete musicWidget.container.dataset.initialized;
        musicWidget.container = null;
      }
    }
  
    // 初始加载
    $(document).ready(initMusicWidget);
  
    // Pjax 事件监听（核心部分）
    $(document)
      // Pjax 开始前清理
      .on('pjax:start', function() {
        if (musicWidget.container) {
          musicWidget.container.classList.add('music-widget-exiting');
          destroyMusicWidget();
        }
      })
      // Pjax 完成后初始化
      .on('pjax:end', initMusicWidget)
      // 兼容部分主题的 Pjax 实现
      .on('pjax:complete', initMusicWidget);
  
    // 浏览器前进/后退处理
    window.addEventListener('popstate', function() {
      setTimeout(initMusicWidget, 50); // 等待 DOM 更新
    });
  
  })(jQuery, window.pjax);