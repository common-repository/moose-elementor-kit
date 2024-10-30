<?php

namespace MEK\Widgets;

// If this file is called directly, abort.
use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Background ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Icons_Manager ;
use  Elementor\Repeater ;
use  Elementor\Utils ;
use  Elementor\Widget_Base ;
use  MEK\Traits\Components\Badge ;
use  MEK\Traits\Render ;
use  MEK\Utils\Upsell ;
class PricingTable extends Widget_Base
{
    use  Badge ;
    use  \MEK\Traits\Components\Button ;
    use  Render ;
    public function get_name()
    {
        return 'mek_pricing_table';
    }
    
    public function get_title()
    {
        return esc_html__( 'MEK: Pricing Table', 'moose-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'mek-widget-icon eicon-price-table';
    }
    
    public function get_categories()
    {
        return [ 'moose-elementor-kit' ];
    }
    
    public function get_keywords()
    {
        return [
            'price menu',
            'pricing',
            'price',
            'price table',
            'table',
            'pricing plan',
            'mek',
            'moose'
        ];
    }
    
    protected function register_controls()
    {
        /* Content Tab Start */
        $this->content_price_table_controls();
        $this->content_animation_controls();
        Upsell::add_go_premium_section( $this, [ 'Custom Padding, Margin, Background and Typography For Each Section', 'Ultimate Button Styles', 'Ultimate Badge Styles' ] );
        /* Style Tab Start */
        $this->style_table_controls();
        $this->style_price_controls();
        $this->style_feature_controls();
        $this->style_button_controls();
        $this->style_badge_controls();
    }
    
    protected function content_price_table_controls()
    {
        $this->start_controls_section( 'section_pricing_items', [
            'label' => esc_html__( 'Content', 'moose-elementor-kit' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'item_type', [
            'label'   => esc_html__( 'Type', 'moose-elementor-kit' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'heading',
            'options' => [
            'heading'           => esc_html__( 'Heading', 'moose-elementor-kit' ),
            'secondary-heading' => esc_html__( 'Secondary Heading', 'moose-elementor-kit' ),
            'text'              => esc_html__( 'Text', 'moose-elementor-kit' ),
            'secondary-text'    => esc_html__( 'Secondary Text', 'moose-elementor-kit' ),
            'icon'              => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'badge'             => esc_html__( 'Badge', 'moose-elementor-kit' ),
            'price'             => esc_html__( 'Price', 'moose-elementor-kit' ),
            'feature'           => esc_html__( 'Feature', 'moose-elementor-kit' ),
            'button'            => esc_html__( 'Button', 'moose-elementor-kit' ),
            'divider'           => esc_html__( 'Divider', 'moose-elementor-kit' ),
        ],
        ] );
        $this->content_heading_controls( $repeater );
        $this->content_secondary_heading_controls( $repeater );
        $this->content_text_controls( $repeater );
        $this->content_secondary_text_controls( $repeater );
        $this->content_icon_controls( $repeater );
        $this->content_badge_controls( $repeater );
        $this->content_price_controls( $repeater );
        $this->content_features_controls( $repeater );
        $this->content_button_controls( $repeater );
        $this->content_divider_controls( $repeater );
        $this->content_section_controls( $repeater );
        $this->add_control( 'pricing_items', [
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
            [
            'item_type'     => 'heading',
            'heading_title' => 'Professional',
        ],
            [
            'item_type' => 'text',
            'text'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        ],
            [
            'item_type' => 'price',
        ],
            [
            'item_type'    => 'button',
            'button_label' => 'Buy Now',
            'button_size'  => 'sm',
            'button_block' => 'yes',
        ],
            [
            'item_type' => 'divider',
        ],
            [
            'item_type'                   => 'secondary-heading',
            'secondary_heading_title'     => "What's included",
            'secondary_heading_uppercase' => 'yes',
        ],
            [
            'item_type' => 'feature',
        ],
            [
            'item_type' => 'feature',
        ],
            [
            'item_type' => 'feature',
        ],
            [
            'item_type' => 'feature',
        ]
        ],
            'title_field' => '{{{ item_type }}}',
        ] );
        $this->end_controls_section();
    }
    
    protected function content_heading_controls( $manager )
    {
        $condition = [
            'item_type' => 'heading',
        ];
        $manager->add_control( 'heading_title', [
            'label'     => esc_html__( 'Title', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'Awesome Title',
            'condition' => $condition,
            'separator' => 'before',
        ] );
        $manager->add_control( 'heading_uppercase', [
            'label'     => esc_html__( 'Uppercase', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => false,
            'condition' => $condition,
        ] );
    }
    
    protected function content_secondary_heading_controls( $manager )
    {
        $condition = [
            'item_type' => 'secondary-heading',
        ];
        $manager->add_control( 'secondary_heading_title', [
            'label'     => esc_html__( 'Title', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__( 'Awesome Sub Title', 'moose-elementor-kit' ),
            'condition' => $condition,
            'separator' => 'before',
        ] );
        $manager->add_control( 'secondary_heading_uppercase', [
            'label'     => esc_html__( 'Uppercase', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => false,
            'condition' => $condition,
        ] );
    }
    
    protected function content_text_controls( $manager )
    {
        $manager->add_control( 'text', [
            'label'     => '',
            'type'      => Controls_Manager::TEXTAREA,
            'default'   => esc_html__( 'Awesome Text', 'moose-elementor-kit' ),
            'condition' => [
            'item_type' => 'text',
        ],
            'separator' => 'before',
        ] );
    }
    
    protected function content_secondary_text_controls( $manager )
    {
        $manager->add_control( 'secondary_text', [
            'label'     => '',
            'type'      => Controls_Manager::TEXTAREA,
            'default'   => esc_html__( 'Awesome Sub Text', 'moose-elementor-kit' ),
            'condition' => [
            'item_type' => 'secondary-text',
        ],
            'separator' => 'before',
        ] );
    }
    
    protected function content_icon_controls( $manager )
    {
        $manager->add_control( 'icon_color', [
            'label'     => esc_html__( 'Icon Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'separator' => 'before',
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .mek-pricing-table-icon' => 'color: {{VALUE}};',
        ],
            'condition' => [
            'item_type' => 'icon',
        ],
        ] );
        $manager->add_control( 'icon', [
            'label'       => esc_html__( 'Select Icon', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::ICONS,
            'default'     => [
            'value'   => 'far fa-gem',
            'library' => 'fa-regular',
        ],
            'skin'        => 'inline',
            'label_block' => false,
            'condition'   => [
            'item_type' => 'icon',
        ],
        ] );
    }
    
    protected function content_badge_controls( $manager )
    {
        $this->add_badge_content_controls( $manager, [
            'wrapper'    => '{{WRAPPER}} {{CURRENT_ITEM}}',
            'badge_text' => [
            'separator' => 'before',
        ],
            'condition'  => [
            'item_type' => 'badge',
        ],
        ] );
        $this->add_badge_style_controls( $manager, [
            'condition' => [
            'item_type' => 'badge',
        ],
        ] );
        $this->add_badge_size_controls( $manager, [
            'condition' => [
            'item_type' => 'badge',
        ],
        ] );
        $this->add_badge_state_controls( $manager, [
            'condition'     => [
            'item_type' => 'badge',
        ],
            'badge_outline' => [
            'separator' => 'before',
        ],
        ] );
    }
    
    protected function content_price_controls( $manager )
    {
        $condition = [
            'item_type' => 'price',
        ];
        $manager->add_control( 'price', [
            'label'     => esc_html__( 'Price', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => '39',
            'separator' => 'before',
            'condition' => $condition,
        ] );
        $manager->add_control( 'cent', [
            'label'     => esc_html__( 'Cent', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => '.99',
            'condition' => $condition,
        ] );
        $manager->add_control( 'old_price', [
            'label'     => esc_html__( 'Old Price', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => '59.99',
            'condition' => $condition,
        ] );
        $manager->add_control( 'currency', [
            'label'     => esc_html__( 'Currency', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => '$',
            'condition' => $condition,
            'separator' => 'before',
        ] );
        $manager->add_control( 'period', [
            'label'     => esc_html__( 'Period', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => '/mo',
            'condition' => $condition,
            'separator' => 'before',
        ] );
    }
    
    protected function content_features_controls( $manager )
    {
        $manager->add_control( 'feature_text', [
            'label'     => esc_html__( 'Text', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__( 'Awesome Feature', 'moose-elementor-kit' ),
            'condition' => [
            'item_type' => 'feature',
        ],
            'separator' => 'before',
        ] );
        $manager->add_control( 'feature_text_color', [
            'label'     => esc_html__( 'Text Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .mek-feature-text' => 'color: {{VALUE}};',
        ],
            'condition' => [
            'item_type' => 'feature',
        ],
        ] );
        $manager->add_control( 'feature_icon_color', [
            'label'     => esc_html__( 'Icon Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .mek-feature-icon' => 'color: {{VALUE}};',
        ],
            'condition' => [
            'item_type' => 'feature',
        ],
        ] );
        $manager->add_control( 'feature_icon', [
            'label'       => esc_html__( 'Select Icon', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::ICONS,
            'default'     => [
            'value'   => 'fas fa-check',
            'library' => 'fa-solid',
        ],
            'skin'        => 'inline',
            'label_block' => false,
            'condition'   => [
            'item_type' => 'feature',
        ],
        ] );
        $manager->add_control( 'feature_line_through', [
            'label'     => esc_html__( 'Line Through', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'condition' => [
            'item_type' => 'feature',
        ],
        ] );
    }
    
    protected function content_button_controls( $manager )
    {
        Upsell::add_pro_feature_notice( $manager, 'pricing_table_button_', 'Get More Button Options On %1$s' );
        $this->add_button_content_controls( $manager, [
            'condition'    => [
            'item_type' => 'button',
        ],
            'button_label' => [
            'separator' => 'before',
        ],
            'button_url'   => [
            'separator' => 'after',
        ],
        ] );
        $this->add_button_style_controls( $manager, [
            'condition'           => [
            'item_type' => 'button',
        ],
            'button_style_upsell' => [
            'disabled' => true,
        ],
        ] );
        $this->add_button_size_controls( $manager, [
            'condition' => [
            'item_type' => 'button',
        ],
            'separator' => 'after',
        ] );
        $this->add_button_state_controls( $manager, [
            'condition' => [
            'item_type' => 'button',
        ],
        ] );
    }
    
    protected function content_divider_controls( $manager )
    {
        $manager->add_control( 'divider_style', [
            'label'     => esc_html__( 'Style', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'solid'  => esc_html__( 'Solid', 'moose-elementor-kit' ),
            'double' => esc_html__( 'Double', 'moose-elementor-kit' ),
            'dotted' => esc_html__( 'Dotted', 'moose-elementor-kit' ),
            'dashed' => esc_html__( 'Dashed', 'moose-elementor-kit' ),
            'groove' => esc_html__( 'Groove', 'moose-elementor-kit' ),
        ],
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .mek-pricing-table-divider' => 'border-top-style: {{VALUE}};',
        ],
            'separator' => 'before',
            'condition' => [
            'item_type' => 'divider',
        ],
        ] );
        $manager->add_control( 'divider_color', [
            'label'     => esc_html__( 'Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .mek-pricing-table-divider' => 'border-top-color: {{VALUE}};',
        ],
            'condition' => [
            'item_type' => 'divider',
        ],
        ] );
        $manager->add_responsive_control( 'divider_width', [
            'label'      => esc_html__( 'Width', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [
            'px' => [
            'min' => 5,
            'max' => 300,
        ],
            '%'  => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .mek-pricing-table-divider' => 'width: {{SIZE}}{{UNIT}};',
        ],
            'condition'  => [
            'item_type' => 'divider',
        ],
        ] );
        $manager->add_responsive_control( 'divider_height', [
            'label'      => esc_html__( 'Height', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
            'px' => [
            'min' => 1,
            'max' => 10,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} {{CURRENT_ITEM}} .mek-pricing-table-divider' => 'border-top-width: {{SIZE}}{{UNIT}};',
        ],
            'condition'  => [
            'item_type' => 'divider',
        ],
        ] );
    }
    
    protected function content_section_controls( $manager )
    {
        $manager->add_responsive_control( 'section_text_align', [
            'label'     => esc_html__( 'Text Alignment', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'separator' => 'before',
            'options'   => [
            'left'   => [
            'title' => esc_html__( 'Left', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-left',
        ],
            'center' => [
            'title' => esc_html__( 'Center', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-center',
        ],
            'right'  => [
            'title' => esc_html__( 'Right', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-right',
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
        ],
        ] );
        Upsell::add_pro_feature_notice( $manager, 'pricing_table_section_', 'More Section Options On %1$s' );
    }
    
    protected function content_animation_controls()
    {
        $this->start_controls_section( 'section_table_animation', [
            'label' => esc_html__( 'Hover Animation', 'moose-elementor-kit' ),
        ] );
        $this->add_control( 'pricing_table_hover_animation', [
            'label' => esc_html__( 'Animation', 'moose-elementor-kit' ),
            'type'  => Controls_Manager::HOVER_ANIMATION,
        ] );
        $this->end_controls_section();
    }
    
    protected function style_table_controls()
    {
        $this->start_controls_section( 'section_style_table', [
            'label' => esc_html__( 'Table', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'table_text_align', [
            'label'     => esc_html__( 'Text Alignment', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'left'   => [
            'title' => esc_html__( 'Left', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-left',
        ],
            'center' => [
            'title' => esc_html__( 'Center', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-center',
        ],
            'right'  => [
            'title' => esc_html__( 'Right', 'moose-elementor-kit' ),
            'icon'  => 'eicon-text-align-right',
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .mek-pricing-table' => 'text-align: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'section_typography',
            'selector' => '{{WRAPPER}} .mek-pricing-table',
        ] );
        $this->add_control( 'pricing_table_stretch', [
            'label'     => esc_html__( 'Stretch', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => false,
            'selectors' => [
            "{{WRAPPER}},\n\t\t\t\t{{WRAPPER}} .elementor-widget-container,\n\t\t\t\t{{WRAPPER}} .elementor-widget-container .mek-pricing-table" => 'height: 100%',
        ],
        ] );
        $this->add_control( 'table_padding', [
            'label'      => esc_html__( 'Padding', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'selectors'  => [
            '{{WRAPPER}} .mek-pricing-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'separator'  => 'before',
        ] );
        Upsell::add_pro_feature_notice( $this, 'table_customize_', 'We provide the ability to fully customize the Pricing Table style in %1$s' );
        $this->end_controls_section();
    }
    
    protected function style_price_controls()
    {
        $this->start_controls_section( 'section_style_price', [
            'label' => esc_html__( 'Price', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $position_args = [
            'type'                 => Controls_Manager::CHOOSE,
            'label_block'          => false,
            'options'              => [
            'top'    => [
            'title' => esc_html__( 'Top', 'moose-elementor-kit' ),
            'icon'  => 'eicon-v-align-top',
        ],
            'middle' => [
            'title' => esc_html__( 'Middle', 'moose-elementor-kit' ),
            'icon'  => 'eicon-v-align-middle',
        ],
            'bottom' => [
            'title' => esc_html__( 'Bottom', 'moose-elementor-kit' ),
            'icon'  => 'eicon-v-align-bottom',
        ],
        ],
            'selectors_dictionary' => [
            'top'    => 'flex-start',
            'middle' => 'center',
            'bottom' => 'flex-end',
        ],
        ];
        Upsell::add_pro_feature_notice( $this, 'table_price_customize_', 'We provide the ability to fully customize the Price Section style in %1$s' );
        $this->add_control( 'cent_position', array_merge( [
            'label'     => esc_html__( 'Cent Position', 'moose-elementor-kit' ),
            'separator' => 'before',
            'selectors' => [
            '{{WRAPPER}} .mek-cent' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
        ],
        ], $position_args ) );
        $this->add_control( 'old_price_position', array_merge( [
            'label'     => esc_html__( 'Old Price Position', 'moose-elementor-kit' ),
            'selectors' => [
            '{{WRAPPER}} .mek-old-price' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
        ],
        ], $position_args ) );
        $this->add_control( 'period_position', array_merge( [
            'label'     => esc_html__( 'Period Position', 'moose-elementor-kit' ),
            'selectors' => [
            '{{WRAPPER}} .mek-period' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
        ],
        ], $position_args ) );
        $this->end_controls_section();
    }
    
    protected function style_feature_controls()
    {
        $this->start_controls_section( 'section_style_feature', [
            'label' => esc_html__( 'Feature', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'feature_icon_size', [
            'label'      => esc_html__( 'Icon Size', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .mek-feature-icon' => 'font-size: {{SIZE}}{{UNIT}}',
        ],
        ] );
        $this->add_control( 'feature_icon_spacing', [
            'label'      => esc_html__( 'Icon Spacing', 'moose-elementor-kit' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .mek-feature-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function style_button_controls()
    {
        $this->start_controls_section( 'section_style_button', [
            'label' => esc_html__( 'Button', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_custom_button_controls();
        $this->end_controls_section();
    }
    
    protected function style_badge_controls()
    {
        $this->start_controls_section( 'section_style_badge', [
            'label' => esc_html__( 'Badge', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_custom_badge_controls();
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings();
        $classes = [
            'mek-pricing-table',
            'mek-overflow-hidden mek-relative',
            'mek-border mek-border-solid mek-border-gray-200',
            'mek-bg-base mek-text-base-content',
            'mek-rounded-lg',
            'mek-shadow-sm',
            'mek-py-6'
        ];
        if ( $settings['pricing_table_hover_animation'] ) {
            $classes[] = 'elementor-animation-' . $settings['pricing_table_hover_animation'];
        }
        ?>
        <div class="<?php 
        mek_clsx_echo( $classes );
        ?>">
			<?php 
        foreach ( $settings['pricing_items'] as $key => $item ) {
            $type = $item['item_type'];
            $this->render_before_item( $settings, $item, $key );
            
            if ( $type === 'heading' ) {
                $this->render_heading( $settings, $item, $key );
            } else {
                
                if ( $type == 'secondary-heading' ) {
                    $this->render_secondary_heading( $settings, $item, $key );
                } else {
                    
                    if ( $type == 'text' ) {
                        $this->render_text( $settings, $item, $key );
                    } else {
                        
                        if ( $type == 'secondary-text' ) {
                            $this->render_secondary_text( $settings, $item, $key );
                        } else {
                            
                            if ( $type == 'icon' ) {
                                $this->render_icon( $settings, $item, $key );
                            } else {
                                
                                if ( $type == 'badge' ) {
                                    $this->render_badge( $item, $key );
                                } else {
                                    
                                    if ( $type == 'price' ) {
                                        $this->render_price( $settings, $item, $key );
                                    } else {
                                        
                                        if ( $type == 'feature' ) {
                                            $this->render_feature( $settings, $item, $key );
                                        } else {
                                            
                                            if ( $type == 'button' ) {
                                                $this->render_button( $settings, $item, $key );
                                            } else {
                                                if ( $type == 'divider' ) {
                                                    $this->render_divider( $settings, $item, $key );
                                                }
                                            }
                                        
                                        }
                                    
                                    }
                                
                                }
                            
                            }
                        
                        }
                    
                    }
                
                }
            
            }
            
            $this->render_after_item( $settings, $item, $key );
        }
        ?>
        </div>
		<?php 
    }
    
    /**
     * Before echo price item
     *
     * @param $settings
     * @param $item
     * @param $key
     */
    protected function render_before_item( $settings, $item, $key )
    {
        $section_classes = [ 'elementor-repeater-item-' . $item['_id'] ];
        if ( $item['item_type'] !== 'divider' ) {
            $section_classes[] = 'mek-px-6';
        }
        $spacing = [
            'heading'           => 'mek-mt-2',
            'secondary-heading' => 'mek-mt-4',
            'text'              => 'mek-mt-4',
            'secondary-text'    => 'mek-mt-4',
            'icon'              => 'mek-mt-4',
            'badge'             => 'mek-mt-2',
            'price'             => 'mek-mt-8',
            'feature'           => 'mek-mt-4',
            'button'            => 'mek-mt-8',
            'divider'           => 'mek-my-6',
        ];
        if ( isset( $spacing[$item['item_type']] ) ) {
            $section_classes[] = $spacing[$item['item_type']];
        }
        ?>
        <section class="<?php 
        mek_clsx_echo( $section_classes );
        ?>">
		<?php 
    }
    
    protected function render_heading( $settings, $item, $key )
    {
        $classes = [ 'mek-text-2xl mek-leading-6 mek-font-semibold', 'mek-uppercase mek-tracking-wide' => $item['heading_uppercase'] === 'yes' ];
        ?>
        <h2 class="<?php 
        mek_clsx_echo( $classes );
        ?>">
			<?php 
        echo  esc_html( $item['heading_title'] ) ;
        ?>
        </h2>
		<?php 
    }
    
    protected function render_secondary_heading( $settings, $item, $key )
    {
        $classes = [ 'mek-text-xs mek-font-semibold', 'mek-uppercase mek-tracking-wide' => $item['secondary_heading_uppercase'] === 'yes' ];
        ?>
        <h3 class="<?php 
        mek_clsx_echo( $classes );
        ?>">
			<?php 
        echo  esc_html( $item['secondary_heading_title'] ) ;
        ?>
        </h3>
		<?php 
    }
    
    protected function render_text( $settings, $item, $key )
    {
        $classes = [ 'mek-text-sm mek-leading-normal' ];
        ?>
        <p class="<?php 
        mek_clsx_echo( $classes );
        ?>">
			<?php 
        echo  esc_html( $item['text'] ) ;
        ?>
        </p>
		<?php 
    }
    
    protected function render_secondary_text( $settings, $item, $key )
    {
        $classes = [ 'mek-text-xs mek-leading-normal' ];
        ?>
        <p class="<?php 
        mek_clsx_echo( $classes );
        ?>">
			<?php 
        echo  esc_html( $item['secondary_text'] ) ;
        ?>
        </p>
		<?php 
    }
    
    protected function render_icon( $settings, $item, $key )
    {
        ?>
        <div class="mek-pricing-table-icon mek-text-6xl">
			<?php 
        Icons_Manager::render_icon( $item['icon'], [
            'aria-hidden' => 'true',
        ] );
        ?>
        </div>
		<?php 
    }
    
    protected function render_price( $settings, $item, $key )
    {
        ?>
        <p class="mek-inline-flex">
			<?php 
        
        if ( !Utils::is_empty( $item['old_price'] ) ) {
            ?>
                <del class="mek-old-price mek-mr-1.5 mek-text-sm mek-self-center mek-opacity-60"><?php 
            echo  esc_html( $item['old_price'] ) ;
            ?></del>
			<?php 
        }
        
        ?>
			<?php 
        
        if ( !Utils::is_empty( $item['currency'] ) ) {
            ?>
                <span class="mek-currency mek-text-2xl mek-self-center mek-font-bold mek-self-center mek-leading-none"><?php 
            echo  esc_html( $item['currency'] ) ;
            ?></span>
			<?php 
        }
        
        ?>
			<?php 
        
        if ( !Utils::is_empty( $item['price'] ) ) {
            ?>
                <span class="mek-price mek-text-4xl mek-font-extrabold mek-self-center mek-leading-none"><?php 
            echo  esc_html( $item['price'] ) ;
            ?></span>
			<?php 
        }
        
        ?>
			<?php 
        
        if ( !Utils::is_empty( $item['cent'] ) ) {
            ?>
                <span class="mek-cent mek-text-sm mek-self-end"><?php 
            echo  esc_html( $item['cent'] ) ;
            ?></span>
			<?php 
        }
        
        ?>
			<?php 
        
        if ( !Utils::is_empty( $item['period'] ) ) {
            ?>
                <span class="mek-period mek-ml-1.5 mek-text-sm mek-font-medium mek-self-end mek-opacity-50">
                    <?php 
            echo  esc_html( $item['period'] ) ;
            ?>
                </span>
			<?php 
        }
        
        ?>
        </p>
		<?php 
    }
    
    protected function render_feature( $settings, $item, $key )
    {
        $del = $item['feature_line_through'] === 'yes';
        $ico_classes = [ "mek-feature-icon mek-flex-shrink-0 mek-text-sm mek-mr-1.5 mek-align-middle" ];
        $ico_classes[] = ( $del ? "mek-opacity-70" : "mek-text-green-500" );
        ?>
        <div>
			<?php 
        
        if ( !Utils::is_empty( $item['feature_icon']['value'] ) ) {
            ?>
                <span class="<?php 
            mek_clsx_echo( $ico_classes );
            ?>">
                    <?php 
            Icons_Manager::render_icon( $item['feature_icon'] );
            ?>
                </span>
			<?php 
        }
        
        ?>
            <span class="text-xs leading-normal mek-align-middle">
                <?php 
        $content = sprintf(
            '%1$s%2$s%3$s',
            ( $del ? '<del class="mek-text-gray-600">' : '' ),
            esc_html( $item['feature_text'] ),
            ( $del ? '</del>' : '' )
        );
        echo  wp_kses( $content, [
            'del' => [
            'class' => [],
        ],
        ] ) ;
        ?>
            </span>
        </div>
		<?php 
    }
    
    protected function render_button( $settings, $item, $key )
    {
        $classes = $this->get_button_classes( $item );
        if ( isset( $item['button_id'] ) && '' !== $item['button_id'] ) {
            $this->add_render_attribute( 'button_link_' . $key, 'id', $item['button_id'] );
        }
        $this->render_link_item( [
            'key'             => 'button_link_' . $key,
            'link'            => $item['button_url'],
            'text'            => $item['button_label'],
            'default_classes' => $classes,
        ] );
    }
    
    protected function render_divider( $settings, $item, $key )
    {
        ?>
        <div class="mek-pricing-table-divider mek-mx-auto mek-border-t mek-border-solid mek-border-slate-400/25"></div>
		<?php 
    }
    
    /**
     * After each price item
     *
     * @param $settings
     * @param $item
     * @param $key
     */
    protected function render_after_item( $settings, $item, $key )
    {
        ?>
        </section>
		<?php 
    }

}