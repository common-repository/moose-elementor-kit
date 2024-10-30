<?php

namespace MEK\Widgets;

// If this file is called directly, abort.
use  Elementor\Controls_Manager ;
use  Elementor\Icons_Manager ;
use  Elementor\Repeater ;
use  Elementor\Utils ;
use  Elementor\Widget_Base ;
use  MEK\Traits\Components\Badge ;
use  MEK\Traits\Render ;
use  MEK\Utils\Upsell ;
class Card extends Widget_Base
{
    use  \MEK\Traits\Components\Button ;
    use  \MEK\Traits\Components\Card ;
    use  Badge ;
    use  Render ;
    public function get_name()
    {
        return 'mek_card';
    }
    
    public function get_title()
    {
        return esc_html__( 'MEK: Card', 'moose-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'mek-widget-icon eicon-image-box';
    }
    
    public function get_categories()
    {
        return [ 'moose-elementor-kit' ];
    }
    
    public function get_keywords()
    {
        return [
            'card',
            'image',
            'info',
            'box',
            'mek',
            'moose'
        ];
    }
    
    protected function register_controls()
    {
        /* Content Tab Start */
        $this->content_card_basic_controls();
        $this->content_card_media_controls();
        $this->content_card_metas_controls();
        $this->content_card_badges_controls();
        $this->content_card_button_controls();
        $this->content_animation_controls();
        Upsell::add_go_premium_section( $this, [
            'Overlay Card',
            '9 Overlay Styles',
            '9 More Button Styles',
            '7 More Badge Styles',
            'Full Customize Options'
        ] );
        /* Style Tab Start */
        $this->style_card_media_controls();
        $this->style_card_body_controls();
        $this->style_card_overlay_controls();
        $this->style_card_content_controls();
        $this->style_badge_controls();
        $this->style_button_controls();
    }
    
    protected function content_card_basic_controls()
    {
        $this->start_controls_section( 'section_basic', [
            'label' => esc_html__( 'Basic', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_card_content_controls();
        $this->add_card_layout_controls();
        $this->end_controls_section();
    }
    
    protected function content_card_media_controls()
    {
        $this->start_controls_section( 'section_media', [
            'label' => esc_html__( 'Media', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'card_media', [
            'label'       => esc_html__( 'Media', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::CHOOSE,
            'label_block' => true,
            'options'     => [
            'none' => [
            'title' => esc_html__( 'None', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-ban',
        ],
            'text' => [
            'title' => esc_html__( 'Text', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-font',
        ],
            'icon' => [
            'title' => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-info-circle',
        ],
            'img'  => [
            'title' => esc_html__( 'Image', 'moose-elementor-kit' ),
            'icon'  => 'eicon-image-bold',
        ],
        ],
            'default'     => 'img',
        ] );
        /**
         * Condition: 'card_media' => 'text'
         */
        $this->add_control( 'card_media_text', [
            'label'     => esc_html__( 'Text', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::TEXT,
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'card_media' => 'text',
        ],
        ] );
        /**
         * Condition: 'card_media' => 'icon'
         */
        $this->add_control( 'card_media_icon', [
            'label'     => esc_html__( 'Card Icon', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
            'value'   => 'fas fa-star',
            'library' => 'fa-solid',
        ],
            'condition' => [
            'card_media' => 'icon',
        ],
        ] );
        $this->add_control( 'card_media_icon_view', [
            'label'        => esc_html__( 'View', 'moose-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'options'      => [
            'default' => esc_html__( 'Default', 'moose-elementor-kit' ),
            'stacked' => esc_html__( 'Stacked', 'moose-elementor-kit' ),
            'framed'  => esc_html__( 'Framed', 'moose-elementor-kit' ),
        ],
            'default'      => 'default',
            'prefix_class' => 'mek-card-icon-view-',
            'condition'    => [
            'card_media' => [ 'icon', 'text' ],
        ],
        ] );
        $this->add_control( 'card_media_icon_shape', [
            'label'        => esc_html__( 'Shape', 'moose-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'options'      => [
            'circle' => esc_html__( 'Circle', 'moose-elementor-kit' ),
            'square' => esc_html__( 'Square', 'moose-elementor-kit' ),
        ],
            'default'      => 'circle',
            'condition'    => [
            'card_media_icon_view!' => 'default',
        ],
            'prefix_class' => 'mek-card-icon-shape-',
        ] );
        /**
         * Condition: 'card_media' => 'img'
         */
        $this->add_control( 'card_media_image', [
            'label'     => esc_html__( 'Card Image', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::MEDIA,
            'default'   => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'condition' => [
            'card_media' => 'img',
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function content_card_metas_controls()
    {
        $this->start_controls_section( 'section_metas', [
            'label' => esc_html__( 'Metas', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'meta_icon', [
            'label'   => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'type'    => Controls_Manager::ICONS,
            'default' => [
            'value'   => 'fas fa-pen-nib',
            'library' => 'fa-solid',
        ],
        ] );
        $repeater->add_control( 'meta_text', [
            'label'       => esc_html__( 'Text', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Meta', 'moose-elementor-kit' ),
            'label_block' => true,
        ] );
        $repeater->add_control( 'meta_link', [
            'label_block' => true,
            'label'       => esc_html__( 'Link', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::URL,
            'dynamic'     => [
            'active' => true,
        ],
            'placeholder' => esc_html__( 'https://your-link.com', 'moose-elementor-kit' ),
        ] );
        $this->add_control( 'card_metas', [
            'label'         => esc_html__( 'Metas', 'moose-elementor-kit' ),
            'type'          => Controls_Manager::REPEATER,
            'fields'        => $repeater->get_controls(),
            'prevent_empty' => false,
            'title_field'   => '{{{ elementor.helpers.renderIcon( this, meta_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ meta_text }}}',
            'default'       => [ [
            'meta_icon' => [
            'value'   => 'fas fa-pen-nib',
            'library' => 'fa-solid',
        ],
            'meta_text' => esc_html__( 'Author', 'moose-elementor-kit' ),
        ], [
            'meta_icon' => [
            'value'   => 'far fa-clock',
            'library' => 'fa-solid',
        ],
            'meta_text' => esc_html__( '1991/01/01', 'moose-elementor-kit' ),
        ], [
            'meta_icon' => [
            'value'   => 'far fa-eye',
            'library' => 'fa-solid',
        ],
            'meta_text' => esc_html__( '99', 'moose-elementor-kit' ),
        ] ],
        ] );
        $this->end_controls_section();
    }
    
    protected function content_card_badges_controls()
    {
        $this->start_controls_section( 'section_badges', [
            'label' => esc_html__( 'Badges', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $repeater = new Repeater();
        $this->add_badge_content_controls( $repeater, [
            'badge_link' => [
            'separator' => 'after',
        ],
        ] );
        $this->add_badge_style_controls( $repeater );
        $this->add_badge_size_controls( $repeater );
        $this->add_badge_state_controls( $repeater, [
            'badge_outline' => [
            'separator' => 'before',
        ],
        ] );
        $this->add_control( 'card_badges', [
            'label'         => esc_html__( 'Badges', 'moose-elementor-kit' ),
            'type'          => Controls_Manager::REPEATER,
            'fields'        => $repeater->get_controls(),
            'prevent_empty' => false,
            'title_field'   => '{{{ badge_text }}}',
            'default'       => [ [
            'badge_text'        => esc_html__( 'Badge #1', 'moose-elementor-kit' ),
            'badge_style'       => 'ghost',
            'badge_pill'        => 'yes',
            'badge_size_mobile' => 'xs',
            'badge_size_tablet' => 'xs',
            'badge_size'        => 'xs',
        ], [
            'badge_text'        => esc_html__( 'Badge #2', 'moose-elementor-kit' ),
            'badge_style'       => 'ghost',
            'badge_pill'        => 'yes',
            'badge_size_mobile' => 'xs',
            'badge_size_tablet' => 'xs',
            'badge_size'        => 'xs',
        ] ],
        ] );
        $this->end_controls_section();
    }
    
    protected function content_card_button_controls()
    {
        $this->start_controls_section( 'section_buttons', [
            'label' => esc_html__( 'Buttons', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $repeater = new Repeater();
        $this->add_button_content_controls( $repeater, [
            'button_url' => [
            'separator' => 'after',
        ],
        ] );
        $this->add_button_style_controls( $repeater );
        $this->add_button_size_controls( $repeater, [
            'separator' => 'after',
        ] );
        $this->add_button_state_controls( $repeater );
        $this->add_control( 'card_buttons', [
            'label'         => esc_html__( 'Buttons', 'moose-elementor-kit' ),
            'type'          => Controls_Manager::REPEATER,
            'fields'        => $repeater->get_controls(),
            'prevent_empty' => false,
            'title_field'   => '{{{ button_label }}}',
            'default'       => [ [
            'button_label' => esc_html__( 'Button #1', 'moose-elementor-kit' ),
        ], [
            'button_label'   => esc_html__( 'Button #2', 'moose-elementor-kit' ),
            'button_outline' => 'yes',
        ] ],
        ] );
        $this->end_controls_section();
    }
    
    /**
     * Controls of hover animation section under content tab
     */
    protected function content_animation_controls()
    {
        $this->start_controls_section( 'section_card_animation', [
            'label' => esc_html__( 'Hover Animation', 'moose-elementor-kit' ),
        ] );
        $this->add_control( 'card_hover_animation', [
            'label' => esc_html__( 'Animation', 'moose-elementor-kit' ),
            'type'  => Controls_Manager::HOVER_ANIMATION,
        ] );
        $this->end_controls_section();
    }
    
    protected function style_card_media_controls()
    {
        /**
         * Condition: 'card_media' => [ 'text', 'icon' ]
         */
        $this->start_controls_section( 'section_style_card_media_icon', [
            'label'     => esc_html__( 'Icon & Text Style', 'moose-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'card_media' => [ 'text', 'icon' ],
        ],
        ] );
        $this->add_card_icon_text_style_controls();
        $this->end_controls_section();
        /**
         * Condition: 'card_media' => 'img'
         */
        $this->start_controls_section( 'section_style_card_image', [
            'label'     => esc_html__( 'Image Style', 'moose-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'card_media' => 'img',
        ],
        ] );
        $this->add_card_image_style_controls( $this, [
            'card_image_size' => [
            'condition' => [
            'card_media_image[url]!' => '',
            'card_media'             => 'img',
        ],
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function style_card_content_controls()
    {
        $this->start_controls_section( 'section_style_card_content', [
            'label' => esc_html__( 'Content', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_card_content_style_controls();
        $this->end_controls_section();
    }
    
    protected function style_card_body_controls()
    {
        $this->start_controls_section( 'section_style_card_body', [
            'label' => esc_html__( 'Card Body', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_card_body_style_controls();
        $this->end_controls_section();
    }
    
    protected function style_card_overlay_controls()
    {
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
    
    protected function style_button_controls()
    {
        $this->start_controls_section( 'section_style_button', [
            'label' => esc_html__( 'Button', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_custom_button_controls();
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings();
        $classes = $this->get_card_classes( $settings );
        if ( isset( $settings['card_hover_animation'] ) && $settings['card_hover_animation'] ) {
            $classes[] = 'elementor-animation-' . $settings['card_hover_animation'];
        }
        ?>
        <div class="<?php 
        mek_clsx_echo( $classes );
        ?>">
			<?php 
        $this->render_media( $settings );
        ?>
            <div class="mek-card-body">
				<?php 
        
        if ( !Utils::is_empty( $settings['card_title'] ) ) {
            ?>
                    <h3 class="mek-card-title">
						<?php 
            $this->render_link_item( [
                'key'          => 'card_title',
                'link'         => $settings['card_link'],
                'text'         => $settings['card_title'],
                'link_classes' => [ 'mek-link', 'mek-link-ltr' ],
            ] );
            ?>
                    </h3>
				<?php 
        }
        
        ?>

				<?php 
        $this->render_metas( $settings );
        ?>

				<?php 
        
        if ( !Utils::is_empty( $settings['card_description'] ) ) {
            ?>
                    <p class="mek-card-text">
						<?php 
            $this->print_unescaped_setting( 'card_description' );
            ?>
                    </p>
				<?php 
        }
        
        ?>
				<?php 
        $this->render_badges( $settings );
        ?>
				<?php 
        $this->render_buttons( $settings );
        ?>
            </div>
        </div>
		<?php 
    }
    
    /**
     * Render card media
     *
     * @param $settings
     */
    protected function render_media( $settings )
    {
        $media_type = $settings["card_media"];
        if ( $media_type === 'none' ) {
            return;
        }
        $this->add_link_attributes( 'card_link', $settings['card_link'] );
        
        if ( $media_type === 'img' ) {
            $classes = [ 'mek-card-image mek-mx-auto' ];
            if ( isset( $settings['card_image_hover_animation'] ) && $settings['card_image_hover_animation'] ) {
                $classes[] = 'elementor-animation-' . $settings['card_image_hover_animation'];
            }
            ?>
            <a class="<?php 
            mek_clsx_echo( $classes );
            ?>" <?php 
            $this->print_render_attribute_string( 'card_link' );
            ?>>
				<?php 
            $this->render_image( $settings, 'card_media_image', 'card_image_size' );
            ?>
            </a>
			<?php 
            return;
        }
        
        $classes = [ 'mek-block mek-card-media mek-transition-colors mek-duration-200 mek-text-9xl mek-p-4 mek-text-center' ];
        if ( isset( $settings['media_icon_text_hover_animation'] ) && $settings['media_icon_text_hover_animation'] ) {
            $classes[] = 'elementor-animation-' . $settings['media_icon_text_hover_animation'];
        }
        ?>
        <a class="<?php 
        mek_clsx_echo( $classes );
        ?>" <?php 
        $this->print_render_attribute_string( 'card_link' );
        ?>>
            <span class="mek-card-media-icon-text">
				<?php 
        
        if ( $media_type === 'text' ) {
            echo  '<span class="mek-card-text-icon">' . esc_html( $settings['card_media_text'] ) . '</span>' ;
        } else {
            Icons_Manager::render_icon( $settings['card_media_icon'], [
                'aria-hidden' => 'true',
            ] );
        }
        
        ?>
            </span>
        </a>
		<?php 
    }
    
    /**
     * Render Card Metas
     *
     * @param $settings
     */
    protected function render_metas( $settings )
    {
        
        if ( !empty($settings['card_metas']) ) {
            echo  '<div class="mek-card-metas">' ;
            foreach ( $settings['card_metas'] as $index => $item ) {
                echo  '<span class="mek-mr-3">' ;
                Icons_Manager::render_icon( $item['meta_icon'], [
                    'aria-hidden' => 'true',
                    'class'       => 'mek-mr-1.5',
                ] );
                $this->render_link_item( [
                    'key'          => 'meta_link_' . $index,
                    'link'         => $item['meta_link'],
                    'text'         => $item['meta_text'],
                    'link_classes' => [ 'mek-link mek-link-hover-primary' ],
                ] );
                echo  '</span>' ;
            }
            echo  '</div>' ;
        }
    
    }
    
    /**
     * Render Card Badges
     *
     * @param $settings
     */
    protected function render_badges( $settings )
    {
        
        if ( !empty($settings['card_badges']) ) {
            echo  '<div class="mek-mb-4">' ;
            foreach ( $settings['card_badges'] as $index => $item ) {
                $item['additional_classes'] = 'mek-mr-2';
                $this->render_badge( $item, $index );
            }
            echo  '</div>' ;
        }
    
    }
    
    /**
     * Render Card Buttons
     *
     * @param $settings
     */
    protected function render_buttons( $settings )
    {
        
        if ( !empty($settings['card_buttons']) ) {
            echo  '<div>' ;
            foreach ( $settings['card_buttons'] as $index => $item ) {
                $classes = $this->get_button_classes( $item );
                $classes[] = 'mek-mb-1 mek-mr-1.5';
                $this->render_link_item( [
                    'key'             => 'button_link_' . $index,
                    'link'            => $item['button_url'],
                    'text'            => $item['button_label'],
                    'default_classes' => $classes,
                ] );
            }
            echo  '</div>' ;
        }
    
    }

}