<?php

namespace MEK\Traits;

// If this file is called directly, abort.
use  MEK\Core\Option ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
trait Assets
{
    /**
     * Enqueue frontend styles
     */
    public function enqueue_styles()
    {
        if ( !apply_filters( 'mek/is_plugin_active', 'elementor/elementor.php' ) ) {
            return;
        }
        $this->enqueue_ui();
        $this->dynamic_css();
        $this->enqueue_font_awesome();
    }
    
    /**
     * Register dependencies scripts & styles
     */
    public function register_dependencies()
    {
        wp_register_script(
            'infinite-scroll',
            MEK_ASSETS_URL . 'vendor/infinite-scroll/infinite-scroll.min.js',
            [ 'jquery' ],
            MEK_VERSION
        );
        wp_register_script(
            'slick-js',
            MEK_ASSETS_URL . 'vendor/slick/slick.min.js',
            [ 'jquery' ],
            MEK_VERSION
        );
    }
    
    public function enqueue_font_awesome()
    {
        // Load FontAwesome
        wp_enqueue_style(
            'font-awesome-5-all',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
            false,
            MEK_VERSION
        );
    }
    
    /**
     * Core ui style
     */
    public function enqueue_ui()
    {
        wp_enqueue_style(
            'mek-ui-style',
            // Handle
            MEK_ASSETS_URL . 'css/style' . $this->get_stylesheet_suffix() . '.css',
            [],
            MEK_VERSION
        );
        wp_enqueue_script(
            'mek-ui-script',
            MEK_ASSETS_URL . 'js/mek' . $this->get_script_suffix() . '.js',
            [ 'jquery' ],
            MEK_VERSION
        );
    }
    
    /**
     * Get assets suffix
     *
     * @return string
     */
    public function get_stylesheet_suffix()
    {
        $is_debug = defined( 'MEK_DEBUG' ) && MEK_DEBUG;
        if ( $is_debug ) {
            return '';
        }
        $suffix = '.min';
        return $suffix;
    }
    
    /**
     * Output dynamic css.
     */
    public function dynamic_css()
    {
        $css = Option::themes_vars();
        wp_register_style( 'mek-dynamic-css', false );
        wp_enqueue_style( 'mek-dynamic-css' );
        wp_add_inline_style( 'mek-dynamic-css', $css );
    }
    
    /**
     * Enqueue admin styles
     */
    public function enqueue_admin_styles()
    {
        $this->enqueue_ui();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style(
            'jquery-toast',
            MEK_ASSETS_URL . 'vendor/jquery-toast/jquery.toast.min.css',
            [],
            MEK_VERSION
        );
        wp_enqueue_style(
            'mek-admin-style',
            // Handle
            MEK_ASSETS_URL . 'css/admin' . $this->get_stylesheet_suffix() . '.css',
            [],
            MEK_VERSION
        );
    }
    
    public function enqueue_admin_scripts()
    {
        wp_enqueue_script(
            'jquery-toast',
            MEK_ASSETS_URL . 'vendor/jquery-toast/jquery.toast.min.js',
            [ 'jquery' ],
            MEK_VERSION
        );
        wp_enqueue_script(
            'mek-admin-script',
            MEK_ASSETS_URL . 'js/admin' . $this->get_script_suffix() . '.js',
            [
            'jquery',
            'jquery-form',
            'wp-util',
            'wp-color-picker'
        ],
            MEK_VERSION
        );
    }
    
    /**
     * Get script file suffix
     *
     * @return string
     */
    public function get_script_suffix()
    {
        return ( defined( 'MEK_DEBUG' ) && MEK_DEBUG ? '' : '.min' );
    }
    
    /**
     * Enqueue editor styles
     */
    public function enqueue_editor_styles()
    {
        if ( !apply_filters( 'mek/is_plugin_active', 'elementor/elementor.php' ) ) {
            return;
        }
        $this->enqueue_font_awesome();
        wp_enqueue_style(
            'mek-editor-style',
            // Handle
            MEK_ASSETS_URL . 'css/editor' . $this->get_stylesheet_suffix() . '.css',
            [],
            MEK_VERSION
        );
    }

}