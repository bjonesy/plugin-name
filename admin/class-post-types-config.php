<?php
/**
 * Create post types and taxonomies.
 *
 * @package PluginName\Admin
 */

namespace PluginName\Admin;

/**
 * This file adds custom post types and taxonomies
 *
 * Register any custom post types and taxonomies
 *
 * @package PluginName\Admin
 */
class Post_Types_Config {
	/**
	 * Initialize the custom post types
	 * Add the custom post types that should be accessible in the WordPress API
	 */
	public function init() {
		add_action( 'init', array( $this, 'create_post_type' ), 20, 3 );
		add_filter( 'rest_api_allowed_post_types', array( $this, 'allow_video_post_type' ) );
	}

	/**
	 * Register our custom post types
	 */
	public function create_post_type() {
		/**
		 * Register the video-suite custom post type
		 */
		register_post_type('post-type',
			array(
				'labels'        => array(
					'name'          => __( 'Post Type' ),
					'singular_name' => __( 'Post Type' ),
				),
				'description'   => '',
				'public'        => true,
				'has_archive'   => true,
				'menu_position' => 12,
				'menu_icon'     => 'dashicons-welcome-add-page',
				'rewrite'       => false,
				'supports'      => array( 'title', 'revisions', 'thumbnail', 'page-attributes' ),
			)
		);

		/**
		 * Register the video-suite-service taxonomy
		 */
		register_taxonomy('post-type-taxonomy', 'post-type',
			array(
				'hierarchical'      => false,
				'labels'            => array(
					'name'          => __( 'Taxonomies' ),
					'singular_name' => __( 'Taxonomy' ),
				),
				'rewrite'           => false,
				'show_admin_column' => true,
			)
		);
	}

	/**
	 * Allow custom post types in public API
	 *
	 * @name $allowed_post_types
	 * @return array
	 */
	public function allow_video_post_type( $allowed_post_types ) {
		$allowed_post_types[] = 'post-type';
		return $allowed_post_types;
	}
}