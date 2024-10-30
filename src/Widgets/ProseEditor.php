<?php

namespace MEK\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;

class ProseEditor extends Widget_Base {
	public function get_name() {
		return 'mek_prose_editor';
	}

	public function get_title() {
		return esc_html__( 'MEK: Prose Editor', 'moose-elementor-kit' );
	}

	public function get_icon() {
		return 'mek-widget-icon eicon-text';
	}

	public function get_categories() {
		return [ 'moose-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'text', 'prose', 'editor', 'mek', 'moose' ];
	}


	protected function register_controls() {
		/* Content Tab Start */
		$this->content_text_editor();
		/* Style Tab Start */
		$this->style_text_editor();
	}

	protected function content_text_editor() {
		$this->start_controls_section( 'section_editor', [
			'label' => esc_html__( 'Text Editor', 'moose-elementor-kit' ),
		] );

		$this->add_control( 'editor', [
			'label'   => '',
			'type'    => Controls_Manager::WYSIWYG,
			'default' => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'moose-elementor-kit' ) . '</p>',
		] );

		$text_columns     = range( 1, 10 );
		$text_columns     = array_combine( $text_columns, $text_columns );
		$text_columns[''] = esc_html__( 'Default', 'moose-elementor-kit' );

		$this->add_responsive_control( 'text_columns', [
			'label'     => esc_html__( 'Columns', 'moose-elementor-kit' ),
			'type'      => Controls_Manager::SELECT,
			'separator' => 'before',
			'options'   => $text_columns,
			'selectors' => [
				'{{WRAPPER}}' => 'columns: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'column_gap', [
			'label'      => esc_html__( 'Columns Gap', 'moose-elementor-kit' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'em', 'vw' ],
			'range'      => [
				'px' => [
					'max' => 100,
				],
				'%'  => [
					'max'  => 10,
					'step' => 0.1,
				],
				'vw' => [
					'max'  => 10,
					'step' => 0.1,
				],
				'em' => [
					'max'  => 10,
					'step' => 0.1,
				],
			],
			'selectors'  => [
				'{{WRAPPER}}' => 'column-gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function style_text_editor() {

		$this->start_controls_section( 'section_style', [
			'label' => esc_html__( 'Text Editor', 'moose-elementor-kit' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'align', [
			'label'     => esc_html__( 'Alignment', 'moose-elementor-kit' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'    => [
					'title' => esc_html__( 'Left', 'moose-elementor-kit' ),
					'icon'  => 'eicon-text-align-left',
				],
				'center'  => [
					'title' => esc_html__( 'Center', 'moose-elementor-kit' ),
					'icon'  => 'eicon-text-align-center',
				],
				'right'   => [
					'title' => esc_html__( 'Right', 'moose-elementor-kit' ),
					'icon'  => 'eicon-text-align-right',
				],
				'justify' => [
					'title' => esc_html__( 'Justified', 'moose-elementor-kit' ),
					'icon'  => 'eicon-text-align-justify',
				],
			],
			'selectors' => [
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_control( 'text_color', [
			'label'     => esc_html__( 'Text Color', 'moose-elementor-kit' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .mek-prose.mek-prose-moose' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'typography',
			'scheme'   => Typography::TYPOGRAPHY_3,
			'selector' => '{{WRAPPER}} .mek-prose.mek-prose-moose',
		] );

		$this->add_group_control( Group_Control_Text_Shadow::get_type(), [
			'name'     => 'text_shadow',
			'selector' => '{{WRAPPER}} .mek-prose',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$is_dom_optimized             = Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		$is_edit_mode                 = Plugin::$instance->editor->is_edit_mode();
		$should_render_inline_editing = ( ! $is_dom_optimized || $is_edit_mode );

		$editor_content = $this->get_settings_for_display( 'editor' );
		$editor_content = $this->parse_text_editor( $editor_content );

		$this->add_render_attribute( 'editor', 'class', [ 'mek-prose', 'mek-prose-moose', 'mek-max-w-none' ] );

		if ( $should_render_inline_editing ) {
			$this->add_render_attribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );
		}

		$this->add_inline_editing_attributes( 'editor', 'advanced' );
		?>
        <div <?php $this->print_render_attribute_string( 'editor' ); ?>>
			<?php echo wp_kses_post( $editor_content ); ?>
        </div>
		<?php
	}

	/**
	 * Render text editor widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
        <#
        const isDomOptimized = ! ! elementorFrontend.config.experimentalFeatures.e_dom_optimization,
        isEditMode = elementorFrontend.isEditMode(),
        shouldRenderInlineEditing = ( ! isDomOptimized || isEditMode );

        view.addRenderAttribute( 'editor', 'class', [ 'mek-prose', 'mek-prose-moose', 'mek-max-w-none' ] );

        if ( shouldRenderInlineEditing ) {
        view.addRenderAttribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );
        }

        view.addInlineEditingAttributes( 'editor', 'advanced' );

        #>
        <div {{{ view.getRenderAttributeString( 'editor' ) }}}>
        {{{ settings.editor }}}
        </div>
		<?php
	}
}
