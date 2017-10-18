<?php
/**
 * Render a message on the front end.
 *
 * @package PluginName\Public_Notice
 */

namespace PluginName\Pub;

/**
 * This file shows a message on the post-type posts
 *
 * Front end admin notice
 *
 * @package PluginName\Public_Notice
 */
class Public_Notice {
	/**
	 * Initialize the public js file
	 *
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'public_js' ) );
	}

	/**
	 * Load the public JS file
	 *
	 */
	public function public_js() {
		if ( is_singular( 'post-type' ) ) {
			wp_enqueue_script( 'public-notice', plugins_url( '/dist/public.js', PLUGINNAME_PLUGIN_FILE ), array( 'jquery' ), null, true );
		}
	}
}
