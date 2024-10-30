<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use MEK\Traits\Render;

class Badge extends Widget_Base {
	use \MEK\Traits\Components\Badge;
	use Render;

	public function get_name() {
		return 'mek_badge';
	}

	public function get_title() {
		return esc_html__( 'MEK: Badge', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-favorite';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'button', 'badge', 'mek', 'moose' ];
	}

	protected function register_controls() {
		/* Content Tab Start */
		$this->content_badge_controls();
		$this->content_animation_controls();

		/* Style Tab Start */
		$this->style_badge_controls();
	}

	protected function content_badge_controls() {
		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Badge', 'moose-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_badge_content_controls( $this, [
			'badge_content_type' => [ 'default' => 'icon' ],
		] );

		$this->add_badge_style_controls();

		$this->add_badge_size_controls( $this, [
			'default'         => 'lg',
			'desktop_default' => 'lg',
			'tablet_default'  => 'lg',
			'mobile_default'  => 'lg',
		] );

		$this->add_badge_state_controls( $this, [
			'badge_pill'   => [ 'default' => false ],
			'badge_circle' => [ 'default' => 'yes' ]
		] );

		$this->end_controls_section();
	}

	protected function content_animation_controls() {

		$this->start_controls_section( 'section_badge_animation', [
			'label' => esc_html__( 'Hover Animation', 'moose-elementor-kit' ),
		] );

		$this->add_control(
			'badge_hover_animation', [
			'label' => esc_html__( 'Animation', 'moose-elementor-kit' ),
			'type'  => Controls_Manager::HOVER_ANIMATION,
		] );

		$this->end_controls_section();
	}

	protected function style_badge_controls() {
		$this->start_controls_section( 'section_style_badge', [
			'label' => esc_html__( 'Badge', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_badge_controls();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$this->render_badge( $settings );
	}
}
