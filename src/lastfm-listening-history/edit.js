import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import './editor.scss';
export default function Edit({ attributes, setAttributes }) {
	const { apiKey, username, limit } = attributes
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'lastfm-listening-history')}>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={__('apiKey', 'lastfm-listening-histor')}
						value={apiKey || ''}
						onChange={(value) =>
							setAttributes({ apiKey: value })
						}>
					</TextControl>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={__('username', 'lastfm-listening-histor')}
						value={username || ''}
						onChange={(value) =>
							setAttributes({ username: value })
						}>
					</TextControl>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={__('limit', 'lastfm-listening-histor')}
						value={limit || ''}
						onChange={(value) =>
							setAttributes({ limit: value })
						}>
					</TextControl>
				</PanelBody>
			</InspectorControls>
			<p {...useBlockProps()}>123</p>
		</>
	);
}
