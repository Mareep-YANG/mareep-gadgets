<?php
/**
 * Plugin Name:       Lastfm Listening History
 * Description:       Show Last.FM Listening data 
 * Version:           0.1.0
 * Requires at least: 6.7
 * Author:            Mareep
 * License:           GPL-2.0
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lastfm-listening-history
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_lastfm_listening_history_block_init() {
	register_block_type( __DIR__ . '/build/lastfm-listening-history' );
}
add_action( 'init', 'create_block_lastfm_listening_history_block_init' );
