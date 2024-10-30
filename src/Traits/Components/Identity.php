<?php

namespace MEK\Traits\Components;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

trait Identity {

	protected function get_site_logo_url( $settings ) {
		$url_type = $settings['site_logo_url_type'];

		if ( $url_type === 'home' ) {
			return home_url( '/' );
		}
		if ( $url_type === 'custom' ) {
			return mek_coalescing( $settings, 'site_logo_custom_url', '' );
		}

		return '';
	}

	protected function get_site_title( $settings ) {
		if ( $settings['site_title'] === 'default' ) {
			return get_bloginfo( 'name' );
		}
		if ( $settings['site_title'] === 'custom' ) {
			return mek_coalescing( $settings, 'custom_site_title', '' );
		}

		return '';
	}

	protected function get_site_tagline( $settings ) {
		if ( $settings['site_tagline'] === 'default' ) {
			return get_bloginfo( 'description' );
		}
		if ( $settings['site_tagline'] === 'custom' ) {
			return mek_coalescing( $settings, 'custom_site_tagline', '' );
		}

		return '';
	}

	protected function render_site_identity( $settings ) {

		// render site logo
		if ( $settings['site_logo'] !== 'none' ) {
			$url  = $this->get_site_logo_url( $settings );
			$logo = esc_html( mek_coalescing( $settings, 'site_text_logo', 'Brand' ) );

			if ( $settings['site_logo'] === 'image' ) {
				$image     = $settings['site_image_logo'];
				$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true );
				$logo      = '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image_alt ) . '"/>';
			}

			if ( $url !== '' ) {
				echo '<a class="mek-site-logo" href="' . esc_url( $url ) . '">' . $logo . '</a>';
			} else {
				echo '<span class="mek-site-logo">' . $logo . '</span>';
			}
		}

		// render title and tagline
		$site_title   = $this->get_site_title( $settings );
		$site_tagline = $this->get_site_tagline( $settings );
		if ( $site_title !== '' || $site_tagline !== '' ) {
			?>
            <div class="mek-px-3">
				<?php if ( $site_title !== '' ): ?>
                    <span class="mek-site-title mek-block mek-font-bold"><?php echo esc_html( $site_title ); ?></span>
				<?php endif; ?>
				<?php if ( $site_tagline !== '' ): ?>
                    <span class="mek-site-tagline mek-block mek-m-0 mek-text-xs"><?php echo esc_html( $site_tagline ); ?></span>
				<?php endif; ?>
            </div>
			<?php
		}
	}

	protected function add_site_identity_controls( $repeater = null, $args = [] ) {
		$manager = $repeater ?: $this;

		if ( ! mek_array_path( $args, 'site_logo.disabled', false ) ) {
			$manager->add_control( 'site_logo', array_merge( [
				'label'   => esc_html__( 'Site Logo', 'moose-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'  => esc_html__( 'None', 'moose-elementor-kit' ),
					'text'  => esc_html__( 'Text', 'moose-elementor-kit' ),
					'image' => esc_html__( 'Image', 'moose-elementor-kit' ),
				],
				'default' => 'text',
			], $args, mek_coalescing( $args, 'site_logo', [] ) ) );

			$manager->add_control( 'site_text_logo', array_merge( [
				'label'     => esc_html__( 'Logo Text', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [ 'site_logo' => 'text' ],
				'default'   => 'Brand',
			], $args, mek_coalescing( $args, 'site_text_logo', [] ) ) );

			$manager->add_control( 'site_image_logo', array_merge( [
				'label'     => esc_html__( 'Logo Image', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [ 'site_logo' => 'image' ],
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
			], $args, mek_coalescing( $args, 'site_image_logo', [] ) ) );

			$manager->add_control( 'site_logo_url_type', array_merge( [
				'label'     => esc_html__( 'Logo URL', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'home',
				'condition' => [ 'site_logo!' => 'none' ],
				'options'   => [
					'none'   => esc_html__( 'None', 'moose-elementor-kit' ),
					'home'   => esc_html__( 'Home', 'moose-elementor-kit' ),
					'custom' => esc_html__( 'Custom', 'moose-elementor-kit' ),
				],
			], $args, mek_coalescing( $args, 'site_logo_url_type', [] ) ) );

			$manager->add_control( 'site_logo_custom_url', array_merge( [
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://www.your-link.com', 'moose-elementor-kit' ),
				'condition'   => [
					'site_logo!'         => 'none',
					'site_logo_url_type' => 'custom',
				],
			], $args, mek_coalescing( $args, 'site_logo_custom_url', [] ) ) );
		}

		if ( ! mek_array_path( $args, 'site_title.disabled', false ) ) {
			$manager->add_control( 'site_title', array_merge( [
				'label'   => esc_html__( 'Site Title', 'moose-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'    => esc_html__( 'None', 'moose-elementor-kit' ),
					'default' => esc_html__( 'Default', 'moose-elementor-kit' ),
					'custom'  => esc_html__( 'Custom', 'moose-elementor-kit' ),
				],
				'default' => 'default',
			], $args, mek_array_path( $args, 'site_title', [] ) ) );

			$manager->add_control( 'custom_site_title', array_merge( [
				'label'     => esc_html__( 'Title Text', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [ 'site_title' => 'custom' ],
			], $args, mek_coalescing( $args, 'custom_site_title', [] ) ) );
		}

		if ( ! mek_array_path( $args, 'site_tagline.disabled', false ) ) {
			$manager->add_control( 'site_tagline', array_merge( [
				'label'   => esc_html__( 'Site Tagline', 'moose-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'    => esc_html__( 'None', 'moose-elementor-kit' ),
					'default' => esc_html__( 'Default', 'moose-elementor-kit' ),
					'custom'  => esc_html__( 'Custom', 'moose-elementor-kit' ),
				],
				'default' => 'default',
			], $args, mek_array_path( $args, 'site_title', [] ) ) );

			$manager->add_control( 'custom_site_tagline', array_merge( [
				'label'     => esc_html__( 'Tagline Text', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [ 'site_tagline' => 'custom' ],
			], $args, mek_coalescing( $args, 'custom_site_tagline', [] ) ) );
		}
	}

	protected function add_custom_site_identity_controls( $repeater = null, $args = [] ) {
		$manager = $repeater ?: $this;

		if ( ! mek_array_path( $args, 'site_logo.disabled', false ) ) {
			$manager->add_group_control( Group_Control_Css_Filter::get_type(), array_merge( [
				'label'     => esc_html__( 'Logo Filter', 'moose-elementor-kit' ),
				'name'      => 'identity_image_logo_filter',
				'selector'  => '{{WRAPPER}} .mek-site-logo img',
				'condition' => [ 'site_logo' => 'image' ],
			], $args, mek_coalescing( $args, 'identity_image_logo_filter', [] ) ) );

			$manager->add_responsive_control( 'identity_image_logo_height', array_merge( [
				'label'     => esc_html__( 'Logo Height', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [ 'site_logo' => 'image' ],
				'selectors' => [
					'{{WRAPPER}} .mek-site-logo img' => 'height: {{VALUE}}px',
				],
			], $args, mek_coalescing( $args, 'identity_image_logo_width', [] ) ) );

			$manager->add_responsive_control( 'identity_image_logo_width', array_merge( [
				'label'     => esc_html__( 'Logo Max Width', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [ 'site_logo' => 'image' ],
				'selectors' => [
					'{{WRAPPER}} .mek-site-logo img' => 'max-width: {{VALUE}}px',
				],
			], $args, mek_coalescing( $args, 'identity_image_logo_width', [] ) ) );

			$manager->add_control( 'identity_text_logo_color', array_merge( [
				'label'     => esc_html__( 'Logo Color', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'site_logo' => 'text' ],
				'selectors' => [
					'{{WRAPPER}} .mek-site-logo' => 'color: {{VALUE}};',
				],
			], $args, mek_coalescing( $args, 'identity_text_logo_color', [] ) ) );

			$manager->add_group_control( Group_Control_Typography::get_type(), array_merge( [
				'label'     => esc_html__( 'Logo Color', 'moose-elementor-kit' ),
				'name'      => 'identity_text_logo_typography',
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .mek-site-logo',
				'condition' => [ 'site_logo' => 'text' ],
			], $args, mek_coalescing( $args, 'identity_text_logo_typography', [] ) ) );
		}

		if ( ! mek_array_path( $args, 'site_title.disabled', false ) ) {
			$manager->add_control( 'identity_site_title_color', array_merge( [
				'label'     => esc_html__( 'Site Title Color', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .mek-site-title' => 'color: {{VALUE}};',
				],
			], $args, mek_coalescing( $args, 'identity_site_title_color', [] ) ) );

			$manager->add_group_control( Group_Control_Typography::get_type(), array_merge( [
				'label'    => esc_html__( 'Site Title Typography', 'moose-elementor-kit' ),
				'name'     => 'identity_site_title_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mek-site-title',
			], $args, mek_coalescing( $args, 'identity_site_title_typography', [] ) ) );
		}

		if ( ! mek_array_path( $args, 'site_tagline.disabled', false ) ) {
			$manager->add_control( 'identity_site_tagline_color', array_merge( [
				'label'     => esc_html__( 'Site Tagline Color', 'moose-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .mek-site-tagline' => 'color: {{VALUE}};',
				],
			], $args, mek_coalescing( $args, 'identity_site_tagline_color', [] ) ) );

			$manager->add_group_control( Group_Control_Typography::get_type(), array_merge( [
				'label'    => esc_html__( 'Site Tagline Typography', 'moose-elementor-kit' ),
				'name'     => 'identity_site_tagline_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mek-site-tagline',
			], $args, mek_coalescing( $args, 'identity_site_tagline_typography', [] ) ) );
		}
	}
}
