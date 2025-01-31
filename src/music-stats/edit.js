import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
  const { apiKey, username, showNowPlaying, showWeeklyStats } = attributes;

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody title="Music 设置">
          <ToggleControl
            label="显示当前播放"
            checked={showNowPlaying}
            onChange={() => setAttributes({ showNowPlaying: !showNowPlaying })}
          />
          <ToggleControl
            label="显示周统计"
            checked={showWeeklyStats}
            onChange={() => setAttributes({ showWeeklyStats: !showWeeklyStats })}
          />
        </PanelBody>
      </InspectorControls>
      <div className="lastfm-stats-preview">
        <h3>Music 统计预览</h3>
        {showNowPlaying && <div className="now-playing-preview">当前播放区域</div>}
        {showWeeklyStats && <div className="weekly-stats-preview">周统计区域</div>}
      </div>
    </div>
  );
}
