<?php
/**
 * Query posts and display the JSON data to a specified URL using the WordPress API.
 *
 * @package PluginName\Lib
 */

namespace PluginName\Lib;

/**
 * This file adds a custom API endpoint to the WordPress API
 *
 * Register a custom API endpoint
 *
 * @package PluginName\Lib
 */
class Endpoints {

	/**
	 * Register the custom routes
	 */
	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Add a custom API endpoint based on the {post-type} taxonomy term
	 */
	public function register_routes() {
		register_rest_route(
			'plugin-name/v2', '/post-type/post-type-taxonomy/(?P<term>\S+)', array(
				'methods'  => 'GET',
				'callback' => array( $this, 'post_array' ),
				'args'     => array(
					'term' => array(
						'validate_callback' => function ( $param, $request, $key ) {
							return ! empty( $param );
						},
					),
				),

			)
		);
	}

	/**
	 * Add a custom API endpoint based on the {post-type} taxonomy term
	 */
	public function post_array( $request ) {
		$output = array();
		$args = array(
			'post_type'      => 'post-type',
			'posts_per_page' => min( absint( 30 ), 100 ),
			'order'          => 'ASC',
			'tax_query'      => array(
				'relation'   => 'AND',
				array(
					'taxonomy' => 'post-type-taxonomy',
					'field'    => 'slug',
					'terms'    => $request->get_params( 'term' ),
				),
			),
		);

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_array = $this->post_type_array( get_the_ID() );
				if ( ! empty( $post_array ) ) {
					$output[] = $post_array;
				}
			}
			wp_reset_postdata();
		}
		return $output;
	}

	/**
	 * Return an array of post data for {post-type} posts
	 *
	 * @param  $post_id
	 * @return array
	 */
	public function post_type_array( $post_id ) {
		$terms = get_the_terms( get_the_ID(), 'post-type-taxonomy' );
		if ( ! empty( $terms[0] ) ) {
			$cat_id = $terms[0]->term_id;
			//VIP: check return value of a function before using it as string
			$cat_link = wpcom_vip_get_term_link( $cat_id );
			if ( ! is_wp_error( $cat_link ) ) {
				$cat_link = esc_url( $cat_link );
			} else {
				$cat_link = '';
			}
			$cat_name = $terms[0]->name;
		}

		return array(
			'id'                => $post_id,
			'title'             => get_the_title(),
			'permalink'         => get_permalink( get_the_ID() ),
			'category'          => $cat_name,
			'category_link'     => $cat_link,
			'custom_field'      => get_post_meta( $post_id, 'plugin_custom_field', true ),
		);

	}

}
