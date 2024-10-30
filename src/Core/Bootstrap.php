<?php

namespace MEK\Core;

use MEK\Traits\Admin;
use MEK\Traits\Assets;

class Bootstrap {

	use Assets;
	use Admin;

	/**
	 * Global instance
	 *
	 * @var Bootstrap
	 */
	private static $_instance = null;

	/**
	 * Singleton instance
	 *
	 * @since 0.0.1
	 */
	public static function instance() {
		if ( self::$_instance === null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Private constructor
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		// Create global config instance
		Config::instance();

		if ( did_action( 'elementor/loaded' ) ) {
			// Create global manager instance
			ElementsManager::instance();
		}

		$this->add_filters();
		$this->add_actions();
	}

	/**
	 * Add filters
	 */
	protected function add_filters() {
		add_filter( 'mek/is_plugin_active', [ $this, 'is_plugin_active' ], 10, 1 );
	}

	/**
	 * Add action hooks
	 */
	protected function add_actions() {
		add_action( 'init', [ $this, 'i18n' ] );

		/**
		 * Register widget categories
		 */
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_categories' ] );

		/**
		 * Enqueue scripts and styles
		 */
		add_action( 'wp_enqueue_scripts', [ $this, 'register_dependencies' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ], 99 );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

		/**
		 * Admin
		 */
		if ( is_admin() ) {
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'elementor_not_loaded' ] );
			}

			add_action( 'admin_init', [ $this, 'register_settings' ] );
			add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		}
	}

	/**
	 * Add Moose Elementor Kit widget category
	 *
	 * @param $elements_manager
	 */
	public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category( 'moose-elementor-kit', [
			'title' => esc_html__( 'Moose Elementor Kit', 'moose-elementor-kit' ),
			'icon'  => 'font',
		], 1 );
	}

	/**
	 * Show error when elementor not loaded
	 */
	public function elementor_not_loaded() {

		$plugin = 'elementor/elementor.php';

		if ( $this->is_plugin_installed( $plugin ) ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$message        = '<p><strong>Moose Elementor Kit</strong> ' . esc_html__( 'requires Elementor plugin to be active.', 'moose-elementor-kit' ) . '</p>';
			$message        .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor', 'moose-elementor-kit' ) ) . '</p>';
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}

			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$message     = '<p>' . esc_html__( 'Moose Elementor Kit requires Elementor plugin to be installed.', 'moose-elementor-kit' ) . '</p>';
			$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor', 'moose-elementor-kit' ) ) . '</p>';
		}

		echo wp_kses_post( '<div class="error"><p>' . $message . '</p></div>' );
	}

	/**
	 * Loads a plugin’s translated strings.
	 */
	public function i18n() {
		load_plugin_textdomain( 'moose-elementor-kit' );
	}

	/**
	 * Check if a plugin is installed
	 *
	 * @since 1.0.0
	 */
	public function is_plugin_installed( $basename ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			include_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $basename ] );
	}

	/**
	 * Check if a plugin is active
	 *
	 * @since 1.0.0
	 */
	public function is_plugin_active( $plugin ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		return is_plugin_active( $plugin );
	}
}
