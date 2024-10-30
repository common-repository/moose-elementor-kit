<?php

namespace MEK\Traits\Components;

use  Elementor\Controls_Manager ;
use  Elementor\Core\Schemes\Typography ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  MEK\Utils\Upsell ;
trait Menu
{
    use  \MEK\Pro\Traits\Components\Menu ;
    /**
     * Custom menu item css class
     *
     * @param $classes
     * @param $item
     * @param $args
     * @param $depth
     *
     * @return mixed
     */
    public function custom_menu_item_css_class(
        $classes,
        $item,
        $args,
        $depth
    )
    {
        $classes[] = 'mek-menu-item';
        if ( in_array( 'current-menu-item', $classes ) ) {
            $classes[] = 'mek-current-menu-item';
        }
        if ( in_array( 'menu-item-has-children', $classes ) && ($args->depth === 0 || $args->depth > $depth + 1) ) {
            $classes[] = 'mek-menu-item-has-children';
        }
        return $classes;
    }
    
    /**
     * Custom sub menu css class
     *
     * @param $classes
     *
     * @return mixed
     */
    public function custom_sub_menu_css_class( $classes )
    {
        $classes[] = 'mek-sub-menu';
        return $classes;
    }
    
    /**
     * Output menu html structure
     *
     * @param $settings
     * @param null $modifier
     *
     * @return false|string|void
     */
    protected function render_nav_menu( $settings, $modifier = null )
    {
        if ( !$settings['active_menu'] ) {
            return '';
        }
        $args = [
            'menu'        => $settings['active_menu'],
            'menu_class'  => mek_clsx( $this->get_menu_classes( $settings ) ),
            'fallback_cb' => '__return_empty_string',
            'depth'       => mek_coalescing( $settings, 'menu_depth', 0 ),
            'container'   => false,
            'echo'        => true,
        ];
        add_filter(
            'nav_menu_css_class',
            [ $this, 'custom_menu_item_css_class' ],
            10,
            4
        );
        add_filter( 'nav_menu_submenu_css_class', [ $this, 'custom_sub_menu_css_class' ] );
        return wp_nav_menu( ( $modifier ? $modifier( $args ) : $args ) );
    }
    
    /**
     * Get menu classes by settings
     *
     * @param $settings
     *
     * @return array
     */
    protected function get_menu_classes( $settings )
    {
        $menu_layouts = [
            'vertical'   => 'mek-menu-vertical',
            'horizontal' => 'mek-menu-horizontal',
        ];
        $menu_sizes = [
            'xl' => 'mek-menu-xl',
            'lg' => 'mek-menu-lg',
            'md' => 'mek-menu-md',
            'sm' => 'mek-menu-sm',
            'xs' => 'mek-menu-xs',
        ];
        $menu_align = [
            'left'   => [
            'default' => 'mek-menu-left',
            'sm'      => 'sm:mek-menu-left',
            'md'      => 'md:mek-menu-left',
        ],
            'center' => [
            'default' => 'mek-menu-center',
            'sm'      => 'sm:mek-menu-center',
            'md'      => 'md:mek-menu-center',
        ],
            'right'  => [
            'default' => 'mek-menu-right',
            'sm'      => 'sm:mek-menu-right',
            'md'      => 'md:mek-menu-right',
        ],
        ];
        $dropdown_direction = [
            'left'  => '',
            'right' => 'mek-menu-dropdown-right',
        ];
        $output = [
            'mek-menu',
            'mek-menu-segment' => mek_coalescing( $settings, 'menu_segment', 'no' ) === 'yes',
            $menu_layouts[mek_coalescing( $settings, 'menu_layout', 'horizontal' )],
            $menu_sizes[mek_coalescing( $settings, 'menu_size', 'md' )],
            $dropdown_direction[mek_coalescing( $settings, 'dropdown_direction', 'right' )]
        ];
        
        if ( isset( $settings['menu_align'] ) ) {
            $output[] = $menu_align[$settings['menu_align_mobile']]['default'];
            $output[] = $menu_align[$settings['menu_align_tablet']]['sm'];
            $output[] = $menu_align[$settings['menu_align']]['md'];
        }
        
        $output[] = 'mek-menu-links';
        $output[] = 'mek-menu-primary';
        return $output;
    }
    
    /**
     * Get all registered menus.
     */
    protected function get_registered_menus()
    {
        $menus = wp_get_nav_menus();
        $options = [];
        foreach ( $menus as $menu ) {
            $options[$menu->term_id] = $menu->name;
        }
        return $options;
    }
    
    protected function add_menu_content_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        $menus = $this->get_registered_menus();
        
        if ( empty($menus) ) {
            // no menus
            $manager->add_control( 'active_menu', array_merge( [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf( __( '<strong>There are no menus in your site!</strong><br><a href="%s" target="_blank">Click Here</a> to create a new Menu.', 'moose-elementor-kit' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ], $args, mek_coalescing( $args, 'active_menu', [] ) ) );
        } else {
            $manager->add_control( 'active_menu', array_merge( [
                'label'        => esc_html__( 'Select Menu', 'moose-elementor-kit' ),
                'description'  => sprintf( __( 'Go to <a href="%s" target="_blank">Appearance > Menus</a> to manage your menus.', 'moose-elementor-kit' ), admin_url( 'nav-menus.php' ) ),
                'type'         => Controls_Manager::SELECT,
                'options'      => $menus,
                'default'      => array_keys( $menus )[0],
                'save_default' => true,
            ], $args, mek_coalescing( $args, 'active_menu', [] ) ) );
        }
        
        $manager->add_control( 'menu_depth', array_merge( [
            'label'   => esc_html__( 'Menu Depth', 'moose-elementor-kit' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 10,
            'default' => 0,
        ], $args, mek_coalescing( $args, 'menu_depth', [] ) ) );
    }
    
    protected function add_menu_layout_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        $manager->add_control( 'menu_layout', array_merge( [
            'label'       => esc_html__( 'Layout', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => [
            'horizontal' => __( 'Horizontal', 'moose-elementor-kit' ),
            'vertical'   => __( 'Vertical', 'moose-elementor-kit' ),
        ],
            'default'     => 'horizontal',
        ], $args, mek_coalescing( $args, 'menu_layout', [] ) ) );
        $manager->add_responsive_control( 'menu_align', array_merge( [
            'label'           => esc_html__( 'Align', 'moose-elementor-kit' ),
            'type'            => Controls_Manager::CHOOSE,
            'label_block'     => false,
            'save_default'    => true,
            'default'         => 'left',
            'desktop_default' => 'left',
            'tablet_default'  => 'left',
            'mobile_default'  => 'left',
            'options'         => [
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
        ], $args, mek_coalescing( $args, 'menu_align', [] ) ) );
    }
    
    protected function add_menu_style_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        if ( !mek_array_path( $args, 'menu_preset.disabled', false ) ) {
            $manager->add_control( 'menu_preset', array_merge( [
                'label'   => esc_html__( 'Preset', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'links',
                'options' => [
                'links'     => esc_html__( 'Links', 'moose-elementor-kit' ),
                'underline' => esc_html__( 'Underline (Pro)', 'moose-elementor-kit' ),
                'pills'     => esc_html__( 'Pills (Pro)', 'moose-elementor-kit' ),
                'bordered'  => esc_html__( 'Bordered (Pro)', 'moose-elementor-kit' ),
            ],
            ], $args, mek_coalescing( $args, 'menu_preset', [] ) ) );
        }
        if ( !mek_array_path( $args, 'menu_style.disabled', false ) ) {
            $manager->add_control( 'menu_style', array_merge( [
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
            ], $args, mek_coalescing( $args, 'menu_style', [] ) ) );
        }
        if ( !mek_array_path( $args, 'menu_upsell.disabled', false ) ) {
            Upsell::add_pro_feature_notice( $manager, 'menu_preset_style_', 'Get 4 Menu Styles & 3 Menu Presets On %1$s' );
        }
        if ( !mek_array_path( $args, 'menu_size.disabled', false ) ) {
            $manager->add_control( 'menu_size', array_merge( [
                'label'   => esc_html__( 'Size', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                'xl' => esc_html__( 'Extra Large', 'moose-elementor-kit' ),
                'lg' => esc_html__( 'Large', 'moose-elementor-kit' ),
                'md' => esc_html__( 'Middle', 'moose-elementor-kit' ),
                'sm' => esc_html__( 'Small', 'moose-elementor-kit' ),
                'xs' => esc_html__( 'Extra Small', 'moose-elementor-kit' ),
            ],
                'default' => 'md',
            ], $args, mek_coalescing( $args, 'menu_size', [] ) ) );
        }
        if ( !mek_array_path( $args, 'menu_segment.disabled', false ) ) {
            $manager->add_control( 'menu_segment', array_merge( [
                'label'   => esc_html__( 'Segment', 'moose-elementor-kit' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => false,
            ], $args, mek_coalescing( $args, 'menu_segment', [] ) ) );
        }
    }
    
    protected function add_sub_menu_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        $manager->add_control( 'dropdown_direction', array_merge( [
            'label'       => esc_html__( 'Dropdown Direction', 'moose-elementor-kit' ),
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
        ], $args ) );
    }
    
    /**
     * Custom Menu Style
     *
     * @param null $repeater
     * @param array $args
     */
    protected function add_custom_menu_style_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        if ( !mek_array_path( $args, 'menu_background.disabled', false ) ) {
            $manager->add_responsive_control( 'menu_background', array_merge( [
                'label'     => esc_html__( 'Background Color', 'moose-elementor-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                '{{WRAPPER}} .mek-menu' => 'background-color: {{VALUE}}',
            ],
            ], $args, mek_coalescing( $args, 'menu_background', [] ) ) );
        }
        if ( !mek_array_path( $args, 'menu_box_shadow.disabled', false ) ) {
            $manager->add_group_control( Group_Control_Box_Shadow::get_type(), array_merge( [
                'name'     => 'menu_box_shadow',
                'label'    => esc_html__( 'Shadow', 'moose-elementor-kit' ),
                'selector' => '{{WRAPPER}} .mek-menu',
            ], $args, mek_coalescing( $args, 'menu_box_shadow', [] ) ) );
        }
        if ( !mek_array_path( $args, 'menu_border.disabled', false ) ) {
            $manager->add_group_control( Group_Control_Border::get_type(), array_merge( [
                'name'     => 'menu_border',
                'label'    => esc_html__( 'Border', 'moose-elementor-kit' ),
                'selector' => '{{WRAPPER}} .mek-menu',
            ], $args, mek_coalescing( $args, 'menu_border', [] ) ) );
        }
        if ( !mek_array_path( $args, 'menu_border_radius.disabled', false ) ) {
            $manager->add_responsive_control( 'menu_border_radius', array_merge( [
                'label'      => esc_html__( 'Border Radius', 'moose-elementor-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                '{{WRAPPER}} .mek-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            ], $args, mek_coalescing( $args, 'menu_border_radius', [] ) ) );
        }
        if ( !mek_array_path( $args, 'menu_padding.disabled', false ) ) {
            $manager->add_responsive_control( 'menu_padding', array_merge( [
                'label'      => esc_html__( 'Padding', 'moose-elementor-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                '{{WRAPPER}} .mek-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            ], $args, mek_coalescing( $args, 'menu_padding', [] ) ) );
        }
    }
    
    /**
     * Custom Top Level Menu Item Style
     *
     * @param null $repeater
     * @param array $args
     */
    protected function add_custom_menu_items_style_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        Upsell::add_pro_feature_notice(
            $manager,
            'menu_items_customize_',
            'We provide the ability to fully customize the Menu Items style in %1$s',
            $args
        );
    }
    
    /**
     * Custom Sub Menu Style
     *
     * @param null $repeater
     * @param array $args
     */
    protected function add_custom_sub_menu_style_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        $manager->add_control( 'sub_menu_background', array_merge( [
            'label'     => __( 'Background Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .mek-menu.mek-menu-horizontal .mek-sub-menu'                                                    => 'background-color: {{VALUE}}',
            '{{WRAPPER}} .mek-menu.mek-menu-horizontal > .mek-menu-item > .mek-sub-menu::after'                          => 'border-bottom-color: {{VALUE}}',
            '{{WRAPPER}} .mek-menu.mek-menu-horizontal:not(.mek-menu-dropdown-right) .mek-sub-menu .mek-sub-menu::after' => 'border-left-color: {{VALUE}}',
            '{{WRAPPER}} .mek-menu.mek-menu-horizontal.mek-menu-dropdown-right .mek-sub-menu .mek-sub-menu::after'       => 'border-right-color: {{VALUE}};',
        ],
        ], $args, mek_coalescing( $args, 'sub_menu_background', [] ) ) );
        $manager->add_group_control( Group_Control_Box_Shadow::get_type(), array_merge( [
            'name'     => 'sub_menu_box_shadow',
            'label'    => esc_html__( 'Shadow', 'moose-elementor-kit' ),
            'selector' => '{{WRAPPER}} .mek-menu.mek-menu-horizontal .mek-sub-menu',
        ], $args, mek_coalescing( $args, 'sub_menu_box_shadow', [] ) ) );
        $manager->add_group_control( Group_Control_Border::get_type(), array_merge( [
            'name'     => 'sub_menu_border',
            'label'    => esc_html__( 'Border', 'moose-elementor-kit' ),
            'selector' => '{{WRAPPER}} .mek-menu.mek-menu-horizontal .mek-sub-menu',
        ], $args, mek_coalescing( $args, 'sub_menu_border', [] ) ) );
        $manager->add_responsive_control( 'sub_menu_border_radius', array_merge( [
            'label'      => esc_html__( 'Border Radius', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .mek-menu.mek-menu-horizontal .mek-sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ], $args, mek_coalescing( $args, 'sub_menu_border_radius', [] ) ) );
        $manager->add_responsive_control( 'sub_menu_padding', array_merge( [
            'label'      => esc_html__( 'Padding', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'selectors'  => [
            '{{WRAPPER}} .mek-menu.mek-menu-horizontal .mek-sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ], mek_coalescing( $args, 'sub_menu_padding', [] ) ) );
    }
    
    /**
     * Custom Sub Menu Items Style
     *
     * @param null $repeater
     * @param array $args
     */
    protected function add_custom_sub_menu_items_style_controls( $repeater = null, $args = array() )
    {
        $manager = ( $repeater ?: $this );
        Upsell::add_pro_feature_notice(
            $manager,
            'sub_menu_items_customize_',
            'We provide the ability to fully customize the Sub Menu Items style in %1$s',
            $args
        );
    }

}