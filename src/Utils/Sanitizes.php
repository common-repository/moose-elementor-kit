<?php

namespace MEK\Utils;

use MEK\Core\Option;

class Sanitizes {

	/**
	 * Sanitize function for theme
	 *
	 * @param $themes
	 *
	 * @return array|array[]
	 */
	public static function sanitize_theme_data( $themes ) {
		if ( ! is_array( $themes ) ) {
			return Option::default_themes();
		}

		foreach ( $themes as $index => $theme ) {

			if ( isset( $theme['label'] ) && ! empty( $theme['label'] ) ) {
				$theme['label'] = sanitize_text_field( $theme['label'] );
			} else {
				$theme['label'] = esc_html__( 'Untitled', 'moose-elementor-kit' );
			}

			if ( isset( $theme['palette'] ) && is_array( $theme['palette'] ) ) {

				$available_colors = array_keys( Option::colors() );

				foreach ( $theme['palette'] as $id => $value ) {
					if ( ! in_array( $id, $available_colors ) ) {
						unset( $theme['palette'][ $id ] );
						continue;
					}

					$theme['palette'][ $id ] = sanitize_hex_color( $theme['palette'][ $id ] );
				}

			} else {
				$theme['palette'] = mek_array_pluck( 'default', Option::colors() );
			}

			$themes[ $index ] = $theme;
		}

		return $themes;
	}

}
