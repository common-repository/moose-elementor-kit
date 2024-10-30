<?php

namespace MEK\Extensions;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use MEK\Core\Option;

class ThemeSwitcher {

	public function __construct() {
		add_action( 'elementor/element/section/section_layout/after_section_end', [
			$this,
			'register_section_controls'
		], 5 );

		add_action( 'elementor/documents/register_controls', [ $this, 'register_document_controls' ], 5 );

		add_filter( 'body_class', [ $this, 'body_class' ] );
	}

	public function body_class( $classes = [] ) {
		$id = get_the_ID();

		$document = Plugin::$instance->documents->get( $id );

		if ( is_singular() && $document && $document->is_built_with_elementor() ) {
			$classes[] = 'mek-theme-' . $document->get_settings( 'mek_document_theme' );
		}

		return $classes;
	}

	/**
	 * Register controls for document theme switcher extension
	 *
	 * @param \Elementor\Element_Section $element
	 */
	public function register_document_controls( $element ) {
		$element->start_controls_section( 'mek_document_theme_switcher_extension', [
			'tab'   => Controls_Manager::TAB_STYLE,
			'label' => esc_html__( 'MEK: Theme', 'moose-elementor-kit' ),
		] );

		$themes = mek_array_pluck( 'label', Option::themes() );

		$element->add_control( 'mek_document_theme', [
			'label'   => esc_html__( 'Theme', 'moose-elementor-kit' ),
			'desc'    => esc_html__( 'Refresh the page to take effect', 'moose-elementor-kit' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'default',
			'options' => array_merge( [
				'default' => esc_html__( 'Default', 'moose-elementor-kit' )
			], $themes ),
		] );

		$element->end_controls_section();
	}

	/**
	 * Register controls for section theme switcher extension
	 *
	 * @param \Elementor\Element_Section $element
	 */
	public function register_section_controls( $element ) {
		if ( 'section' !== $element->get_name() ) {
			return;
		}

		$element->start_controls_section( 'mek_section_theme_switcher_extension', [
			'tab'   => Controls_Manager::TAB_STYLE,
			'label' => esc_html__( 'MEK: Theme', 'moose-elementor-kit' ),
		] );

		$themes = mek_array_pluck( 'label', Option::themes() );

		$element->add_control( 'mek_section_theme', [
			'label'        => esc_html__( 'Theme', 'moose-elementor-kit' ),
			'type'         => Controls_Manager::SELECT,
			'default'      => 'default',
			'options'      => array_merge( [
				'default' => esc_html__( 'Default', 'moose-elementor-kit' )
			], $themes ),
			'prefix_class' => 'mek-theme-',
		] );

		$element->end_controls_section();
	}

}
