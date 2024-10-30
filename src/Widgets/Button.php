<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

class Button extends Widget_Base {

	use \MEK\Traits\Components\Button;

	public function get_name() {
		return 'mek_button';
	}

	public function get_title() {
		return esc_html__( 'MEK: Button', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-button';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'button', 'mek', 'moose' ];
	}

	protected function register_controls() {
		/* Content Tab Start */
		$this->content_button_controls();
		$this->content_icon_controls();
		$this->content_animation_controls();

		/* Style Tab Start */
		$this->style_button_controls();
	}

	/**
	 * Controls of button section under content tab
	 */
	protected function content_button_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'moose-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_button_content_controls( $this, [ 'button_url' => [ 'separator' => 'after' ] ] );
		$this->add_button_style_controls();
		$this->add_button_size_controls();

		$this->add_responsive_control( 'button_alignment', [
			'label'     => esc_html__( 'Alignment', 'moose-elementor-kit' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [
					'title' => esc_html__( 'Left', 'moose-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'moose-elementor-kit' ),
					'icon'  => 'eicon-h-align-center',
				],
				'right'  => [
					'title' => esc_html__( 'Right', 'moose-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				],
			],
			'default'   => 'left',
			'selectors' => [
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			],
			'separator' => 'after',
		] );

		$this->add_button_state_controls();

		$this->add_control( 'button_id', [
			'label'       => esc_html__( 'Button ID', 'moose-elementor-kit' ),
			'type'        => Controls_Manager::TEXT,
			'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'moose-elementor-kit' ),
			'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows A-z 0-9 & underscore chars without spaces.', 'moose-elementor-kit' ),
			'label_block' => false,
			'default'     => '',
			'separator'   => 'before',
		] );

		$this->end_controls_section();
	}

	/**
	 * Controls of icon section under content tab
	 */
	protected function content_icon_controls() {

		$this->start_controls_section( 'section_icon', [
			'label' => esc_html__( 'Icon', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'button_icon', [
			'label'       => esc_html__( 'Icon', 'moose-elementor-kit' ),
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'separator'   => 'before',
		] );

		$this->add_control( 'icon_position', [
			'label'       => esc_html__( 'Position', 'moose-elementor-kit' ),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'default'     => 'right',
			'options'     => [
				'left'  => [
					'title' => esc_html__( 'Left', 'moose-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'moose-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				],
			],
		] );

		$this->add_control( 'icon_size', [
			'label'      => esc_html__( 'Size', 'moose-elementor-kit' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default'    => [
				'unit' => 'px',
				'size' => 18,
			],
			'selectors'  => [
				'{{WRAPPER}} .mek-btn-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .mek-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
			],
			'separator'  => 'before',
		] );

		$this->add_control( 'icon_spacing', [
			'label'      => esc_html__( 'Spacing', 'moose-elementor-kit' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 50,
				],
			],
			'default'    => [
				'unit' => 'px',
				'size' => 12,
			],
			'selectors'  => [
				'{{WRAPPER}} .mek-btn-icon-left .mek-btn-icon'  => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .mek-btn-icon-right .mek-btn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	/**
	 * Controls of hover animation section under content tab
	 */
	protected function content_animation_controls() {

		$this->start_controls_section( 'section_button_animation', [
			'label' => esc_html__( 'Hover Animation', 'moose-elementor-kit' ),
		] );

		$this->add_control(
			'button_hover_animation', [
			'label' => esc_html__( 'Animation', 'moose-elementor-kit' ),
			'type'  => Controls_Manager::HOVER_ANIMATION,
		] );

		$this->end_controls_section();
	}

	/**
	 * Controls of button section under style tab
	 */
	protected function style_button_controls() {

		$this->start_controls_section( 'section_style_button', [
			'label' => esc_html__( 'Button', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_button_controls();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$btn_url  = $settings['button_url']['url'];

		if ( $btn_url !== '' ) {
			$this->add_render_attribute( 'button_attribute', 'href', $btn_url );

			if ( $settings['button_url']['is_external'] ) {
				$this->add_render_attribute( 'button_attribute', 'target', '_blank' );
			}

			if ( $settings['button_url']['nofollow'] ) {
				$this->add_render_attribute( 'button_attribute', 'nofollow', '' );
			}
		}

		if ( '' !== $settings['button_id'] ) {
			$this->add_render_attribute( 'button_attribute', 'id', $settings['button_id'] );
		}

		$content_classes = [ 'mek-flex mek-items-center' ];
		if ( $settings['icon_position'] === 'left' ) {
			$content_classes[] = 'mek-flex-row-reverse mek-btn-icon-left';
		} else {
			$content_classes[] = 'mek-btn-icon-right';
		}

		$button_classes = $this->get_button_classes( $settings );
		if ( $settings['button_hover_animation'] ) {
			$button_classes[] = 'elementor-animation-' . $settings['button_hover_animation'];
		}
		?>

        <a class="<?php mek_clsx_echo( $button_classes ); ?>" <?php $this->print_render_attribute_string( 'button_attribute' ); ?>>
				<span class="mek-inline-block">
                    <span class="<?php mek_clsx_echo( $content_classes ); ?>">
                        <?php if ( '' !== $settings['button_label'] ) : ?>
                            <span class="mek-btn-text"><?php echo esc_html( $settings['button_label'] ); ?></span>
                        <?php endif; ?>

	                    <?php if ( '' !== $settings['button_icon']['value'] ): ?>
                            <span class="mek-btn-icon"><?php Icons_Manager::render_icon( $settings['button_icon'] ); ?></span>
	                    <?php endif; ?>
                    </span>
                </span>
        </a>
		<?php
	}
}
