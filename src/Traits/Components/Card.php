<?php

namespace MEK\Traits\Components;

use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Background ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Css_Filter ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Typography ;
use  MEK\Utils\Upsell ;
trait Card
{
    use  \MEK\Pro\Traits\Components\Card ;
    protected function get_card_classes( $settings )
    {
        $mobile_direction = [
            'vertical'           => 'mek-card-vertical',
            'vertical-reverse'   => 'mek-card-vertical-reverse',
            'horizontal'         => 'mek-card-horizontal',
            'horizontal-reverse' => 'mek-card-horizontal-reverse',
        ];
        $tablet_direction = [
            'vertical'           => 'sm:mek-card-vertical',
            'vertical-reverse'   => 'sm:mek-card-vertical-reverse',
            'horizontal'         => 'sm:mek-card-horizontal',
            'horizontal-reverse' => 'sm:mek-card-horizontal-reverse',
        ];
        $desktop_direction = [
            'vertical'           => 'md:mek-card-vertical',
            'vertical-reverse'   => 'md:mek-card-vertical-reverse',
            'horizontal'         => 'md:mek-card-horizontal',
            'horizontal-reverse' => 'md:mek-card-horizontal-reverse',
        ];
        $is_overlay = isset( $settings['card_overlay'] ) && $settings['card_overlay'] === 'yes';
        $classes = [
            'mek-card',
            'mek-rounded-md',
            'mek-shadow-md',
            'mek-bg-base',
            'mek-text-base-content',
            'mek-card-overlay' => $is_overlay,
            $mobile_direction[$settings['card_direction_mobile']] => !$is_overlay,
            $tablet_direction[$settings['card_direction_tablet']] => !$is_overlay,
            $desktop_direction[$settings['card_direction']] => !$is_overlay
        ];
        return $classes;
    }
    
    protected function add_card_content_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $manager->add_control( 'card_link', [
            'label'       => esc_html__( 'Link', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::URL,
            'dynamic'     => [
            'active' => true,
        ],
            'placeholder' => esc_html__( 'https://your-link.com', 'moose-elementor-kit' ),
        ] );
        $manager->add_control( 'card_title', [
            'label'       => esc_html__( 'Title & Description', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'default'     => esc_html__( 'This is the heading', 'moose-elementor-kit' ),
            'placeholder' => esc_html__( 'Enter your title', 'moose-elementor-kit' ),
            'label_block' => true,
        ] );
        $manager->add_control( 'card_description', [
            'label'       => '',
            'type'        => Controls_Manager::TEXTAREA,
            'dynamic'     => [
            'active' => true,
        ],
            'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'moose-elementor-kit' ),
            'placeholder' => esc_html__( 'Enter your description', 'moose-elementor-kit' ),
            'rows'        => 10,
            'show_label'  => false,
            'separator'   => 'after',
        ] );
    }
    
    protected function add_card_layout_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $manager->add_control( 'card_stretch', [
            'label'     => esc_html__( 'Stretch', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => false,
            'selectors' => [
            "{{WRAPPER}},\n\t\t\t\t{{WRAPPER}} .elementor-widget-container,\n\t\t\t\t{{WRAPPER}} .elementor-widget-container .mek-card" => 'height: 100%',
        ],
        ] );
        $manager->add_responsive_control( 'card_vertical_align', [
            'label'     => esc_html__( 'Vertical Align', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'start'         => [
            'title' => esc_html__( 'Start', 'moose-elementor-kit' ),
            'icon'  => 'eicon-justify-start-v',
        ],
            'center'        => [
            'title' => esc_html__( 'Center', 'moose-elementor-kit' ),
            'icon'  => 'eicon-justify-center-v',
        ],
            'right'         => [
            'title' => esc_html__( 'End', 'moose-elementor-kit' ),
            'icon'  => 'eicon-justify-end-v',
        ],
            'space-around'  => [
            'title' => esc_html__( 'Space Around', 'moose-elementor-kit' ),
            'icon'  => 'eicon-justify-space-around-v',
        ],
            'space-between' => [
            'title' => esc_html__( 'Space Between', 'moose-elementor-kit' ),
            'icon'  => 'eicon-justify-space-between-v',
        ],
        ],
            'condition' => [
            'card_stretch' => 'yes',
        ],
            'selectors' => [
            '{{WRAPPER}} .mek-card .mek-card-body' => 'justify-content: {{VALUE}};',
        ],
        ] );
        $manager->add_responsive_control( 'card_horizontal_align', [
            'label'     => esc_html__( 'Horizontal Alignment', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'left'    => [
            'title' => esc_html__( 'Left', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-left',
        ],
            'center'  => [
            'title' => esc_html__( 'Center', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-center',
        ],
            'right'   => [
            'title' => esc_html__( 'Right', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-right',
        ],
            'justify' => [
            'title' => esc_html__( 'Justified', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-justify',
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .mek-card' => 'text-align: {{VALUE}};',
        ],
        ] );
        $manager->add_responsive_control( 'card_direction', [
            'label'           => esc_html__( 'Direction', 'moose-elementor-kit' ),
            'type'            => Controls_Manager::SELECT,
            'save_default'    => true,
            'options'         => [
            'vertical'           => esc_html__( 'Vertical', 'moose-elementor-kit' ),
            'vertical-reverse'   => esc_html__( 'Vertical Reverse', 'moose-elementor-kit' ),
            'horizontal'         => esc_html__( 'Horizontal', 'moose-elementor-kit' ),
            'horizontal-reverse' => esc_html__( 'Horizontal Reverse', 'moose-elementor-kit' ),
        ],
            'devices'         => [ 'desktop', 'tablet', 'mobile' ],
            'default'         => 'vertical',
            'desktop_default' => 'vertical',
            'tablet_default'  => 'vertical',
            'mobile_default'  => 'vertical',
        ] );
        Upsell::add_pro_feature_notice( $manager, 'card_overlay_', 'Get Overlay Card Feature On %1$s' );
    }
    
    protected function add_card_icon_text_style_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $manager->add_responsive_control( 'media_icon_text_font_size', [
            'label'     => __( 'Size', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => 20,
            'max'  => 200,
            'step' => 1,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .mek-card .mek-card-media'     => 'font-size: {{SIZE}}px;',
            '{{WRAPPER}} .mek-card .mek-card-media svg' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
            '{{WRAPPER}} .mek-card .mek-card-media img' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
        ],
        ] );
        $manager->add_responsive_control( 'media_icon_text_padding', [
            'label'      => esc_html__( 'Padding', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .mek-card .mek-card-media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        /**
         * Normal & Hover Style
         */
        $manager->start_controls_tabs( 'tabs_media_icon_text_style' );
        $manager->start_controls_tab( 'tab_media_icon_text_normal', [
            'label' => esc_html__( 'Normal', 'moose-elementor-kit' ),
        ] );
        $manager->add_control( 'media_icon_primary_color', [
            'label'     => esc_html__( 'Primary Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.mek-card-icon-view-stacked .mek-card-media-icon-text'                                                                                           => 'background-color: {{VALUE}};',
            '{{WRAPPER}}.mek-card-icon-view-default .mek-card-media-icon-text,
				{{WRAPPER}}.mek-card-icon-view-framed .mek-card-media-icon-text' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
        ],
        ] );
        $manager->add_control( 'media_icon_secondary_color', [
            'label'     => esc_html__( 'Secondary Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.mek-card-icon-view-stacked .mek-card-media-icon-text' => 'fill: {{VALUE}}; color: {{VALUE}};',
            '{{WRAPPER}}.mek-card-icon-view-framed .mek-card-media-icon-text'  => 'background-color: {{VALUE}};',
        ],
        ] );
        $manager->end_controls_tab();
        $manager->start_controls_tab( 'tab_media_icon_text_hover', [
            'label' => esc_html__( 'Hover', 'moose-elementor-kit' ),
        ] );
        Upsell::add_pro_feature_notice(
            $manager,
            'card_media_icon_text_hover_customize_',
            'Customizing hover styles for icon and text media type is a feature of the %1$s',
            $args
        );
        $manager->end_controls_tab();
        $manager->end_controls_tabs();
    }
    
    protected function add_card_image_style_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        Upsell::add_pro_feature_notice(
            $manager,
            $key . 'card_image_customize_',
            'We provide the ability to fully customize the card image style in %1$s',
            $args
        );
    }
    
    protected function add_card_content_style_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        Upsell::add_pro_feature_notice(
            $manager,
            'card_content_customize_',
            'We provide the ability to fully customize the card content style in %1$s',
            $args
        );
    }
    
    protected function add_card_body_style_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        $wrapper = mek_coalescing( $args, 'wrapper', '{{WRAPPER}}' );
        Upsell::add_pro_feature_notice(
            $manager,
            $key . 'card_body_customize_',
            'We provide the ability to fully customize the card body style in %1$s',
            $args
        );
        $manager->add_responsive_control( 'card_body_padding', [
            'label'      => esc_html__( 'Body Padding', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            $wrapper . ' .mek-card .mek-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $manager->add_group_control( Group_Control_Border::get_type(), [
            'name'      => 'card_body_border',
            'label'     => esc_html__( 'Border', 'moose-elementor-kit' ),
            'separator' => 'before',
            'selector'  => $wrapper . ' .mek-card',
        ] );
        $manager->add_control( 'card_body_border_radius', [
            'label'     => esc_html__( 'Border Radius', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [
            $wrapper . ' .mek-card' => 'border-radius: {{SIZE}}px;',
        ],
        ] );
    }

}