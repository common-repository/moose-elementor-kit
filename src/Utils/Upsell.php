<?php

namespace MEK\Utils;

use Elementor\Controls_Manager;

class Upsell {

	public static function url( $ref = 'admin' ) {
		// return network_admin_url( 'admin.php?page=moose-elementor-kit-pricing&ref=' . $ref );
		return 'https://kit.wpmoose.com/?ref=' . $ref . '#upgrade-section';
	}

	public static function add_pro_feature_notice( $module, $key, $notice, $args = [] ) {
		if ( mek_fs()->can_use_premium_code() ) {
			return;
		}

		$raw = sprintf( $notice, '<a href="' . self::url( $key ) . '" target="_blank">Pro version</a>' );

		$module->add_control( $key . '_mek-pro-notice-control', array_merge( [
			'raw'             => $raw,
			'type'            => Controls_Manager::RAW_HTML,
			'content_classes' => 'mek-pro-notice'
		], $args ) );
	}

	/**
	 * Go Premium Widget Section
	 */
	public static function add_go_premium_section( $module, $features = [] ) {
		if ( mek_fs()->can_use_premium_code() ) {
			return;
		}

		$module->start_controls_section( 'mek_section_pro', [
			'label' => esc_html__( 'Go Premium for More Features', 'moose-elementor-kit' ),
		] );

		$raw = '';
		if ( ! empty( $features ) ) {
			$raw .= '<ul>';
			foreach ( $features as $feature ) {
				$raw .= '<li>' . esc_html( $feature ) . '</li>';
			}
			$raw .= '</ul>';
		}

		$raw .= '<a href="' . self::url( 'upsell-section' ) . '" target="_blank">Get Pro version</a>';

		$module->add_control( 'mek_control_get_pro', [
			'type'            => Controls_Manager::RAW_HTML,
			'default'         => '1',
			'raw'             => $raw,
			'content_classes' => 'mek-pro-features',
		] );

		$module->end_controls_section();
	}
}