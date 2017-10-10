<?php
/**
 * Adds custom fields to the video-suite custom post type.
 *
 * @package PluginName\Admin
 */

namespace PluginName\Admin;

/**
 * This file adds custom fields to the post-type custom post type
 *
 * This class extends the custom_metadata_manager and adds custom fields
 *
 * @package PluginName\Admin
 */
class Fields_Config {
	/**
	 * Initializes the custom actions or filters
	 */
	public function init() {
		if ( is_admin() ) {
			add_action( 'custom_metadata_manager_init_metadata', array( $this, 'init_custom_fields' ) );
			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}

	/**
	 * Register our custom fields
	 */
	public function init_custom_fields() {
		// Ensure that the custom-metadata plugin is running
		if ( ! function_exists( 'x_add_metadata_group' ) || ! function_exists( 'x_add_metadata_field' ) ) {
			return;
		}

		x_add_metadata_group( 'plugin_fieldset', array( 'post-type' ), array(
			'label'    => 'Custom Fields',
			'priority' => 'high',
		) );

		/**
		 * Text
		 */
		x_add_metadata_field( 'plugin_custom_field_text', array( 'post-type' ), array(
			'group'       => 'plugin_fieldset',
			'label'       => 'Text',
			'description' => 'Text',
			'field_type'  => 'text',
		) );

		/**
		 * Textarea
		 */
		x_add_metadata_field( 'plugin_custom_field_textarea', array( 'post-type' ), array(
			'group'       => 'plugin_fieldset',
			'label'       => 'Text Area',
			'description' => 'Text Area',
			'field_type'  => 'textarea',
		) );

		/**
		 * Wysiwyg
		 */
		x_add_metadata_field( 'plugin_custom_field_wysiwyg', array( 'post-type' ), array(
			'group'       => 'plugin_fieldset',
			'label'       => 'TinyMCE / Wysiwyg field',
			'description' => 'TinyMCE / Wysiwyg',
			'field_type'  => 'wysiwyg',
		) );

		/**
		 * Datepicker
		 */
		x_add_metadata_field( 'plugin_custom_field_datepicker', array( 'post-type' ), array(
			'group'       => 'plugin_fieldset',
			'label'       => 'Datetimepicker field',
			'description' => 'Datetimepicker',
			'field_type'  => 'timepicker',
		) );

		/**
		 * Upload
		 */
		x_add_metadata_field( 'plugin_custom_field_upload', array( 'post-type' ), array(
			'group'       => 'plugin_fieldset',
			'label'       => 'Upload field',
			'description' => 'Upload',
			'field_type'  => 'upload',
		) );
	}

	/**
	 * Add the meta box for the video-suite taxonomy list
	 * Attach the taxonomy to the post on post save
	 * Remove the extra tag meta box for adding the taxonomies
	 */
	public function init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post', array( $this, 'save_metabox' ), 15, 3 );
		remove_meta_box( 'tagsdiv-post-type-taxonomy', 'post-type', 'core' );
	}

	/**
	 * Register the taxonomy meta box
	 */
	public function add_metabox() {
		add_meta_box(
			'taxonomies',
			__( 'Taxonomies', 'rare' ),
			array( $this, 'render_metabox' ),
			'post-type',
			'side',
			'core'
		);
	}

	/**
	 * Render a radio select list of the taxonomies in the meta box
	 * @param $post
	 * @return HTML
	 */
	public function render_metabox( $post ) {
		wp_nonce_field( 'taxonomies', 'taxonomies_nonce' );
		// Get all terms
		$terms = get_terms( 'post-type-taxonomy', 'hide_empty=0' );
		$type = get_the_terms( $post->ID, 'post-type-taxonomy' );
		echo '<ul>';
		$first_iter = true;
		foreach ( $terms as $term ) {
			echo '<li>';
			$checked = count( $type ) === 0 && $first_iter || count( $type ) > 0 && $type[0]->term_id === $term->term_id;
			echo '<label><input type="radio" ', ( $checked ? 'checked="checked" ' : '' ), 'name="post_post-type-taxonomy" value="', esc_attr( $term->term_id ), '" /> ', esc_attr( $term->name ), '</label>';
			$first_iter = false;
			echo '</li>';
		}
		echo '</ul>';
	}

	/**
	 * Save a taxonomy to the post
	 * @param $post_id
	 * @return string
	 */
	public function save_metabox($post_id) {
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'video_service_nonce', FILTER_SANITIZE_STRING ), 'video-services' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

        // Check permissions
		if ( ! current_user_can( 'edit_posts', $post_id ) ) {
			return $post_id;
		}

		// OK, we're authenticated: we need to find and save the data
		$post = get_post( $post_id );
		if ( ! empty( $post ) && 'post-type' === $post->post_type ) {
			$post_video_suite = $_POST['post_post-type-taxonomy'];
			if ( ! empty( $post_video_suite ) ) {
				$terms = (int) $post_video_suite;
			}
			$taxonomy_terms = wp_set_object_terms( $post_id, $terms, 'post-type-taxonomy' );
			if ( is_wp_error( $taxonomy_terms ) ) {
				return false;
			} else {
				return $taxonomy_terms;
			}
		}
	}
}