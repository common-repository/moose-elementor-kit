<?php

namespace MEK\Traits\Components;

use  Elementor\Controls_Manager ;
use  MEK\Utils\Upsell ;
trait Navbar
{
    use  \MEK\Pro\Traits\Components\Navbar ;
    /**
     * Get navbar css classes by settings
     *
     * @param $settings
     *
     * @return array
     */
    protected function get_navbar_classes( $settings )
    {
        return [ 'mek-navbar-primary' ];
    }
    
    protected function add_navbar_style_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        if ( !mek_array_path( $args, 'navbar_style.disabled', false ) ) {
            $manager->add_control( 'navbar_style', array_merge( [
                'label'   => esc_html__( 'Style', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'primary',
                'options' => [
                'primary'   => esc_html__( 'Primary', 'moose-elementor-kit' ),
                'secondary' => esc_html__( 'Secondary (Pro)', 'moose-elementor-kit' ),
                'accent'    => esc_html__( 'Accent (Pro)', 'moose-elementor-kit' ),
                'neutral'   => esc_html__( 'Neutral (Pro)', 'moose-elementor-kit' ),
                'ghost'     => esc_html__( 'Ghost (Pro)', 'moose-elementor-kit' ),
            ],
            ], $args, mek_coalescing( $args, 'navbar_style', [] ) ) );
        }
        if ( !mek_array_path( $args, 'navbar_upsell.disabled', false ) ) {
            Upsell::add_pro_feature_notice( $manager, 'navbar_style_', 'Get More Navbar Styles On %1$s' );
        }
        if ( !mek_array_path( $args, 'navbar_content_width.disabled', false ) ) {
            $manager->add_control( 'navbar_content_width', array_merge( [
                'label'   => esc_html__( 'Content Width', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => [
                'full'      => esc_html__( 'Full', 'moose-elementor-kit' ),
                'container' => esc_html__( 'Container', 'moose-elementor-kit' ),
            ],
            ], $args, mek_coalescing( $args, 'navbar_content_width', [] ) ) );
        }
    }

}