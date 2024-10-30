<?php

namespace MEK\Core;

class ElementsManager {
	/**
	 * Global instance
	 *
	 * @var Config
	 */
	private static $_instance = null;

	/**
	 * Singleton instance
	 *
	 * @return Config|null
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
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		$this->register_extensions();
	}

	/**
	 * Register widgets
	 *
	 * @param  $widgets_manager
	 */
	public function register_widgets( $widgets_manager ) {
		$elements = self::all_active_elements();
		foreach ( $elements as $data ) {
			$classname = $data['class'];
			// Compatible with elementor <= 3.5.0
			$widgets_manager->register_widget_type( new $classname() );
		}
	}

	/**
	 * Register Extensions
	 */
	protected function register_extensions() {
		$extensions = self::all_active_extensions();
		foreach ( $extensions as $data ) {
			$classname = $data['class'];
			new $classname();
		}
	}

	/**
	 * Get all extensions
	 *
	 * @return array|mixed|null
	 */
	public static function all_extensions() {
		return mek_config( 'extensions' );
	}

	/**
	 * Get all active extension
	 *
	 * @return array|mixed|null
	 */
	public static function all_active_extensions() {
		$extensions = mek_config( 'extensions' );
		foreach ( $extensions as $slug => $data ) {
			if ( 'on' !== get_option( 'mek-extension-' . $slug, 'on' ) ) {
				unset( $extensions[ $slug ] );
			}
		}

		return $extensions;
	}

	/**
	 * Get all elements
	 *
	 * @return array|mixed|null
	 */
	public static function all_elements() {
		return mek_config( 'elements' );
	}

	/**
	 * Get all active elements
	 */
	public static function all_active_elements() {
		$elements = mek_config( 'elements' );
		foreach ( $elements as $slug => $data ) {
			if ( 'on' !== get_option( 'mek-element-' . $slug, 'on' ) ) {
				unset( $elements[ $slug ] );
			}
		}

		return $elements;
	}
}
