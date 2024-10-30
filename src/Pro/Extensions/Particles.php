<?php

namespace MEK\Pro\Extensions;

use  Elementor\Controls_Manager ;
use  MEK\Utils\Upsell ;
class Particles
{
    /**
     * Preset particles
     *
     * @var array|string[]
     */
    protected  $presets = array() ;
    public function __construct()
    {
        add_action( 'elementor/element/section/section_background/after_section_end', [ $this, 'register_controls' ], 10 );
    }
    
    /**
     * Register controls for Particles extension
     *
     * @param \Elementor\Element_Section $manager
     */
    public function register_controls( $manager )
    {
        if ( 'section' !== $manager->get_name() ) {
            return;
        }
        $manager->start_controls_section( 'mek_particles_extension', [
            'tab'   => Controls_Manager::TAB_STYLE,
            'label' => esc_html__( 'MEK: Particles', 'moose-elementor-kit' ),
        ] );
        Upsell::add_pro_feature_notice( $manager, 'particles_', 'Do you want to enable amazing particle effects in the section background? Meet %1$s' );
        $manager->end_controls_section();
    }

}