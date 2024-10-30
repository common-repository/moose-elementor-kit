<?php

if ( ! function_exists( 'mek_config' ) ) {
	/**
	 * Helper function for get config
	 *
	 * @param null|string $key
	 * @param null|mixed $default
	 *
	 * @return array|mixed|null
	 */
	function mek_config( $key = null, $default = null ) {
		return \MEK\Core\Config::get( $key, $default );
	}
}

if ( ! function_exists( 'mek_clsx' ) ) {
	/**
	 * A utility for constructing className strings conditionally.
	 *
	 * @return string
	 */
	function mek_clsx( ...$args ) {
		$classNames = [];

		foreach ( $args as $arg ) {
			if ( is_string( $arg ) ) {
				$classNames[] = $arg;
			} else if ( is_array( $arg ) ) {
				foreach ( $arg as $k => $v ) {
					if ( is_string( $v ) ) {
						$classNames[] = $v;
					} else if ( is_bool( $v ) && $v === true ) {
						$classNames[] = $k;
					}
				}
			}
		}

		return esc_attr( implode( ' ', $classNames ) );
	}
}

if ( ! function_exists( 'mek_clsx_echo' ) ) {
	/**
	 * Echo version for mek_clsx
	 *
	 * @param ...$args
	 */
	function mek_clsx_echo( ...$args ) {
		echo mek_clsx( ...$args );
	}
}

if ( ! function_exists( 'mek_coalescing' ) ) {
	/**
	 * Just like `??` operator after php7.0
	 *
	 * @param $arr
	 * @param $key
	 * @param $default
	 *
	 * @return mixed
	 */
	function mek_coalescing( $arr, $key, $default ) {
		if ( isset( $arr[ $key ] ) && $arr[ $key ] !== '' ) {
			return $arr[ $key ];
		}

		return $default;
	}
}

if ( ! function_exists( 'mek_array_path' ) ) {
	/**
	 * @param $arr
	 * @param $path
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	function mek_array_path( $arr, $path, $default = null ) {
		$keys   = explode( '.', $path );
		$source = $arr;

		while ( count( $keys ) > 0 ) {
			$key = array_shift( $keys );
			if ( is_array( $source ) && isset( $source[ $key ] ) ) {
				$source = $source[ $key ];
			} else {
				// current key doesn't exist, stop loop and return default value
				return $default;
			}
		}

		// we have reached the end of the path
		return $source;
	}
}

if ( ! function_exists( 'mek_get_template_part' ) ) {
	/**
	 * Include template
	 *
	 * @param $slug
	 */
	function mek_get_template_part( $slug ) {
		$path = MEK_PLUGIN_PATH . 'templates/' . $slug . '.php';
		if ( file_exists( $path ) ) {
			require $path;
		}
	}
}

if ( ! function_exists( 'mek_hex_to_rgb' ) ) {
	/**
	 * Convert hex color to rgb color
	 *
	 * @param $hex
	 *
	 * @return array|null
	 */
	function mek_hex_to_rgb( $hex ) {
		return sscanf( $hex, "#%02x%02x%02x" );
	}
}

if ( ! function_exists( 'mek_rgb_to_hex' ) ) {
	/**
	 * Convert rgb value to hex color
	 *
	 * @param $r
	 * @param $g
	 * @param $b
	 *
	 * @return string
	 */
	function mek_rgb_to_hex( $r, $g, $b ) {
		return sprintf( "#%02x%02x%02x", $r, $g, $b );
	}
}

if ( ! function_exists( 'mek_allowed_tags' ) ) {
	/**
	 * List of allowed html tag for wp_kses
	 *
	 * @return array
	 */
	function mek_allowed_tags() {
		return [
			'a'       => [
				'href'  => [],
				'title' => [],
				'class' => [],
				'rel'   => [],
				'id'    => [],
				'style' => []
			],
			'q'       => [
				'cite'  => [],
				'class' => [],
				'id'    => [],
			],
			'img'     => [
				'src'    => [],
				'alt'    => [],
				'height' => [],
				'width'  => [],
				'class'  => [],
				'id'     => [],
				'style'  => []
			],
			'span'    => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'dfn'     => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'time'    => [
				'datetime' => [],
				'class'    => [],
				'id'       => [],
				'style'    => [],
			],
			'cite'    => [
				'title' => [],
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'hr'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'b'       => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'p'       => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'i'       => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'u'       => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			's'       => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'br'      => [],
			'em'      => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'code'    => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'mark'    => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'small'   => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'abbr'    => [
				'title' => [],
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'strong'  => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'del'     => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'ins'     => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'sub'     => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'sup'     => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'div'     => [
				'class' => [],
				'id'    => [],
				'style' => []
			],
			'strike'  => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'acronym' => [],
			'h1'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'h2'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'h3'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'h4'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'h5'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'h6'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'button'  => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
		];
	}
}

if ( ! function_exists( 'mek_wp_kses' ) ) {
	/**
	 * Strip tag based on allowed html tag
	 *
	 * @param $text
	 *
	 * @return string
	 */
	function mek_wp_kses( $text ) {
		return wp_kses( $text, mek_allowed_tags() );
	}
}

if ( ! function_exists( 'mek_array_pluck' ) ) {
	/**
	 * Just like array_pluck function in laravel
	 *
	 * @param $key
	 * @param $arr
	 *
	 * @return array
	 */
	function mek_array_pluck( $key, $arr ) {
		return array_map( function ( $item ) use ( $key ) {
			return $item[ $key ];
		}, $arr );
	}
}

if ( ! function_exists( 'mek_array_group' ) ) {
	/**
	 * Group array by key
	 *
	 * @param $key
	 * @param $arr
	 *
	 * @return array
	 */
	function mek_array_group( $key, $arr ) {
		$keys = array_unique( array_column( $arr, $key ) );

		$target = [];
		foreach ( $keys as $k ) {
			$target[ $k ] = array_filter( $arr, function ( $value ) use ( $key, $k ) {
				return $value[ $key ] === $k;
			} );
		}

		return $target;
	}
}

if ( ! function_exists( 'mek_blend_options' ) ) {
	/**
	 * Mix blend options
	 *
	 * @return array
	 */
	function mek_blend_options() {
		return [
			'normal'      => esc_html__( 'Normal', 'moose-elementor-kit' ),
			'multiply'    => esc_html__( 'Multiply', 'moose-elementor-kit' ),
			'screen'      => esc_html__( 'Screen', 'moose-elementor-kit' ),
			'overlay'     => esc_html__( 'Overlay', 'moose-elementor-kit' ),
			'darken'      => esc_html__( 'Darken', 'moose-elementor-kit' ),
			'lighten'     => esc_html__( 'Lighten', 'moose-elementor-kit' ),
			'color-dodge' => esc_html__( 'Color-dodge', 'moose-elementor-kit' ),
			'color-burn'  => esc_html__( 'Color-burn', 'moose-elementor-kit' ),
			'hard-light'  => esc_html__( 'Hard-light', 'moose-elementor-kit' ),
			'soft-light'  => esc_html__( 'Soft-light', 'moose-elementor-kit' ),
			'difference'  => esc_html__( 'Difference', 'moose-elementor-kit' ),
			'exclusion'   => esc_html__( 'Exclusion', 'moose-elementor-kit' ),
			'hue'         => esc_html__( 'Hue', 'moose-elementor-kit' ),
			'saturation'  => esc_html__( 'Saturation', 'moose-elementor-kit' ),
			'color'       => esc_html__( 'Color', 'moose-elementor-kit' ),
			'luminosity'  => esc_html__( 'luminosity', 'moose-elementor-kit' ),
		];
	}
}

if ( ! function_exists( 'mek_get_theme' ) ) {
	/**
	 * Get installed theme data
	 *
	 * @param $theme
	 *
	 * @return \WP_Theme|null
	 */
	function mek_get_theme( $theme ) {
		$theme_data = wp_get_theme( $theme );
		if ( $theme_data->exists() ) {
			return $theme_data;
		}

		return null;
	}
}

