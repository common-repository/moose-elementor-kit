<?php

/**
 * Plugin Name:       Moose Elementor Kit
 * Description:       Moose UI Kit For Elementor Page Builder
 * Requires at least: 5.0
 * Requires PHP:      5.6
 * Version:           1.0.0
 * Author:            WP Moose
 * Author URI:        https://www.wpmoose.com
 * Plugin URI:        https://kit.wpmoose.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Elementor tested up to: 3.5
 * Text Domain:       moose-elementor-kit
 *
 */
// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Defining plugin constants.
 *
 * @since 1.0.0
 */
define( 'MEK_VERSION', '1.0.0' );
define( 'MEK_PLUGIN_FILE', __FILE__ );
define( 'MEK_PLUGIN_PATH', trailingslashit( plugin_dir_path( MEK_PLUGIN_FILE ) ) );
define( 'MEK_PLUGIN_URL', trailingslashit( plugins_url( '/', MEK_PLUGIN_FILE ) ) );
define( 'MEK_ASSETS_PATH', MEK_PLUGIN_PATH . 'assets/' );
define( 'MEK_ASSETS_URL', MEK_PLUGIN_URL . 'assets/' );

if ( function_exists( 'mek_fs' ) ) {
    mek_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'mek_fs' ) ) {
        // Create a helper function for easy SDK access.
        function mek_fs()
        {
            global  $mek_fs ;
            
            if ( !isset( $mek_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $mek_fs = fs_dynamic_init( array(
                    'id'             => '9846',
                    'slug'           => 'moose-elementor-kit',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_4304ebb0b7793e11bfa08c21721a2',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                    'slug' => 'moose-elementor-kit',
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $mek_fs;
        }
        
        // Init Freemius.
        mek_fs();
        // Signal that SDK was initiated.
        do_action( 'mek_fs_loaded' );
    }
    
    /**
     * Including composer autoloader globally.
     *
     * @since 1.0.0
     */
    require_once MEK_PLUGIN_PATH . 'autoload.php';
    /**
     * Including global helper functions.
     *
     * @since 1.0.0
     */
    require_once MEK_PLUGIN_PATH . 'src/helpers.php';
    /**
     * Run plugin after all others plugins
     *
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', function () {
        \MEK\Core\Bootstrap::instance();
    } );
}
