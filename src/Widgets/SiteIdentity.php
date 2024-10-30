<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class SiteIdentity extends Widget_Base {

	use \MEK\Traits\Components\Identity;

	public function get_name() {
		return 'mek_site_identity';
	}

	public function get_title() {
		return esc_html__( 'MEK: Site Identity', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-site-identity';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'identity', 'site', 'logo', 'title', 'tagline', 'mek', 'moose' ];
	}

	protected function register_controls() {
		/* Content Tab Start */
		$this->start_controls_section( 'section_identity', [
			'label' => esc_html__( 'Identity', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_site_identity_controls( $this, [
			'site_title'   => [ 'separator' => 'before' ],
			'site_tagline' => [ 'separator' => 'before' ],
		] );

		$this->end_controls_section();

		/* Style Tab Start */
		$this->start_controls_section( 'section_identity_navbar', [
			'label' => esc_html__( 'Identity', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_custom_site_identity_controls();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		?>
        <div class="mek-site-identity mek-flex mek-items-center">
			<?php $this->render_site_identity( $settings ); ?>
        </div>
		<?php
	}
}
