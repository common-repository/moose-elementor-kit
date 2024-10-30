<?php

namespace MEK\Extensions;

use Elementor\Controls_Manager;

class Background {

	public function __construct() {
		add_action( 'elementor/element/section/section_layout/after_section_end', [
			$this,
			'register_section_controls'
		], 5 );
	}

	/**
	 * Register controls for section layout extension
	 *
	 * @param \Elementor\Element_Section $element
	 */
	public function register_section_controls( $element ) {
		if ( 'section' !== $element->get_name() ) {
			return;
		}

		$element->start_controls_section( 'mek_section_background_extension', [
			'tab'   => Controls_Manager::TAB_STYLE,
			'label' => esc_html__( 'MEK: Background', 'moose-elementor-kit' ),
		] );

		$element->add_control( 'mek_prose_section', [
			'label'        => esc_html__( 'Prose Section', 'moose-elementor-kit' ),
			'description'  => esc_html__( 'Enable beautiful typography for section content', 'moose-elementor-kit' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => false,
			'prefix_class' => 'mek-prose mek-prose-moose mek-font-sans mek-max-w-none mek-section-prose',
		] );

		$element->add_control( 'mek_section_background_type', [
				'label'        => esc_html__( 'Background Type', 'moose-elementor-kit' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'default',
				'options'      => [
					'default'  => esc_html__( 'Default', 'moose-elementor-kit' ),
					'base'     => esc_html__( 'Base', 'moose-elementor-kit' ),
					'bordered' => esc_html__( 'Bordered', 'moose-elementor-kit' ),
					'shadowed' => esc_html__( 'Shadowed', 'moose-elementor-kit' ),
				],
				'prefix_class' => 'mek-section-',
			]
		);

		$element->end_controls_section();
	}
}
