<?php

namespace MEK\Core;

/**
 * Config object
 */
class Config {

	/**
	 * Global instance
	 *
	 * @var Config
	 */
	private static $_instance = null;

	/**
	 * Global config file
	 *
	 * @var array
	 */
	private static $config = [];

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
		$config = require_once MEK_PLUGIN_PATH . 'src/config.php';

		self::$config = apply_filters( 'mek/load_config', $config );
	}

	/**
	 * Get config value
	 *
	 * @param null|string $key
	 * @param null|mixed $default
	 *
	 * @return array|mixed|null
	 */
	public static function get( $key = null, $default = null ) {
		if ( $key !== null ) {
			return mek_array_path( self::$config, $key, $default );
		}

		return self::$config;
	}
}
