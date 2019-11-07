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
	 * Custom fields to expose
	 *
	 * @var array
	 */
	public $fields = [
		[
			'name'        => 'color',
			'type'        => 'String',
			'post_type'   => 'Video',
			'description' => 'Its a color of the post',
		],
		[
			'name'        => 'velicina',
			'post_type'   => 'Video',
			'type'        => 'String',
			'description' => 'Velicina posta!',
		],
	];

	/**
	 * Register post types
	 *
	 * @param array  $args Post type arg.
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
	 * Register custom fields
	 */
	public function register_fields() {

		foreach ( $this->fields as $field ) {
			register_graphql_field(
				$field['post_type'],
				$field['name'],
				[
					'type'        => $field['type'],
					'description' => $field['description'],
					'resolve'     => function( $post ) {
						$field = get_post_meta( $post->ID, $field['name'], true );
						return $field;
					},
				]
			);
		}
	}

}
