<?php
/**
 * User fields to expose for users
 * 
 * @package Videogram
 */

/**
 * Default fields to register
 * 
 * @return array $fields Default fields.
 */
function get_user_fields_graphql() {

	$fields = [
		[
			'name'        => 'vg_favorites',
			'type'        => 'String',
			'description' => __( 'Video IDs which user added to favorites', 'videogram' ),
		]
	];

	return $fields;
}
