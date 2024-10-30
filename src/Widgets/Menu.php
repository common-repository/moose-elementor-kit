<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Menu extends Widget_Base {

	use \MEK\Traits\Components\Menu;

	public function get_name() {
		return 'mek_menu';
	}

	public function get_title() {
		return esc_html__( 'MEK: Menu', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-menu-bar';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'menu', 'mek', 'moose' ];
	}

	protected function register_controls() {
		/* Content Tab Start */
		$this->content_menu_controls();
		$this->content_sub_menu_controls();

		/* Style Tab */
		$this->style_menu_controls();
		$this->style_menu_items_controls();
		$this->style_sub_menu_controls();
		$this->style_sub_menu_items_controls();
	}

	/**
	 * Controls of menu section under content tab
	 */
	protected function content_menu_controls() {

		$this->start_controls_section( 'section_menu', [
			'label' => esc_html__( 'Menu', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_menu_content_controls( $this, [ 'menu_depth' => [ 'separator' => 'after' ] ] );
		$this->add_menu_layout_controls( $this, [ 'menu_align' => [ 'separator' => 'after' ] ] );
		$this->add_menu_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Controls of sub menu section under content tab
	 */
	protected function content_sub_menu_controls() {
		$this->start_controls_section( 'section_sub_menu', [
			'label' => esc_html__( 'Sub Menu', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_sub_menu_controls();

		$this->end_controls_section();
	}

	/**
	 * Controls of menu section under style tab
	 */
	protected function style_menu_controls() {

		$this->start_controls_section( 'section_style_menu', [
			'label' => esc_html__( 'Menu', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_menu_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Controls of menu item section under style tab
	 */
	protected function style_menu_items_controls() {
		$this->start_controls_section( 'section_style_menu_items', [
			'label' => esc_html__( 'Top Level Menu Items', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_menu_items_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Controls of sub menu section under style tab
	 */
	protected function style_sub_menu_controls() {

		$this->start_controls_section( 'section_style_sub_menu', [
			'label' => esc_html__( 'Sub Menu', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_sub_menu_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Controls of sub menu items section under style tab
	 */
	protected function style_sub_menu_items_controls() {

		$this->start_controls_section( 'section_style_sub_menu_items', [
			'label' => esc_html__( 'Sub Menu Items', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_sub_menu_items_style_controls();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$this->render_nav_menu( $settings );
	}
}