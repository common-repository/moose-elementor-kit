<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;

class Navbar extends Widget_Base {

	use \MEK\Traits\Components\Navbar;
	use \MEK\Traits\Components\Menu;
	use \MEK\Traits\Components\Identity;

	public function get_name() {
		return 'mek_navbar';
	}

	public function get_title() {
		return esc_html__( 'MEK: Navbar', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-nav-menu';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'menu', 'navbar', 'nav', 'mek', 'moose' ];
	}

	protected function register_controls() {
		/* Content Tab Start */
		$this->content_menu_controls();
		$this->content_navbar_controls();
		$this->content_identity_controls();

		/* Style Tab Start */
		$this->style_navbar_controls();
		$this->style_identity_controls();
		$this->style_menu_controls();
		$this->style_menu_items_controls();
		$this->style_sub_menu_controls();
		$this->style_sub_menu_items_controls();
	}

	/**
	 * Controls of navbar under content tab
	 */
	protected function content_navbar_controls() {
		$this->start_controls_section( 'section_navbar', [
			'label' => esc_html__( 'Navbar', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_navbar_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Controls of site identity under content tab
	 */
	protected function content_identity_controls() {
		$this->start_controls_section( 'section_identity', [
			'label' => esc_html__( 'Identity', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_site_identity_controls( $this, [
			'site_title'   => [ 'separator' => 'before' ],
			'site_tagline' => [ 'separator' => 'before' ],
		] );

		$this->end_controls_section();
	}

	/**
	 * Controls of menu under content tab
	 */
	protected function content_menu_controls() {
		$this->start_controls_section( 'section_menu', [
			'label' => esc_html__( 'Menu', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_menu_content_controls( $this, [ 'menu_depth' => [ 'separator' => 'after' ] ] );
		$this->add_menu_style_controls( $this, [
			'menu_style'  => [ 'disabled' => true ],
			'menu_upsell' => [ 'disabled' => true ],
		] );

		$this->end_controls_section();
	}

	/**
	 * Controls for custom identity under style tab
	 */
	protected function style_identity_controls() {
		$this->start_controls_section( 'section_identity_navbar', [
			'label' => esc_html__( 'Identity', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_site_identity_controls();

		$this->end_controls_section();
	}

	/**
	 * Controls for custom navbar under style tab
	 */
	protected function style_navbar_controls() {

		$this->start_controls_section( 'section_style_navbar', [
			'label' => esc_html__( 'Navbar', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'navbar_text_color', [
			'label'     => esc_html__( 'Text Color', 'moose-elementor-kit' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .mek-navbar' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'navbar_background',
			'label'    => esc_html__( 'Background Color', 'moose-elementor-kit' ),
			'selector' => '{{WRAPPER}} .mek-navbar',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'navbar_box_shadow',
			'label'    => esc_html__( 'Shadow', 'moose-elementor-kit' ),
			'selector' => '{{WRAPPER}} .mek-navbar',
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'navbar_border',
			'label'    => esc_html__( 'Border', 'moose-elementor-kit' ),
			'selector' => '{{WRAPPER}} .mek-navbar',
		] );

		$this->add_responsive_control( 'navbar_padding', [
			'label'      => esc_html__( 'Navbar Padding', 'moose-elementor-kit' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .mek-navbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	/**
	 * Controls for custom menu under style tab
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
	 * Controls for custom top level menu items under style tab
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
	 * Controls for custom sub menu under style tab
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
		$settings                       = $this->get_settings();
		$settings['menu_style']         = $settings['navbar_style'];
		$settings['dropdown_direction'] = 'left';
		$css                            = $this->get_navbar_classes( $settings );
		$css[]                          = 'mek-navbar';

		$container_css        = [ 'mek-px-3' ];
		$mobile_container_css = [ 'mek-not-flex mek-px-3 mek-hidden' ];
		if ( $settings['navbar_content_width'] === 'container' ) {
			$container_css[]        = 'mek-container mek-mx-auto';
			$mobile_container_css[] = 'mek-container mek-mx-auto';
		}

		$toggle_id      = 'mek-mobile-menu-toggle-' . esc_attr( $this->get_id() );
		$mobile_menu_id = 'mek-mobile-menu-' . esc_attr( $this->get_id() );

		?>
        <nav class="<?php mek_clsx_echo( $css ); ?>">
            <div class="<?php mek_clsx_echo( $container_css ); ?>">
                <div class="mek-site-brand mek-flex mek-items-center mek-navbar-start">
					<?php $this->render_site_identity( $settings ); ?>
                </div>
                <div class="mek-flex-grow mek-flex mek-navbar-end">
					<?php
					$this->render_nav_menu( $settings, function ( $args ) {
						$args['menu_class'] = $args['menu_class'] . ' mek-hidden md:mek-flex';

						return $args;
					} );
					?>

                    <button id="<?php echo esc_attr( $toggle_id ); ?>"
                            class="mek-navbar-menu-toggle lg:hidden"
                            data-mek-toggle="collapse"
                            data-mek-toggle-target="#<?php echo esc_attr( $mobile_menu_id ) ?>"
                            aria-expanded="false">
                        <span class="mek-icon-bar"></span>
                        <span class="mek-icon-bar"></span>
                        <span class="mek-icon-bar"></span>
                        <span class="sr-only"><?php esc_html_e( 'Mobile Menu Toggle', 'moose-elementor-kit' ); ?></span>
                    </button>
                </div>
            </div>

            <nav id="<?php echo esc_attr( $mobile_menu_id ) ?>"
                 data-mek-redirect-focus="#<?php echo esc_attr( $toggle_id ); ?>"
                 class="<?php mek_clsx_echo( $mobile_container_css ); ?>"
                 aria-expanded="false">
				<?php
				$this->render_nav_menu( array_merge( $settings, [ 'menu_layout' => 'vertical' ] ), function ( $args ) {
					$args['menu_class'] = $args['menu_class'] . ' md:mek-hidden mek-pb-4';

					return $args;
				} );
				?>
            </nav>
        </nav>
		<?php
	}
}
