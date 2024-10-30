<?php

namespace MEK\Traits\Components;

use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Background ;
use  MEK\Utils\Upsell ;
trait Slider
{
    use  \MEK\Pro\Traits\Components\Slider ;
    /**
     * @param \Elementor\Widget_Base $manager
     * @param array $args
     */
    protected function add_slider_settings_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $manager->add_responsive_control( 'slider_height', [
            'type'       => Controls_Manager::SLIDER,
            'label'      => esc_html__( 'Height', 'moose-elementor-kit' ),
            'size_units' => [ 'px', 'vh' ],
            'range'      => [
            'px' => [
            'min' => 20,
            'max' => 1500,
        ],
            'vh' => [
            'min' => 20,
            'max' => 100,
        ],
        ],
            'default'    => [
            'unit' => 'px',
            'size' => 500,
        ],
            'selectors'  => [
            '{{WRAPPER}} .mek-advanced-slider' => 'height: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .mek-slider-item'     => 'height: {{SIZE}}{{UNIT}};',
        ],
            'separator'  => 'before',
        ] );
        $manager->add_responsive_control( 'slider_count', [
            'label'                => esc_html__( 'Count (Carousel)', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SELECT,
            'label_block'          => false,
            'default'              => 1,
            'widescreen_default'   => 1,
            'laptop_default'       => 1,
            'tablet_extra_default' => 1,
            'tablet_default'       => 1,
            'mobile_extra_default' => 1,
            'mobile_default'       => 1,
            'options'              => [
            1 => esc_html__( 'One', 'moose-elementor-kit' ),
            2 => esc_html__( 'Two', 'moose-elementor-kit' ),
            3 => esc_html__( 'Three', 'moose-elementor-kit' ),
            4 => esc_html__( 'Four', 'moose-elementor-kit' ),
            5 => esc_html__( 'Five', 'moose-elementor-kit' ),
            6 => esc_html__( 'Six', 'moose-elementor-kit' ),
        ],
            'separator'            => 'before',
            'render_type'          => 'template',
            'frontend_available'   => true,
            'prefix_class'         => 'mek-slider-columns-%s',
        ] );
        $manager->add_control( 'slides_to_scroll', [
            'label'              => esc_html__( 'Slides to Scroll', 'moose-elementor-kit' ),
            'type'               => Controls_Manager::NUMBER,
            'min'                => 1,
            'max'                => 6,
            'prefix_class'       => 'mek-slides-to-scroll-',
            'render_type'        => 'template',
            'frontend_available' => true,
            'default'            => 1,
        ] );
        $manager->add_responsive_control( 'slider_gutter', [
            'type'        => Controls_Manager::SLIDER,
            'label'       => esc_html__( 'Gutter', 'moose-elementor-kit' ),
            'size_units'  => [ 'px' ],
            'range'       => [
            'px' => [
            'min' => 0,
            'max' => 300,
        ],
        ],
            'default'     => [
            'unit' => 'px',
            'size' => 0,
        ],
            'selectors'   => [
            '{{WRAPPER}} .mek-slider .slick-slide' => 'margin-left: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .mek-slider .slick-list'  => 'margin-left: -{{SIZE}}{{UNIT}};',
        ],
            'render_type' => 'template',
            'condition'   => [
            'slider_count!' => 1,
        ],
        ] );
        $manager->add_responsive_control( 'slider_title', [
            'label'                => esc_html__( 'Title', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'default'              => 'yes',
            'widescreen_default'   => 'yes',
            'laptop_default'       => 'yes',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'none',
            'yes' => 'block',
        ],
            'selectors'            => [
            '{{WRAPPER}} .mek-slider-title' => 'display:{{VALUE}};',
        ],
            'separator'            => 'before',
        ] );
        $manager->add_responsive_control( 'slider_sub_title', [
            'label'                => esc_html__( 'Sub Title', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'default'              => 'yes',
            'widescreen_default'   => 'yes',
            'laptop_default'       => 'yes',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'none',
            'yes' => 'block',
        ],
            'selectors'            => [
            '{{WRAPPER}} .mek-slider-sub-title' => 'display:{{VALUE}};',
        ],
        ] );
        $manager->add_responsive_control( 'slider_description', [
            'label'                => esc_html__( 'Description', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'default'              => 'yes',
            'widescreen_default'   => 'yes',
            'laptop_default'       => 'yes',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'none',
            'yes' => 'block',
        ],
            'selectors'            => [
            '{{WRAPPER}} .mek-slider-description' => 'display:{{VALUE}};',
        ],
            'separator'            => 'after',
        ] );
        $manager->add_responsive_control( 'slider_nav', [
            'label'                => esc_html__( 'Navigation', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'default'              => 'yes',
            'widescreen_default'   => 'yes',
            'laptop_default'       => 'yes',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'none',
            'yes' => 'flex',
        ],
            'selectors'            => [
            '{{WRAPPER}} .mek-slider-arrow' => 'display:{{VALUE}} !important;',
        ],
        ] );
        $manager->add_control( 'slider_nav_prev_icon', [
            'label'       => esc_html__( 'Prev Nav Icon', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::ICONS,
            'skin'        => 'inline',
            'label_block' => false,
            'default'     => [
            'value'   => 'fas fa-chevron-left',
            'library' => 'fa-solid',
        ],
            'condition'   => [
            'slider_nav' => 'yes',
        ],
        ] );
        $manager->add_control( 'slider_nav_next_icon', [
            'label'       => esc_html__( 'Next Nav Icon', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::ICONS,
            'skin'        => 'inline',
            'label_block' => false,
            'default'     => [
            'value'   => 'fas fa-chevron-right',
            'library' => 'fa-solid',
        ],
            'condition'   => [
            'slider_nav' => 'yes',
        ],
        ] );
        $manager->add_responsive_control( 'slider_dots', [
            'label'                => esc_html__( 'Indicator (Dots)', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'default'              => 'yes',
            'widescreen_default'   => 'yes',
            'laptop_default'       => 'yes',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'none',
            'yes' => 'inline-table',
        ],
            'selectors'            => [
            '{{WRAPPER}} .mek-slider-dots' => 'display:{{VALUE}};',
        ],
            'render_type'          => 'template',
            'separator'            => 'before',
        ] );
        $manager->add_control( 'slider_dots_layout', [
            'label'        => esc_html__( 'Indicator Layout', 'moose-elementor' ),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'horizontal',
            'options'      => [
            'horizontal' => esc_html__( 'Horizontal', 'moose-elementor' ),
            'vertical'   => esc_html__( 'Vertical', 'moose-elementor' ),
        ],
            'prefix_class' => 'mek-slider-dots-',
            'render_type'  => 'template',
        ] );
        $manager->add_control( 'slider_autoplay', [
            'label'              => esc_html__( 'Autoplay', 'moose-elementor-kit' ),
            'type'               => Controls_Manager::SWITCHER,
            'default'            => '',
            'frontend_available' => true,
            'separator'          => 'before',
        ] );
        $manager->add_responsive_control( 'slider_autoplay_duration', [
            'label'      => esc_html__( 'Autoplay Duration (s)', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [],
            'range'      => [
            'px' => [
            'min' => 1,
            'max' => 60,
        ],
        ],
            'default'    => [
            'size' => 5,
        ],
            'condition'  => [
            'slider_autoplay' => 'yes',
        ],
        ] );
        $manager->add_control( 'slider_pause_on_hover', [
            'label'              => esc_html__( 'Pause On Hover', 'moose-elementor-kit' ),
            'type'               => Controls_Manager::SWITCHER,
            'default'            => 'yes',
            'frontend_available' => true,
            'condition'          => [
            'slider_autoplay' => 'yes',
        ],
        ] );
        $manager->add_control( 'slider_loop', [
            'label'              => esc_html__( 'Infinite Loop', 'moose-elementor-kit' ),
            'type'               => Controls_Manager::SWITCHER,
            'default'            => 'yes',
            'frontend_available' => true,
            'separator'          => 'before',
        ] );
        $manager->add_control( 'slider_effect', [
            'type'    => Controls_Manager::SELECT,
            'label'   => esc_html__( 'Effect', 'moose-elementor-kit' ),
            'default' => 'slide',
            'options' => [
            'slide' => esc_html__( 'Slide', 'moose-elementor-kit' ),
            'fade'  => esc_html__( 'Fade', 'moose-elementor-kit' ),
        ],
        ] );
        $manager->add_control( 'slider_effect_duration', [
            'label'   => esc_html__( 'Effect Duration', 'moose-elementor-kit' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 0.7,
            'min'     => 0,
            'max'     => 5,
            'step'    => 0.1,
        ] );
    }
    
    /**
     * @param \Elementor\Widget_Base $manager
     * @param array $args
     */
    protected function add_custom_slick_navigation_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $wrapper = mek_coalescing( $args, 'wrapper', '{{WRAPPER}}' );
        Upsell::add_pro_feature_notice(
            $manager,
            'slick_nav_customize_',
            'We provide the ability to fully customize the Slick Navigation style in %1$s',
            $args
        );
        $manager->start_controls_tabs( 'tabs_slider_nav_style' );
        /**
         * Normal & Hover Tabs
         */
        $manager->start_controls_tab( 'tab_slider_nav_normal', [
            'label' => esc_html__( 'Normal', 'moose-elementor-kit' ),
        ] );
        $manager->add_control( 'slider_nav_color', [
            'label'     => esc_html__( 'Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            $wrapper . ' .mek-slider-arrow'     => 'color: {{VALUE}};',
            $wrapper . ' .mek-slider-arrow svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $manager->end_controls_tab();
        $manager->start_controls_tab( 'tab_slider_nav_hover', [
            'label' => esc_html__( 'Hover', 'moose-elementor-kit' ),
        ] );
        $manager->add_control( 'slider_nav_hover_color', [
            'label'     => esc_html__( 'Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            $wrapper . ' .mek-slider-arrow:hover'     => 'color: {{VALUE}};',
            $wrapper . ' .mek-slider-arrow:hover svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $manager->end_controls_tab();
        $manager->end_controls_tabs();
    }
    
    /**
     * @param \Elementor\Widget_Base $manager
     * @param array $args
     */
    protected function add_custom_slick_indicator_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $wrapper = mek_coalescing( $args, 'wrapper', '{{WRAPPER}}' );
        Upsell::add_pro_feature_notice(
            $manager,
            'slick_indicator_customize_',
            'We provide the ability to fully customize the Slick Indicator style in %1$s',
            $args
        );
        $manager->add_responsive_control( 'slider_dots_width', [
            'label'       => esc_html__( 'Box Width', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::SLIDER,
            'size_units'  => [ 'px' ],
            'range'       => [
            'px' => [
            'min' => 1,
            'max' => 100,
        ],
        ],
            'default'     => [
            'unit' => 'px',
            'size' => 8,
        ],
            'selectors'   => [
            $wrapper . ' .mek-slider-dot' => 'width: {{SIZE}}{{UNIT}};',
        ],
            'separator'   => 'before',
            'render_type' => 'template',
        ] );
        $manager->add_responsive_control( 'slider_dots_height', [
            'label'       => esc_html__( 'Box Height', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::SLIDER,
            'size_units'  => [ 'px' ],
            'range'       => [
            'px' => [
            'min' => 1,
            'max' => 100,
        ],
        ],
            'default'     => [
            'unit' => 'px',
            'size' => 8,
        ],
            'selectors'   => [
            $wrapper . ' .mek-slider-dot' => 'height: {{SIZE}}{{UNIT}};',
        ],
            'render_type' => 'template',
        ] );
        $manager->add_responsive_control( 'slider_dots_vr', [
            'type'       => Controls_Manager::SLIDER,
            'label'      => esc_html__( 'Vertical Position', 'moose-elementor-kit' ),
            'size_units' => [ '%', 'px' ],
            'range'      => [
            '%'  => [
            'min' => -20,
            'max' => 120,
        ],
            'px' => [
            'min' => -200,
            'max' => 2000,
        ],
        ],
            'default'    => [
            'unit' => '%',
            'size' => 96,
        ],
            'selectors'  => [
            $wrapper . ' .mek-slider-dots' => 'top: {{SIZE}}{{UNIT}};',
        ],
        ] );
    }

}