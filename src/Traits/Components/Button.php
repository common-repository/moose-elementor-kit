<?php

namespace MEK\Traits\Components;

use  Elementor\Controls_Manager ;
use  Elementor\Core\Schemes\Typography ;
use  Elementor\Group_Control_Background ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  MEK\Utils\Upsell ;
trait Button
{
    use  \MEK\Pro\Traits\Components\Button ;
    protected function get_button_classes( $settings, $key = '' )
    {
        $mobile_size = [
            'xl' => 'mek-btn-xl',
            'lg' => 'mek-btn-lg',
            'md' => 'mek-btn-md',
            'sm' => 'mek-btn-sm',
            'xs' => 'mek-btn-xs',
        ];
        $tablet_size = [
            'xl' => 'sm:mek-btn-xl',
            'lg' => 'sm:mek-btn-lg',
            'md' => 'sm:mek-btn-md',
            'sm' => 'sm:mek-btn-sm',
            'xs' => 'sm:mek-btn-xs',
        ];
        $desktop_size = [
            'xl' => 'md:mek-btn-xl',
            'lg' => 'md:mek-btn-lg',
            'md' => 'md:mek-btn-md',
            'sm' => 'md:mek-btn-sm',
            'xs' => 'md:mek-btn-xs',
        ];
        $classes = [
            'mek-btn',
            $mobile_size[mek_coalescing( $settings, $key . 'button_size_mobile', 'xs' )],
            $tablet_size[mek_coalescing( $settings, $key . 'button_size_tablet', 'sm' )],
            $desktop_size[mek_coalescing( $settings, $key . 'button_size', 'md' )],
            'mek-btn-outline' => mek_coalescing( $settings, $key . 'button_outline', '' ) === 'yes',
            'mek-btn-disabled' => mek_coalescing( $settings, $key . 'button_disabled', '' ) === 'yes',
            'mek-btn-block' => mek_coalescing( $settings, $key . 'button_block', '' ) === 'yes',
            'mek-btn-wide' => mek_coalescing( $settings, $key . 'button_wide', '' ) === 'yes'
        ];
        $classes[] = $this->get_button_style_css( $settings[$key . 'button_style'] );
        return $classes;
    }
    
    protected function get_button_style_css( $style )
    {
        $classes = [
            'primary' => 'mek-btn-primary',
        ];
        if ( isset( $classes[$style] ) ) {
            return $classes[$style];
        }
        return '';
    }
    
    protected function add_button_content_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        $manager->add_control( $key . 'button_label', array_merge( [
            'label'   => esc_html__( 'Label', 'moose-elementor-kit' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'Awesome Button', 'moose-elementor-kit' ),
        ], $args, mek_coalescing( $args, 'button_label', [] ) ) );
        $manager->add_control( $key . 'button_url', array_merge( [
            'label'       => esc_html__( 'Link', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'moose-elementor-kit' ),
            'dynamic'     => [
            'active' => true,
        ],
        ], $args, mek_coalescing( $args, 'button_url', [] ) ) );
    }
    
    protected function add_button_style_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        $manager->add_control( $key . 'button_style', array_merge( [
            'label'        => esc_html__( 'Style', 'moose-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'save_default' => true,
            'options'      => [
            'primary'   => esc_html__( 'Primary', 'moose-elementor-kit' ),
            'secondary' => esc_html__( 'Secondary (Pro)', 'moose-elementor-kit' ),
            'accent'    => esc_html__( 'Accent (Pro)', 'moose-elementor-kit' ),
            'neutral'   => esc_html__( 'Neutral (Pro)', 'moose-elementor-kit' ),
            'ghost'     => esc_html__( 'Ghost (Pro)', 'moose-elementor-kit' ),
            'link'      => esc_html__( 'Link (Pro)', 'moose-elementor-kit' ),
            'info'      => esc_html__( 'Info (Pro)', 'moose-elementor-kit' ),
            'success'   => esc_html__( 'Success (Pro)', 'moose-elementor-kit' ),
            'warning'   => esc_html__( 'Warning (Pro)', 'moose-elementor-kit' ),
            'error'     => esc_html__( 'Error (Pro)', 'moose-elementor-kit' ),
        ],
            'default'      => 'primary',
        ], $args ) );
        if ( !mek_array_path( $args, 'button_style_upsell.disabled', false ) ) {
            Upsell::add_pro_feature_notice(
                $manager,
                $key . 'button_style_',
                'Get 9 Button Styles On %1$s',
                $args
            );
        }
    }
    
    protected function add_button_size_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        $manager->add_responsive_control( $key . 'button_size', array_merge( [
            'label'           => esc_html__( 'Size', 'moose-elementor-kit' ),
            'type'            => Controls_Manager::SELECT,
            'save_default'    => true,
            'options'         => [
            'xl' => esc_html__( 'Extra Large', 'moose-elementor-kit' ),
            'lg' => esc_html__( 'Large', 'moose-elementor-kit' ),
            'md' => esc_html__( 'Middle', 'moose-elementor-kit' ),
            'sm' => esc_html__( 'Small', 'moose-elementor-kit' ),
            'xs' => esc_html__( 'Extra Small', 'moose-elementor-kit' ),
        ],
            'devices'         => [ 'desktop', 'tablet', 'mobile' ],
            'default'         => 'md',
            'desktop_default' => 'md',
            'tablet_default'  => 'sm',
            'mobile_default'  => 'xs',
        ], $args ) );
    }
    
    protected function add_button_state_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        if ( !mek_array_path( $args, 'button_outline.disabled', false ) ) {
            $manager->add_control( $key . 'button_outline', array_merge( [
                'label'   => esc_html__( 'Outline', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => false,
            ], $args, mek_coalescing( $args, 'button_outline', [] ) ) );
        }
        if ( !mek_array_path( $args, 'button_disabled.disabled', false ) ) {
            $manager->add_control( $key . 'button_disabled', array_merge( [
                'label'   => esc_html__( 'Disabled', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => false,
            ], $args, mek_coalescing( $args, 'button_disabled', [] ) ) );
        }
        if ( !mek_array_path( $args, 'button_wide.disabled', false ) ) {
            $manager->add_control( $key . 'button_wide', array_merge( [
                'label'   => esc_html__( 'Wide', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => false,
            ], $args, mek_coalescing( $args, 'button_wide', [] ) ) );
        }
        if ( !mek_array_path( $args, 'button_block.disabled', false ) ) {
            $manager->add_control( $key . 'button_block', array_merge( [
                'label'   => esc_html__( 'Block', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => false,
            ], $args, mek_coalescing( $args, 'button_block', [] ) ) );
        }
    }
    
    protected function add_custom_button_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        Upsell::add_pro_feature_notice(
            $manager,
            $key . 'button_customize_',
            'We provide the ability to fully customize the button style in %1$s',
            $args
        );
    }

}