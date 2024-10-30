<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class Slider extends Widget_Base {

	use \MEK\Traits\Components\Slider;
	use \MEK\Traits\Components\Hero;

	public function get_name() {
		return 'mek_advanced_slider';
	}

	public function get_title() {
		return esc_html__( 'MEK: Advanced Slider/Carousel', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-media-carousel';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'carousel', 'slider', 'mek', 'moose' ];
	}

	public function get_script_depends() {
		return [ 'slick-js' ];
	}

	protected function register_controls() {
		/* Content Tab Start */
		$this->content_slide_controls();
		$this->content_settings_controls();

		/* Style Tab Start */
		$this->style_slick_item_controls();
		$this->style_slick_navigation_controls();
		$this->style_slick_indicator_controls();
	}

	protected function content_slide_controls() {
		$this->start_controls_section( 'section_slides', [
			'label' => esc_html__( 'Slides', 'moose-elementor-kit' ),
		] );

		$repeater = new Repeater();

		$this->add_hero_content_controls( $repeater, [
			'wrapper' => '{{WRAPPER}} {{CURRENT_ITEM}}',
		] );

		$this->add_control( 'slider_items', [
			'type'    => Controls_Manager::REPEATER,
			'fields'  => $repeater->get_controls(),
			'default' => [
				[ 'hero_title' => 'Awesome Slider Item ', 'hero_subtitle' => '#1' ],
				[ 'hero_title' => 'Awesome Slider Item ', 'hero_subtitle' => '#2' ],
				[ 'hero_title' => 'Awesome Slider Item ', 'hero_subtitle' => '#3' ],
				[ 'hero_title' => 'Awesome Slider Item ', 'hero_subtitle' => '#4' ],
			],
		] );

		$this->end_controls_section();
	}

	protected function content_settings_controls() {
		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'Settings', 'moose-elementor-kit' ),
		] );

		$this->add_slider_settings_controls();

		$this->end_controls_section();
	}

	protected function style_slick_item_controls() {
		$this->start_controls_section( 'style_section_slick_item', [
			'label' => esc_html__( 'Slick Content', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_hero_content_controls( $this, [
			'hero_height' => [ 'disabled' => true ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_section_slick_primary_button', [
			'label' => esc_html__( 'Primary Button', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_button_controls( $this, [
			'key'     => 'primary',
			'wrapper' => '{{WRAPPER}} .mek-hero .mek-hero-primary-btn'
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_section_slick_secondary_button', [
			'label' => esc_html__( 'Secondary Button', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_button_controls( $this, [
			'key'     => 'secondary',
			'wrapper' => '{{WRAPPER}} .mek-hero .mek-hero-secondary-btn'
		] );

		$this->end_controls_section();
	}

	protected function style_slick_navigation_controls() {
		$this->start_controls_section( 'style_section_slick_navigation', [
			'label' => esc_html__( 'Slick Navigation', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_slick_navigation_controls();

		$this->end_controls_section();
	}

	protected function style_slick_indicator_controls() {
		$this->start_controls_section( 'style_section_slick_indicator', [
			'label' => esc_html__( 'Slick Indicator', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_slick_indicator_controls();

		$this->end_controls_section();
	}

	protected function render() {
		$settings          = $this->get_settings_for_display();
		$slider_direction  = is_rtl() ? 'rtl' : 'ltr';
		$autoplay_duration = mek_coalescing( $settings, 'slider_autoplay_duration', [ 'size' => 1 ] );
		$slider_options    = [
			'rtl'           => is_rtl(),
			'infinite'      => ( $settings['slider_loop'] === 'yes' ),
			'speed'         => absint( $settings['slider_effect_duration'] * 1000 ),
			'arrows'        => true,
			'dots'          => true,
			'autoplay'      => ( $settings['slider_autoplay'] === 'yes' ),
			'autoplaySpeed' => absint( $autoplay_duration['size'] ) * 1000,
			'pauseOnHover'  => $settings['slider_pause_on_hover'] === 'yes',
			'prevArrow'     => '#mek-slider-prev-' . $this->get_id(),
			'nextArrow'     => '#mek-slider-next-' . $this->get_id(),
		];

		$this->add_render_attribute( 'slider-attribute', [
			'class'          => 'mek-slider',
			'dir'            => esc_attr( $slider_direction ),
			'data-mek-slick' => true,
			'data-slick'     => wp_json_encode( $slider_options ),
		] );

		?>
        <div class="mek-slider-wrap mek-relative">
            <div <?php $this->print_render_attribute_string( 'slider-attribute' ) ?>
                    data-slide-effect="<?php echo esc_attr( $settings['slider_effect'] ); ?>">
				<?php foreach ( $settings['slider_items'] as $item ): ?>
                    <div class="mek-slider-item <?php echo esc_attr( 'elementor-repeater-item-' . $item['_id'] ) ?>">
						<?php $this->render_hero( $item ); ?>
                    </div>
				<?php endforeach; ?>
            </div>
            <div class="mek-slider-controls">
                <div class="mek-slider-dots"></div>
            </div>

            <div class="mek-slider-arrow-container">
                <div class="mek-slider-prev-arrow mek-slider-arrow"
                     id="<?php echo 'mek-slider-prev-' . esc_attr( $this->get_id() ); ?>">
					<?php Icons_Manager::render_icon( $settings['slider_nav_prev_icon'] ) ?>
                </div>
                <div class="mek-slider-next-arrow mek-slider-arrow"
                     id="<?php echo 'mek-slider-next-' . esc_attr( $this->get_id() ); ?>">
					<?php Icons_Manager::render_icon( $settings['slider_nav_next_icon'] ) ?>
                </div>
            </div>
        </div>
		<?php
	}
}
