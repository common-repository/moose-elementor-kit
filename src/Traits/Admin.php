<?php

namespace MEK\Traits;

// If this file is called directly, abort.
use MEK\Core\ElementsManager;
use MEK\Utils\Sanitizes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Admin {

	/**
	 * Register settings
	 */
	public function register_settings() {
		// themes
		register_setting( 'mek-themes', 'mek-default-theme', 'absint' );
		register_setting( 'mek-themes', 'mek-themes', [
			'sanitize_callback' => array( Sanitizes::class, 'sanitize_theme_data' ),
		] );

		// elements
		foreach ( ElementsManager::all_elements() as $slug => $data ) {
			register_setting( 'mek-elements-settings', 'mek-element-' . $slug, [
				'default' => 'on',
			] );
		}
		register_setting( 'mek-elements-settings', 'mek-element-toggle-all', [
			'default' => 'on'
		] );

		// extensions
		foreach ( ElementsManager::all_extensions() as $slug => $data ) {
			register_setting( 'mek-extensions-settings', 'mek-extension-' . $slug, [
				'default' => 'on',
			] );
		}
	}

	/**
	 * Add admin menu
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_menu_page(
			esc_html__( 'Moose Kit', 'moose-elementor-kit' ),
			esc_html__( 'Moose Kit', 'moose-elementor-kit' ),
			'manage_options',
			'moose-elementor-kit',
			[ $this, 'show_admin_settings_page' ],
			MEK_ASSETS_URL . 'images/moose-icon.svg',
			'58.6'
		);
	}

	/**
	 * Show admin settings page
	 *
	 * @since 1.0.0
	 */
	public function show_admin_settings_page() {
		mek_get_template_part( 'admin/home' );
	}
}
