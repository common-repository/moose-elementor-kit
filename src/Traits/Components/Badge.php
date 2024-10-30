<?php

namespace MEK\Traits\Components;

use  Elementor\Controls_Manager ;
use  Elementor\Core\Schemes\Typography ;
use  Elementor\Group_Control_Background ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  MEK\Utils\Upsell ;
trait Badge
{
    use  \MEK\Pro\Traits\Components\Badge ;
    protected function get_badge_classes( $settings )
    {
        $mobile_size = [
            'xl' => 'mek-badge-xl',
            'lg' => 'mek-badge-lg',
            'md' => 'mek-badge-md',
            'sm' => 'mek-badge-sm',
            'xs' => 'mek-badge-xs',
        ];
        $tablet_size = [
            'xl' => 'sm:mek-badge-xl',
            'lg' => 'sm:mek-badge-lg',
            'md' => 'sm:mek-badge-md',
            'sm' => 'sm:mek-badge-sm',
            'xs' => 'sm:mek-badge-xs',
        ];
        $desktop_size = [
            'xl' => 'md:mek-badge-xl',
            'lg' => 'md:mek-badge-lg',
            'md' => 'md:mek-badge-md',
            'sm' => 'md:mek-badge-sm',
            'xs' => 'md:mek-badge-xs',
        ];
        $classes = [
            'mek-badge',
            $mobile_size[mek_coalescing( $settings, 'badge_size_mobile', 'xs' )],
            $tablet_size[mek_coalescing( $settings, 'badge_size_tablet', 'sm' )],
            $desktop_size[mek_coalescing( $settings, 'badge_size', 'sm' )],
            'mek-badge-outline' => $settings['badge_outline'] === 'yes',
            'mek-badge-pill' => $settings['badge_pill'] === 'yes',
            'mek-badge-circle' => $settings['badge_circle'] === 'yes'
        ];
        $classes[] = $this->get_badge_style_css( $settings['badge_style'] );
        return $classes;
    }
    
    protected function get_badge_style_css( $style )
    {
        $classes = [
            'primary' => 'mek-badge-primary',
            'ghost'   => 'mek-badge-ghost',
        ];
        if ( isset( $classes[$style] ) ) {
            return $classes[$style];
        }
        return '';
    }
    
    protected function add_badge_content_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $wrapper = mek_coalescing( $args, 'wrapper', '{{WRAPPER}}' );
        $manager->add_control( 'badge_content_type', array_merge( [
            'label'   => esc_html__( 'Content Type', 'moose-elementor-kit' ),
            'type'    => Controls_Manager::CHOOSE,
            'default' => 'text',
            'options' => [
            'text' => [
            'title' => esc_html__( 'Text', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-font',
        ],
            'icon' => [
            'title' => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-info-circle',
        ],
        ],
        ], $args, ( isset( $args['badge_content_type'] ) ? $args['badge_content_type'] : [] ) ) );
        /**
         * Condition: 'badge_content_type' => 'text'
         */
        $manager->add_control( 'badge_text', array_merge( [
            'label'     => esc_html__( 'Badge Text', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__( 'Awesome Badge', 'moose-elementor-kit' ),
            'condition' => [
            'badge_content_type' => 'text',
        ],
        ], $args, ( isset( $args['badge_text'] ) ? $args['badge_text'] : [] ) ) );
        /**
         * Condition: 'badge_content_type' => 'icon'
         */
        $manager->add_control( 'badge_icon', array_merge( [
            'label'     => esc_html__( 'Badge Icon', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
            'value'   => 'fas fa-info',
            'library' => 'fa-solid',
        ],
            'condition' => [
            'badge_content_type' => 'icon',
        ],
        ], $args, ( isset( $args['badge_icon'] ) ? $args['badge_icon'] : [] ) ) );
        $manager->add_control( 'badge_link', array_merge( [
            'label'       => esc_html__( 'Link', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'moose-elementor-kit' ),
            'dynamic'     => [
            'active' => true,
        ],
        ], $args, ( isset( $args['badge_link'] ) ? $args['badge_link'] : [] ) ) );
        $manager->add_responsive_control( 'badge_alignment', array_merge( [
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
            $wrapper => 'text-align: {{VALUE}};',
        ],
            'separator' => 'after',
        ], $args, mek_coalescing( $args, 'badge_alignment', [] ) ) );
    }
    
    protected function add_badge_style_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $manager->add_control( 'badge_style', array_merge( [
            'label'        => esc_html__( 'Style', 'moose-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'save_default' => true,
            'options'      => [
            'primary'   => esc_html__( 'Primary', 'moose-elementor-kit' ),
            'ghost'     => esc_html__( 'Ghost', 'moose-elementor-kit' ),
            'secondary' => esc_html__( 'Secondary (Pro)', 'moose-elementor-kit' ),
            'accent'    => esc_html__( 'Accent (Pro)', 'moose-elementor-kit' ),
            'neutral'   => esc_html__( 'Neutral (Pro)', 'moose-elementor-kit' ),
            'info'      => esc_html__( 'Info (Pro)', 'moose-elementor-kit' ),
            'success'   => esc_html__( 'Success (Pro)', 'moose-elementor-kit' ),
            'warning'   => esc_html__( 'Warning (Pro)', 'moose-elementor-kit' ),
            'error'     => esc_html__( 'Error (Pro)', 'moose-elementor-kit' ),
        ],
            'default'      => 'primary',
        ], $args ) );
        Upsell::add_pro_feature_notice(
            $manager,
            'badge_style_',
            'Get 7 Badge Styles On %1$s',
            $args
        );
    }
    
    protected function add_badge_size_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $manager->add_responsive_control( 'badge_size', array_merge( [
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
            'default'         => 'xs',
            'desktop_default' => 'xs',
            'tablet_default'  => 'xs',
            'mobile_default'  => 'xs',
        ], $args ) );
    }
    
    protected function add_badge_state_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $manager->add_control( 'badge_outline', array_merge( [
            'label'   => esc_html__( 'Outline', 'moose-elementor-kit' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => false,
        ], $args, ( isset( $args['badge_outline'] ) ? $args['badge_outline'] : [] ) ) );
        $manager->add_control( 'badge_pill', array_merge( [
            'label'     => esc_html__( 'Pill', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => [
            'badge_circle!' => 'yes',
        ],
        ], $args, ( isset( $args['badge_pill'] ) ? $args['badge_pill'] : [] ) ) );
        $manager->add_control( 'badge_circle', array_merge( [
            'label'     => esc_html__( 'Circle', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => false,
            'condition' => [
            'badge_pill!' => 'yes',
        ],
        ], $args, ( isset( $args['badge_circle'] ) ? $args['badge_circle'] : [] ) ) );
    }
    
    protected function add_custom_badge_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        Upsell::add_pro_feature_notice(
            $manager,
            $key . 'badge_customize_',
            'We provide the ability to fully customize the badge style in %1$s',
            $args
        );
    }
    
    protected function render_badge( $settings, $key = '' )
    {
        $classes = $this->get_badge_classes( $settings );
        if ( isset( $settings['badge_hover_animation'] ) && $settings['badge_hover_animation'] ) {
            $classes[] = 'elementor-animation-' . $settings['badge_hover_animation'];
        }
        if ( isset( $settings['additional_classes'] ) ) {
            
            if ( is_array( $settings['additional_classes'] ) ) {
                $classes = array_merge( $classes, $settings['additional_classes'] );
            } else {
                if ( is_string( $settings['additional_classes'] ) ) {
                    $classes[] = $settings['additional_classes'];
                }
            }
        
        }
        $args = [
            'key'             => 'badge_link_' . $key,
            'link'            => $settings['badge_link'],
            'default_classes' => $classes,
        ];
        
        if ( $settings['badge_content_type'] === 'icon' ) {
            $args['icon'] = $settings['badge_icon'];
        } else {
            $args['text'] = $settings['badge_text'];
        }
        
        $this->render_link_item( $args );
    }

}