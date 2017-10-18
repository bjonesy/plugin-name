<?php
/**
 * Render a message in the admin screen.
 *
 * @package PluginName\Admin
 */

namespace PluginName\Admin;

/**
 * This file adds an admin notice when creating / editing a post
 *
 * Create a admin notice
 *
 * @package PluginName\Admin
 */
class Admin_Notice {
	/**
	 * Initialize the admin js file
	 */
	public function init() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_js' ) );
		}
	}

	 /**
	 * Load the video helper JS
	 *
	 * @param $hook - $hook_suffix for the current admin page.
	 */
	public function admin_js( $hook ) {
		// Get screen object.
		$screen = get_current_screen();
		if ( is_admin() && ( 'post-type' === $screen->id ) ) {

			if ( 'edit.php' === $hook ) {
				return;
			}

			wp_enqueue_script( 'admin-notice', plugins_url( '/dist/admin.js', PLUGINNAME_PLUGIN_FILE ), array( 'jquery' ), null, true );
		}
	}
}
