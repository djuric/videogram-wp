<?php
/**
 * User fields to expose for users
 * 
 * @package Videogram
 */

use WPGraphQL\Types;

/**
 * Default fields to register
 * 
 * @return array $fields Default fields.
 */
function get_user_fields_graphql() {

	$fields = [
		[
			'name'        => 'favorites',
			'type'        => [ 'list_of' => 'Int' ],
			'description' => __( 'Video IDs which user added to favorites', 'videogram' ),
		],
	];

	return $fields;
}
