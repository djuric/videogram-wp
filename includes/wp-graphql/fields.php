<?php
/**
 * Custom fields to expose for video post type
 * 
 * @package Videogram
 */

/**
 * Default fields to register
 * 
 * @return array $fields Default fields.
 */
function get_video_fields_graphql() {

	$fields = [
		[
			'name'        => 'embedded_code',
			'type'        => 'String',
			'post_type'   => 'Video',
			'description' => __( 'Embedded code of the video', 'videogram' ),
		],
		[
			'name'        => 'length',
			'type'        => 'String',
			'post_type'   => 'Video',
			'description' => __( 'Length of the video', 'videogram' ),
		],
		[
			'name'        => 'featured',
			'type'        => 'Boolean',
			'post_type'   => 'Video',
			'description' => __( 'Whether this video is featured', 'videogram' ),
		],
	];

	return $fields;
}
