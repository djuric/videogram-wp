<?php
/**
 * Include meta query filter for "featured" custom field.
 * 
 * @todo Abstract away meta fields query so it can be used for other custom fields.
 * @package Videogram
 */

/**
 * Include featured in post type input fields
 */
add_filter(
	'graphql_input_fields',
	function( $fields, $type_name, $config ) {

		if ( isset( $config['queryClass'] ) && 'WP_Query' === $config['queryClass'] ) {

			$fields['featured'] = [
				'type'        => 'Boolean',
				'description' => __( 'Whether to include featured only', 'videogram' ),
			];

		}

		return $fields;

	},
	10,
	4
);

/**
 * Attach input field to WP_Query.
 */
add_filter(
	'graphql_map_input_fields_to_wp_query',
	function( $query_args, $input_args ) {

		if ( ! empty( $input_args['featured'] ) ) {
			$query_args['meta_key']   = 'featured';
			$query_args['meta_value'] = $input_args['featured'];
		}

		return $query_args;

	},
	10,
	2
);
