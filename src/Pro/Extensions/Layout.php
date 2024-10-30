<?php

namespace MEK\Pro\Extensions;

use  Elementor\Controls_Manager ;
use  MEK\Utils\Upsell ;
class Layout
{
    public function __construct()
    {
        add_action( 'elementor/element/section/section_layout/after_section_end', [ $this, 'register_section_controls' ], 0 );
        add_action( 'elementor/element/column/layout/after_section_end', [ $this, 'register_column_controls' ], 10 );
    }
    
    /**
     * Register controls for section layout extension
     *
     * @param \Elementor\Element_Section $manager
     */
    public function register_section_controls( $manager )
    {
        if ( 'section' !== $manager->get_name() ) {
            return;
        }
        $manager->start_controls_section( 'mek_section_layout_extension', [
            'tab'   => Controls_Manager::TAB_LAYOUT,
            'label' => esc_html__( 'MEK: Layout', 'moose-elementor-kit' ),
        ] );
        Upsell::add_pro_feature_notice( $manager, 'section_layout', 'We Provide Columns Wrap In %s' );
        $manager->end_controls_section();
    }
    
    /**
     * Register controls for column layout extension
     *
     * @param \Elementor\Element_Section $manager
     */
    public function register_column_controls( $manager )
    {
        if ( 'column' !== $manager->get_name() ) {
            return;
        }
        $manager->start_controls_section( 'mek_column_layout_extension', [
            'tab'   => Controls_Manager::TAB_LAYOUT,
            'label' => esc_html__( 'MEK: Layout', 'moose-elementor-kit' ),
        ] );
        Upsell::add_pro_feature_notice( $manager, 'column_layout', 'You can change column width (unlimited) and column order in %s' );
        $manager->end_controls_section();
    }

}