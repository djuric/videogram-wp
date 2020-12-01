<?php
/**
 * Extend WP Graphql to include necessary data for public access
 *
 * @package Videogram
 */

use GraphQL\Error\Error;

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

		$this->fields      = get_video_fields_graphql();

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
					'resolve'     => function ( $post ) use ( $field ) {
						$value = get_post_meta( $post->ID, $field['name'], true );
						return $value;
					},
				]
			);
		}
	}

    /**
     * Register favorites connection
     */
    public function register_favorites_user_field() {

        register_graphql_connection(
            [
                'fromType'      => 'User',
                'toType'        => 'Video',
                'fromFieldName' => 'favorites',
                'connectionArgs' => [
                    'in' => [
                        'type' => 'Int',
                        'description' => __( 'Video ID to check against', 'videogram' ),
                    ]
                ],
                'resolve'       => function( $event, $args, $context, $info ) {
                    $connection = new \WPGraphQL\Data\Connection\PostObjectConnectionResolver( $event, $args, $context, $info, 'vgvideo' );

                    $favorites = get_user_meta( $event->userId, 'favorites', true );
                    if ( ! is_array( $favorites ) || empty( $favorites ) ) {
                        return [];
                    }

                    if( isset( $args['where']['in'] ) ) {
                        if( in_array( $args['where']['in'], $favorites, true )) {
                            $connection->set_query_arg( 'post__in', [$args['where']['in']] );
                        } else {
                            return [];
                        }
                    } else {
                        $connection->set_query_arg( 'post__in', $favorites );
                    }

                    return $connection->get_connection();
                },
            ]
        );

    }

	/**
	 * Register mutations.
	 */
	public function register_mutation() {

		register_graphql_mutation(
			'setFavorites',
			[
				'inputFields'         => [
					'videoId' => [
						'type'        => 'Int',
						'description' => __( 'Video ID', 'videogram' ),
                    ],
					'insert'  => [
						'type'        => 'Boolean',
						'description' => __( 'Whether to add (true) or remove (false) video from favorites', 'videogram' ),
                    ],
                ],
				'outputFields'        => [
					'favorites' => [
						'type'        => [
							'list_of' => 'Int',
                        ],
						'description' => __( 'List of video IDs in favorites', 'videogram' ),
						'resolve'     => function ( $payload, $args, $context, $info ) {
							return isset( $payload['favorites'] ) ? $payload['favorites'] : [];
						},
                    ],
                ],
				'mutateAndGetPayload' => function ( $input, $context, $info ) {

					$current_user_id = get_current_user_id();

					if ( $current_user_id <= 0 ) {
						throw new Error( __( 'You must be logged in to complete this action.', 'videogram' ) );
					}

					if ( empty( $input['videoId'] ) ) {
						throw new Error( __( 'Video ID is required.', 'videogram' ) );
					}

					if ( ! is_bool( $input['insert'] ) ) {
						throw new Error( __( 'Insert flag is required.', 'videogram' ) );
					}

					$favorites = get_user_meta( $current_user_id, 'favorites', true );
					$favorites = empty( $favorites ) ? [] : $favorites;
					$favorites_video_key = array_search( $input['videoId'], $favorites, true );

					if ( $input['insert'] ) {
						if ( false === $favorites_video_key ) {
							$favorites[] = $input['videoId'];
						} else {
							throw new Error( __( 'Video is already added.', 'videogram' ) );
						}
					} else {
						if ( false !== $favorites_video_key ) {
							unset( $favorites[ $favorites_video_key ] );
						} else {
							throw new Error( __( 'Video is already deleted.', 'videogram' ) );
						}
					}

					update_user_meta( $current_user_id, 'favorites', $favorites );

					return [
						'favorites' => $favorites,
                    ];
				},
            ]
		);

	}


}
