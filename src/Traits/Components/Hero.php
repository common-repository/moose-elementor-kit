<?php

namespace MEK\Traits\Components;

use  Elementor\Controls_Manager ;
use  Elementor\Core\Schemes\Typography ;
use  Elementor\Group_Control_Background ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Utils ;
use  MEK\Traits\Render ;
use  MEK\Utils\Upsell ;
trait Hero
{
    use  Button ;
    use  Render ;
    /**
     * @param \Elementor\Widget_Base $manager
     * @param array $args
     */
    protected function add_hero_content_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $wrapper = mek_coalescing( $args, 'wrapper', '{{WRAPPER}}' );
        $manager->start_controls_tabs( 'hero_background_content' );
        /**
         * Background Tab
         */
        $manager->start_controls_tab( 'hero_background_tab', [
            'label' => esc_html__( 'Background', 'moose-elementor-kit' ),
        ] );
        $manager->add_group_control( Group_Control_Background::get_type(), [
            'name'      => 'hero_background',
            'label'     => esc_html__( 'Background', 'moose-elementor-kit' ),
            'types'     => [ 'classic', 'gradient' ],
            'separator' => 'before',
            'selector'  => $wrapper . ' .mek-hero .mek-hero-background',
        ] );
        $manager->add_control( 'hero_background_ken_burns', [
            'label'     => esc_html__( 'Ken Burns Effects', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'selectors' => [
            $wrapper . ' .mek-hero .mek-hero-background' => 'animation: ken-burns 40s ease;',
        ],
        ] );
        $manager->add_control( 'hero_overlay', [
            'label'     => esc_html__( 'Overlay', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'default'   => 'yes',
        ] );
        $manager->add_control( 'hero_overlay_color', [
            'label'     => esc_html__( 'Overlay Color', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(30, 41, 59, 0.7)',
            'condition' => [
            'hero_overlay' => 'yes',
        ],
            'selectors' => [
            $wrapper . ' .mek-hero .mek-hero-overlay' => 'background: {{VALUE}};',
        ],
        ] );
        $manager->add_control( 'hero_overlay_blend_mode', [
            'label'     => esc_html__( 'Blend Mode', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'normal',
            'options'   => mek_blend_options(),
            'selectors' => [
            $wrapper . ' .mek-hero .mek-hero-overlay' => 'mix-blend-mode: {{VALUE}}',
        ],
            'condition' => [
            'hero_overlay' => 'yes',
        ],
        ] );
        $manager->end_controls_tab();
        /**
         * Content Tab
         */
        $manager->start_controls_tab( 'hero_content_tab', [
            'label' => esc_html__( 'Content', 'moose-elementor-kit' ),
        ] );
        $manager->add_responsive_control( 'has_hero_media', [
            'label'                => esc_html__( 'Enable Media', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'selectors_dictionary' => [
            ''    => 'none',
            'yes' => 'block',
        ],
            'selectors'            => [
            $wrapper . ' .mek-hero .mek-hero-media' => 'display: {{VALUE}};',
        ],
        ] );
        /**
         * Media
         */
        $has_media_condition = [
            'has_hero_media' => 'yes',
        ];
        $manager->add_responsive_control( 'hero_layout', [
            'label'     => esc_html__( 'Layout', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'row',
            'options'   => [
            'row'            => esc_html__( 'Row', 'moose-elementor-kit' ),
            'row-reverse'    => esc_html__( 'Row Reverse', 'moose-elementor-kit' ),
            'column'         => esc_html__( 'Column', 'moose-elementor-kit' ),
            'column-reverse' => esc_html__( 'Column Reverse', 'moose-elementor-kit' ),
        ],
            'condition' => $has_media_condition,
            'selectors' => [
            $wrapper . ' .mek-hero' => 'flex-direction: {{VALUE}};',
        ],
        ] );
        $manager->add_control( 'hero_media', [
            'label'     => esc_html__( 'Media', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::MEDIA,
            'condition' => $has_media_condition,
            'default'   => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'separator' => 'before',
        ] );
        /**
         * Content
         */
        $has_content_condition = [];
        $manager->add_responsive_control( 'hero_content_align', [
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
            'condition' => $has_content_condition,
            'default'   => 'center',
            'selectors' => [
            $wrapper . ' .mek-hero .mek-hero-content' => 'text-align: {{VALUE}};',
        ],
            'separator' => 'before',
        ] );
        $manager->add_control( 'hero_title', [
            'label'     => esc_html__( 'Title', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => "I'm A",
            'condition' => $has_content_condition,
        ] );
        $manager->add_control( 'hero_subtitle', [
            'label'     => esc_html__( 'Subtitle', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'Hero',
            'condition' => $has_content_condition,
        ] );
        $manager->add_control( 'hero_description', [
            'label'     => esc_html__( 'Description', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXTAREA,
            'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'condition' => $has_content_condition,
        ] );
        // Primary Button
        $manager->add_control( 'hero_primary_btn_divider', array_merge( [
            'type'      => Controls_Manager::DIVIDER,
            'style'     => 'thick',
            'condition' => $has_content_condition,
        ], $args, mek_coalescing( $args, 'hero_primary_btn_divider', [] ) ) );
        $manager->add_responsive_control( 'hero_primary_btn', [
            'label'                => esc_html__( 'Primary Button', 'moose-elementor-kit' ),
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
            'yes' => 'inline-block',
        ],
            'condition'            => $has_content_condition,
            'selectors'            => [
            $wrapper . ' .mek-hero .mek-hero-primary-btn' => 'display: {{VALUE}};',
        ],
        ] );
        $primary_button_condition = array_merge( [
            'hero_primary_btn' => 'yes',
        ], $has_content_condition );
        $this->add_button_content_controls( $manager, array_merge( [
            'key'       => 'primary',
            'condition' => $primary_button_condition,
        ], $args, mek_coalescing( $args, 'primary_button_content', [] ) ) );
        $this->add_button_style_controls( $manager, array_merge( [
            'key'                 => 'primary',
            'condition'           => $primary_button_condition,
            'button_style_upsell' => [
            'disabled' => true,
        ],
        ], $args, mek_coalescing( $args, 'primary_button_style', [] ) ) );
        $this->add_button_size_controls( $manager, array_merge( [
            'key'             => 'primary',
            'default'         => 'lg',
            'desktop_default' => 'lg',
            'condition'       => $primary_button_condition,
        ], $args, mek_coalescing( $args, 'primary_button_size', [] ) ) );
        $this->add_button_state_controls( $manager, array_merge( [
            'key'             => 'primary',
            'condition'       => $primary_button_condition,
            'button_disabled' => [
            'disabled' => true,
        ],
            'button_wide'     => [
            'disabled' => true,
        ],
            'button_block'    => [
            'disabled' => true,
        ],
        ], $args, mek_coalescing( $args, 'primary_button_state', [] ) ) );
        $manager->add_responsive_control( 'primary_btn_display', [
            'label'                => esc_html__( 'Block', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'condition'            => $primary_button_condition,
            'default'              => '',
            'widescreen_default'   => '',
            'laptop_default'       => '',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'inline-block',
            'yes' => 'block',
        ],
            'selectors'            => [
            $wrapper . ' .mek-hero .mek-hero-primary-btn'          => 'display: {{VALUE}};',
            $wrapper . ' .mek-hero .mek-hero-primary-btn .mek-btn' => 'display: {{VALUE}};',
        ],
        ] );
        // Secondary Button
        $manager->add_control( 'hero_secondary_btn_divider', array_merge( [
            'type'      => Controls_Manager::DIVIDER,
            'style'     => 'thick',
            'condition' => $has_content_condition,
        ], $args, mek_coalescing( $args, 'hero_secondary_btn_divider', [] ) ) );
        $manager->add_responsive_control( 'hero_secondary_btn', [
            'label'                => esc_html__( 'Secondary Button', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'condition'            => $has_content_condition,
            'default'              => 'yes',
            'widescreen_default'   => 'yes',
            'laptop_default'       => 'yes',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'none',
            'yes' => 'inline-block',
        ],
            'selectors'            => [
            $wrapper . ' .mek-hero .mek-hero-secondary-btn' => 'display:{{VALUE}};',
        ],
        ] );
        $secondary_button_condition = array_merge( [
            'hero_secondary_btn' => 'yes',
        ], $has_content_condition );
        $this->add_button_content_controls( $manager, array_merge( [
            'key'       => 'secondary',
            'condition' => $secondary_button_condition,
        ], $args, mek_coalescing( $args, 'secondary_button_content', [] ) ) );
        $this->add_button_style_controls( $manager, array_merge( [
            'key'                 => 'secondary',
            'condition'           => $secondary_button_condition,
            'button_style_upsell' => [
            'disabled' => true,
        ],
        ], $args, mek_coalescing( $args, 'secondary_button_style', [] ) ) );
        $this->add_button_size_controls( $manager, array_merge( [
            'key'             => 'secondary',
            'default'         => 'lg',
            'desktop_default' => 'lg',
            'condition'       => $secondary_button_condition,
        ], $args, mek_coalescing( $args, 'secondary_button_size', [] ) ) );
        $this->add_button_state_controls( $manager, array_merge( [
            'key'             => 'secondary',
            'condition'       => $secondary_button_condition,
            'button_outline'  => [
            'default' => 'yes',
        ],
            'button_disabled' => [
            'disabled' => true,
        ],
            'button_wide'     => [
            'disabled' => true,
        ],
            'button_block'    => [
            'disabled' => true,
        ],
        ], $args, mek_coalescing( $args, 'secondary_button_state', [] ) ) );
        $manager->add_responsive_control( 'secondary_btn_display', [
            'label'                => esc_html__( 'Block', 'moose-elementor-kit' ),
            'type'                 => Controls_Manager::SWITCHER,
            'condition'            => $secondary_button_condition,
            'default'              => '',
            'widescreen_default'   => '',
            'laptop_default'       => '',
            'tablet_extra_default' => 'yes',
            'tablet_default'       => 'yes',
            'mobile_extra_default' => 'yes',
            'mobile_default'       => 'yes',
            'selectors_dictionary' => [
            ''    => 'inline-block',
            'yes' => 'block',
        ],
            'selectors'            => [
            $wrapper . ' .mek-hero .mek-hero-secondary-btn'          => 'display: {{VALUE}};',
            $wrapper . ' .mek-hero .mek-hero-secondary-btn .mek-btn' => 'display: {{VALUE}};',
        ],
        ] );
        $manager->end_controls_tab();
        $manager->end_controls_tabs();
    }
    
    /**
     * @param \Elementor\Widget_Base $manager
     * @param array $args
     */
    protected function add_custom_hero_content_controls( $manager = null, $args = array() )
    {
        $manager = ( $manager ?: $this );
        $key = mek_coalescing( $args, 'key', '' );
        $wrapper = mek_coalescing( $args, 'wrapper', '{{WRAPPER}}' );
        if ( !mek_array_path( $args, 'hero_height.disabled', false ) ) {
            $manager->add_responsive_control( $key . 'hero_height', [
                'label'      => esc_html__( 'Height', 'moose-elementor-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                'rem' => [
                'min' => 0,
                'max' => 100,
            ],
                'px'  => [
                'min' => 0,
                'max' => 2000,
            ],
            ],
                'default'    => [
                'size' => 28,
                'unit' => 'rem',
            ],
                'size_units' => [ 'rem', 'px' ],
                'separator'  => 'before',
                'selectors'  => [
                $wrapper . ' .mek-hero' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
            ] );
        }
        if ( !mek_array_path( $args, 'hero_content_width.disabled', false ) ) {
            $manager->add_responsive_control( $key . 'hero_content_width', [
                'label'      => esc_html__( 'Content Width', 'moose-elementor-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                'rem' => [
                'min' => 0,
                'max' => 100,
            ],
                '%'   => [
                'min' => 0,
                'max' => 100,
            ],
                'px'  => [
                'min' => 0,
                'max' => 2000,
            ],
            ],
                'size_units' => [ 'rem', '%', 'px' ],
                'separator'  => 'before',
                'selectors'  => [
                $wrapper . ' .mek-hero .mek-hero-content' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%;',
            ],
            ] );
        }
        Upsell::add_pro_feature_notice( $this, 'hero_customize_', 'We provide the ability to fully customize hero style in %1$s' );
    }
    
    /**
     * Output hero html
     *
     * @param array $settings
     */
    protected function render_hero( $settings )
    {
        $primary_btn_classes = $this->get_button_classes( $settings, 'primary' );
        $secondary_btn_classes = $this->get_button_classes( $settings, 'secondary' );
        $primary_btn_classes[] = 'mek-m-2';
        $secondary_btn_classes[] = 'mek-m-2';
        ?>
        <div class="mek-hero mek-relative mek-overflow-hidden mek-flex mek-items-center mek-justify-center mek-px-4 lg:mek-px-8 mek-py-6 lg:mek-py-12">
			<?php 
        if ( $settings['hero_overlay'] === 'yes' ) {
            ?>
                <div class="mek-hero-overlay mek-absolute mek-w-full mek-h-full mek-left-0 mek-top-0 mek-z-[1]"></div>
			<?php 
        }
        ?>
            <div class="mek-hero-background mek-absolute mek-w-full mek-h-full mek-left-0 mek-top-0 mek-z-[0]"></div>
            <div class="mek-hero-content mek-relative mek-z-10">
                <h1 class="mek-hero-heading mek-text-3xl sm:mek-text-4xl md:mek-text-6xl mek-tracking-tight mek-font-extrabold mek-text-gray-50">
                    <span class="mek-hero-title">
                        <?php 
        echo  esc_html( $settings['hero_title'] ) ;
        ?>
                    </span>
                    <span class="mek-hero-subtitle mek-text-primary">
                        <?php 
        echo  esc_html( $settings['hero_subtitle'] ) ;
        ?>
                    </span>
                </h1>
				<?php 
        
        if ( $settings['hero_description'] !== '' ) {
            ?>
                    <p class="mek-hero-description mek-text-gray-50/70 mek-mt-5 md:mek-mt-8">
						<?php 
            echo  esc_html( $settings['hero_description'] ) ;
            ?>
                    </p>
				<?php 
        }
        
        ?>
				<?php 
        
        if ( $settings['hero_primary_btn'] === 'yes' || $settings['hero_secondary_btn'] === 'yes' ) {
            ?>
                    <div class="mek-hero-buttons mek-mt-8 md:mek-mt-12">
						<span class="mek-hero-primary-btn">
                        <?php 
            $this->render_link_item( [
                'key'             => 'primary_button',
                'text'            => $settings['primarybutton_label'],
                'link'            => $settings['primarybutton_url'],
                'default_classes' => $primary_btn_classes,
            ] );
            ?>
                        </span>
                        <span class="mek-hero-secondary-btn">
						<?php 
            $this->render_link_item( [
                'key'             => 'secondary_button',
                'text'            => $settings['secondarybutton_label'],
                'link'            => $settings['secondarybutton_url'],
                'default_classes' => $secondary_btn_classes,
            ] );
            ?>
                        </span>
                    </div>
				<?php 
        }
        
        ?>
            </div>
            <div
                    class="mek-hero-media mek-flex-shrink-0 mek-relative mek-z-[1] mek-mt-6 lg:mek-mt-0 lg:mek-ml-6 mek-max-w-[30%]">
				<?php 
        $this->render_image( $settings, 'hero_media' );
        ?>
            </div>
        </div>
		<?php 
    }

}