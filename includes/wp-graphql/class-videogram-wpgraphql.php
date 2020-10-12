<?php
/**
 * Extend WP Graphql to include necessary data for public access
 *
 * @package Videogram
 */

/**
 * Common class to attach new data to WP Graphql
 */
class Videogram_WPGraphQL {

	/**
	 * Post type to expose
	 *
	 * @var array
	 */
	public $types = [
		[
			'post_type'   => VIDEOGRAM_VIDEO_POST_TYPE,
			'single_name' => 'Video',
			'plural_name' => 'Videos',
		],
	];

	/**
	 * Taxonomies to expose
	 * 
	 * @var array
	 */
	public $taxonomies = [
		[
			'taxonomy'    => 'video-category',
			'single_name' => 'VideoCategory',
			'plural_name' => 'VideoCategories',
		],
	];

	/**
	 * Custom fields to expose
	 *
	 * @var array
	 */
	public $fields = [];

	/**
	 * Initial setup
	 */
	public function __construct() {

		$this->fields = get_video_fields_graphql();

	}

	/**
	 * Register post types
	 *
	 * @param array  $args Post type args.
	 * @param string $post_type Post type name.
	 *
	 * @return array $args Filtered post type args.
	 */
	public function expose_post_type( $args, $post_type ) {

		foreach ( $this->types as $type ) {
			if ( $type['post_type'] === $post_type ) {
				$args['show_in_graphql']     = true;
				$args['graphql_single_name'] = $type['single_name'];
				$args['graphql_plural_name'] = $type['plural_name'];
			}
		}

		return $args;
		
	}

	/**
	 * Register taxonomies
	 * 
	 * @param array  $args Taxonomy args.
	 * @param string $taxonomy Taxonomy name.
	 *
	 * @return array $args Filtered taxonomy args.
	 */
	public function expose_taxonomy( $args, $taxonomy ) {

		foreach ( $this->taxonomies as $tax ) {
			if ( $tax['taxonomy'] === $taxonomy ) {
				$args['show_in_graphql']     = true;
				$args['graphql_single_name'] = $tax['single_name'];
				$args['graphql_plural_name'] = $tax['plural_name'];
			}
		}

		return $args;

	}

	/**
	 * Register custom fields
	 */
	public function register_post_fields() {

		foreach ( $this->fields as $field ) {
			register_graphql_field(
				$field['post_type'],
				$field['name'],
				[
					'type'        => $field['type'],
					'description' => $field['description'],
					'resolve'     => function( $post ) use ( $field ) {
						$value = get_post_meta( $post->ID, $field['name'], true );
						return $value;
					},
				]
			);
		}
	}

}
