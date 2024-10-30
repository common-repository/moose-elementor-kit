<?php

namespace MEK\Core;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Option {

	/**
	 * @return string
	 */
	public static function color_vars( $colors ) {
		$output = '';

		foreach ( $colors as $id => $hex ) {
			list( $r, $g, $b ) = mek_hex_to_rgb( $hex );
			$rgb = $r . ',' . $g . ',' . $b;

			$output .= '--' . $id . ':' . $rgb . ';';
		}

		return $output;
	}

	/**
	 * Output theme vars
	 *
	 * @return string
	 */
	public static function themes_vars() {
		$output              = '';
		$themes              = self::themes();
		$default_theme_index = get_option( 'mek-default-theme', 0 );
		$default_theme       = mek_coalescing( $themes, $default_theme_index, $themes[0] );

		$output .= ':root{' . Option::color_vars( $default_theme['palette'] ) . '}';
		foreach ( $themes as $index => $theme ) {
			$output .= '[data-mek-theme-' . $index . '], .mek-theme-' . $index . ' {' . Option::color_vars( $theme['palette'] ) . '}';
		}

		return $output;
	}

	/**
	 * Get default colors
	 *
	 * @return array[]
	 */
	public static function colors() {
		return [
			'mek-primary-color'     => array(
				'label'   => __( 'Primary Color', 'moose-elementor-kit' ),
				'default' => '#fcb92b',
			),
			'mek-primary-focus'     => array(
				'label'   => __( 'Primary Focus', 'moose-elementor-kit' ),
				'default' => '#ffc852',
			),
			'mek-primary-content'   => array(
				'label'   => __( 'Primary Content', 'moose-elementor-kit' ),
				'default' => '#181830',
			),
			'mek-secondary-color'   => array(
				'label'   => __( 'Secondary Color', 'moose-elementor-kit' ),
				'default' => '#fac311',
			),
			'mek-secondary-focus'   => array(
				'label'   => __( 'Secondary Focus', 'moose-elementor-kit' ),
				'default' => '#ffbc4f',
			),
			'mek-secondary-content' => array(
				'label'   => __( 'Secondary Content', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-accent-color'      => array(
				'label'   => __( 'Accent Color', 'moose-elementor-kit' ),
				'default' => '#181830',
			),
			'mek-accent-focus'      => array(
				'label'   => __( 'Accent Focus', 'moose-elementor-kit' ),
				'default' => '#1b2e58',
			),
			'mek-accent-content'    => array(
				'label'   => __( 'Accent Content', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-neutral-color'     => array(
				'label'   => __( 'Neutral Color', 'moose-elementor-kit' ),
				'default' => '#1d2733',
			),
			'mek-neutral-focus'     => array(
				'label'   => __( 'Neutral Focus', 'moose-elementor-kit' ),
				'default' => '#2B3848',
			),
			'mek-neutral-content'   => array(
				'label'   => __( 'Neutral Content', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-info-color'        => array(
				'label'   => __( 'Info Color', 'moose-elementor-kit' ),
				'default' => '#0da5e9',
			),
			'mek-info-focus'        => array(
				'label'   => __( 'Info Focus', 'moose-elementor-kit' ),
				'default' => '#38bdf8',
			),
			'mek-info-content'      => array(
				'label'   => __( 'Info Content', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-success-color'     => array(
				'label'   => __( 'Success Color', 'moose-elementor-kit' ),
				'default' => '#10b981',
			),
			'mek-success-focus'     => array(
				'label'   => __( 'Success Focus', 'moose-elementor-kit' ),
				'default' => '#34d399',
			),
			'mek-success-content'   => array(
				'label'   => __( 'Success Content', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-warning-color'     => array(
				'label'   => __( 'Warning Color', 'moose-elementor-kit' ),
				'default' => '#fb923c',
			),
			'mek-warning-focus'     => array(
				'label'   => __( 'Warning Focus', 'moose-elementor-kit' ),
				'default' => '#fdba74',
			),
			'mek-warning-content'   => array(
				'label'   => __( 'Warning Content', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-error-color'       => array(
				'label'   => __( 'Error Color', 'moose-elementor-kit' ),
				'default' => '#dc2626',
			),
			'mek-error-focus'       => array(
				'label'   => __( 'Error Focus', 'moose-elementor-kit' ),
				'default' => '#ef4444',
			),
			'mek-error-content'     => array(
				'label'   => __( 'Error Content', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-base-color'        => array(
				'label'   => __( 'Base Color', 'moose-elementor-kit' ),
				'default' => '#ffffff',
			),
			'mek-base-100'          => array(
				'label'   => __( 'Base Color 100', 'moose-elementor-kit' ),
				'default' => '#f1f5f9',
			),
			'mek-base-200'          => array(
				'label'   => __( 'Base Color 200', 'moose-elementor-kit' ),
				'default' => '#e2e8f0',
			),
			'mek-base-content'      => array(
				'label'   => __( 'Base Content', 'moose-elementor-kit' ),
				'default' => '#1e293b',
			),
		];
	}

	/**
	 * Get all themes
	 *
	 * @return false|mixed|void
	 */
	public static function themes() {
		return get_option( 'mek-themes', \MEK\Core\Option::default_themes() );
	}

	/**
	 * Get default themes
	 *
	 * @return array[]
	 */
	public static function default_themes() {
		return [
			[
				'label'   => __( 'Energetic', 'moose-elementor-kit' ),
				'palette' => mek_array_pluck( 'default', self::colors() ),
			],
			[
				'label'   => __( 'Sky', 'moose-elementor-kit' ),
				'palette' => array_merge( mek_array_pluck( 'default', self::colors() ), [
					'mek-primary-color'     => '#0ea5e9',
					'mek-primary-focus'     => '#38bdf8',
					'mek-primary-content'   => '#f0f9ff',
					'mek-secondary-color'   => '#06b6d4',
					'mek-secondary-focus'   => '#22d3ee',
					'mek-secondary-content' => '#ecfeff',
					'mek-accent-color'      => '#475569',
					'mek-accent-focus'      => '#64748b',
					'mek-accent-content'    => '#f8fafc',
					'mek-neutral-color'     => '#4b5563',
					'mek-neutral-focus'     => '#6b7280',
					'mek-neutral-content'   => '#f9fafb',
				] ),
			],
			[
				'label'   => __( 'Nature', 'moose-elementor-kit' ),
				'palette' => array_merge( mek_array_pluck( 'default', self::colors() ), [
					'mek-primary-color'     => '#6B705C',
					'mek-primary-focus'     => '#A5A58D',
					'mek-primary-content'   => '#fbfaf8',
					'mek-secondary-color'   => '#656D4A',
					'mek-secondary-focus'   => '#A4AC86',
					'mek-secondary-content' => '#fbfaf8',
					'mek-accent-color'      => '#686763',
					'mek-accent-focus'      => '#B8B5B0',
					'mek-accent-content'    => '#fbfaf8',
					'mek-neutral-color'     => '#796e65',
					'mek-neutral-focus'     => '#8c8279',
					'mek-neutral-content'   => '#fbfaf8',
					'mek-base-color'        => '#F5F4EF',
					'mek-base-content'      => '#333D29',
					'mek-base-100'          => '#E5E2D9',
					'mek-base-200'          => '#B8B5B0',
				] ),
			],
		];
	}
}
