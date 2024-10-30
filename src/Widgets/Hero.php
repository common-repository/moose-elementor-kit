<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Hero extends Widget_Base {

	use \MEK\Traits\Components\Hero;

	public function get_name() {
		return 'mek_hero';
	}

	public function get_title() {
		return esc_html__( 'MEK: Hero', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'hero', 'mek', 'moose' ];
	}

	protected function register_controls() {
		/* Content Tab */
		$this->content_hero_section();
		/* Style Tab */
		$this->style_content_section();
		$this->style_buttons_section();
	}

	protected function content_hero_section() {
		$this->start_controls_section( 'hero_section', [
			'label' => esc_html__( 'Hero', 'moose-elementor-kit' )
		] );

		$this->add_hero_content_controls();

		$this->end_controls_section();
	}

	protected function style_content_section() {
		$this->start_controls_section( 'section_content_style', [
			'label' => esc_html__( 'Content', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_hero_content_controls( $this );

		$this->end_controls_section();
	}

	protected function style_buttons_section() {
		$this->start_controls_section( 'section_primary_button_style', [
			'label'     => esc_html__( 'Primary Button', 'moose-elementor-kit' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'hero_primary_btn' => 'yes',
			]
		] );

		$this->add_custom_button_controls( $this, [
			'key'     => 'primary',
			'wrapper' => '{{WRAPPER}} .mek-hero .mek-hero-primary-btn'
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_secondary_button_style', [
			'label'     => esc_html__( 'Secondary Button', 'moose-elementor-kit' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'hero_secondary_btn' => 'yes',
			]
		] );

		$this->add_custom_button_controls( $this, [
			'key'     => 'secondary',
			'wrapper' => '{{WRAPPER}} .mek-hero .mek-hero-secondary-btn'
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_hero( $settings );
	}
}
