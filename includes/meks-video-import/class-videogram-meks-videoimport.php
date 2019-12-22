<?php
/**
 * Extend Meks Video Import to include embedded code into correct block fields.
 *
 * @package Videogram
 */

/**
 * Integrate Meks Video Import plugin into Videogram.
 */
class Videogram_Meks_VideoImport {

	/**
	 * Check if passed Id is YouTube video Id
	 *
	 * @param string $external_id Video Id.
	 * @return boolean true if it's valid YouTube Id, false if not.
	 */
	private function is_youtube_import( $external_id ) {

		if ( strlen( $external_id ) === 11 ) {
			return true;
		}

		return false;

	}

	/**
	 * Check if passed Id is Vimeo slug
	 *
	 * @param string $external_id Video Id.
	 * @return boolean true if it's valid Vimeo slug, false if not.
	 */
	private function is_vimeo_import( $external_id ) {

		if ( strpos( $external_id, '/videos/' ) === 0 ) {
			return true;
		}

		return false;

	}

	/**
	 * Generate YouTube embedded code based on video Id.
	 *
	 * @param string $youtube_id YouTube Id.
	 * @return string $embedded Embedded code.
	 */
	private function get_youtube_embedded( $youtube_id ) {

		$width  = 560;
		$height = 315;
		$allow  = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';

		$embedded = "<iframe width=\"$width\" height=\"$height\" src=\"https://www.youtube.com/embed/$youtube_id\" frameborder=\"0\" allow=\"$allow\" allowfullscreen></iframe>";

		return $embedded;

	}

	/**
	 * Generate Vimeo embedded code based on video Id.
	 *
	 * @param string $vimeo_import_id Vimeo import slug.
	 * @return string $embedded Embedded code.
	 */
	private function get_vimeo_embedded( $vimeo_import_id ) {

		$vimeo_id = str_replace( '/videos/', '', $vimeo_import_id );

		$width  = 640;
		$height = 360;
		$allow  = 'autoplay; fullscreen';

		$embedded = "<iframe width=\"$width\" height=\"$height\" src=\"https://player.vimeo.com/video/$vimeo_id\" frameborder=\"0\" allow=\"$allow\" allowfullscreen></iframe>";

		return $embedded;

	}

	/**
	 * Append video meta needed for videos.
	 *
	 * @param int $post_id Post Id.
	 * @return boolean true on success, false on failure.
	 */
	public function append_video_meta( $post_id ) {

		$external_id = get_post_meta( $post_id, 'external_id', true );

		if ( ! is_string( $external_id ) ) {
			return false;
		}

		if ( $this->is_youtube_import( $external_id ) ) {
			$embedded = $this->get_youtube_embedded( $external_id );
		} elseif ( $this->is_vimeo_import( $external_id ) ) {
			$embedded = $this->get_vimeo_embedded( $external_id );
		} else {
			return false;
		}

		/**
		 * Attach embedded code field.
		 */
		$insert_embedded_code = add_post_meta( $post_id, 'embedded_code', $embedded, true );

		if ( ! $insert_embedded_code ) {
			return false;
		}

		/**
		 * Overwrite post content with block editor template
		 */
		$post_content = '
		<!-- wp:videogram/excerpt /-->
		<!-- wp:videogram/video /-->
		';

		$args = [
			'ID'           => $post_id,
			'post_content' => $post_content,
		];

		$update_post = wp_update_post( $args );
		
		if ( $update_post !== $post_id ) {
			return false;
		}
		
		return true;

	}

}
