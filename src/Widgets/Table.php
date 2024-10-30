<?php

namespace MEK\Widgets;

use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Background ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Icons_Manager ;
use  Elementor\Plugin ;
use  Elementor\Repeater ;
use  Elementor\Utils ;
use  Elementor\Widget_Base ;
use  MEK\Traits\Render ;
use  MEK\Utils\Query ;
use  MEK\Utils\Upsell ;
class Table extends Widget_Base
{
    use  Render ;
    public function get_name()
    {
        return 'mek_data_table';
    }
    
    public function get_title()
    {
        return esc_html__( 'MEK: Data Table', 'moose-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'mek-widget-icon eicon-table';
    }
    
    public function get_categories()
    {
        return [ 'moose-elementor-kit' ];
    }
    
    public function get_keywords()
    {
        return [
            'table',
            'data',
            'mek',
            'moose'
        ];
    }
    
    protected function register_controls()
    {
        /* Content Tab Start */
        $this->content_table_controls();
        $this->content_table_header_controls();
        $this->content_table_rows_controls();
        /* Style Tab Start */
        $this->style_table_controls();
        $this->style_table_header_controls();
        $this->style_table_body_controls();
    }
    
    protected function content_table_controls()
    {
        $this->start_controls_section( 'section_table', [
            'label' => esc_html__( 'Table', 'moose-elementor-kit' ),
        ] );
        $this->add_control( 'data_table_striped', [
            'label'   => esc_html__( 'Striped', 'moose-elementor-kit' ),
            'default' => 'yes',
            'type'    => Controls_Manager::SWITCHER,
        ] );
        $this->add_control( 'data_table_hr_divide', [
            'label'   => esc_html__( 'Horizontal Divide', 'moose-elementor-kit' ),
            'default' => 'yes',
            'type'    => Controls_Manager::SWITCHER,
        ] );
        $this->add_control( 'data_table_vt_divide', [
            'label'   => esc_html__( 'Vertical Divide', 'moose-elementor-kit' ),
            'default' => 'yes',
            'type'    => Controls_Manager::SWITCHER,
        ] );
        $this->end_controls_section();
    }
    
    protected function content_table_header_controls()
    {
        $this->start_controls_section( 'section_table_header', [
            'label' => esc_html__( 'Header', 'moose-elementor-kit' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'data_table_header_col', [
            'label'       => esc_html__( 'Column Name', 'moose-elementor-kit' ),
            'default'     => esc_html__( 'Column', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => false,
        ] );
        $repeater->add_control( 'data_table_header_col_span', [
            'label'       => esc_html__( 'Column Span', 'moose-elementor-kit' ),
            'default'     => '',
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'label_block' => false,
        ] );
        $repeater->add_control( 'data_table_header_col_icon_enabled', [
            'label'        => esc_html__( 'Enable Header Icon', 'moose-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'yes', 'moose-elementor-kit' ),
            'label_off'    => __( 'no', 'moose-elementor-kit' ),
            'default'      => 'false',
            'return_value' => 'true',
        ] );
        $repeater->add_control( 'data_table_header_icon_type', [
            'label'     => esc_html__( 'Header Icon Type', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'none'  => [
            'title' => esc_html__( 'None', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-ban',
        ],
            'icon'  => [
            'title' => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-star',
        ],
            'image' => [
            'title' => esc_html__( 'Image', 'moose-elementor-kit' ),
            'icon'  => 'eicon-image-bold',
        ],
        ],
            'default'   => 'icon',
            'condition' => [
            'data_table_header_col_icon_enabled' => 'true',
        ],
        ] );
        $repeater->add_control( 'data_table_header_col_icon', [
            'label'     => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
            'value'   => 'fas fa-star',
            'library' => 'solid',
        ],
            'condition' => [
            'data_table_header_col_icon_enabled' => 'true',
            'data_table_header_icon_type'        => 'icon',
        ],
        ] );
        $repeater->add_control( 'data_table_header_col_img', [
            'label'     => esc_html__( 'Image', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::MEDIA,
            'default'   => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'condition' => [
            'data_table_header_icon_type' => 'image',
        ],
        ] );
        $repeater->add_control( 'data_table_header_col_img_size', [
            'label'       => esc_html__( 'Image Size ( px )', 'moose-elementor-kit' ),
            'default'     => '25',
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'selectors'   => [
            '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{VALUE}}px;',
        ],
            'condition'   => [
            'data_table_header_icon_type' => 'image',
        ],
        ] );
        $repeater->add_control( 'data_table_header_css_class', [
            'label'       => esc_html__( 'CSS Class', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'label_block' => false,
        ] );
        $repeater->add_control( 'data_table_header_css_id', [
            'label'       => esc_html__( 'CSS ID', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'label_block' => false,
        ] );
        $this->add_control( 'data_table_header_cols_data', [
            'type'          => Controls_Manager::REPEATER,
            'prevent_empty' => false,
            'separator'     => 'before',
            'default'       => [
            [
            'data_table_header_col' => 'Column #1',
        ],
            [
            'data_table_header_col' => 'Column #2',
        ],
            [
            'data_table_header_col' => 'Column #3',
        ],
            [
            'data_table_header_col' => 'Column #4',
        ]
        ],
            'fields'        => $repeater->get_controls(),
            'title_field'   => '{{data_table_header_col}}',
        ] );
        $this->end_controls_section();
    }
    
    protected function content_table_rows_controls()
    {
        $this->start_controls_section( 'section_data_table_rows', [
            'label' => esc_html__( 'Rows', 'moose-elementor-kit' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'data_table_content_row_type', [
            'label'       => esc_html__( 'Row Type', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => 'row',
            'label_block' => false,
            'options'     => [
            'row' => esc_html__( 'Row', 'moose-elementor-kit' ),
            'col' => esc_html__( 'Column', 'moose-elementor-kit' ),
        ],
        ] );
        $repeater->add_control( 'data_table_content_row_colspan', [
            'label'     => esc_html__( 'Col Span', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 1,
            'min'       => 1,
            'condition' => [
            'data_table_content_row_type' => 'col',
        ],
        ] );
        $repeater->add_control( 'data_table_content_row_rowspan', [
            'label'     => esc_html__( 'Row Span', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 1,
            'min'       => 1,
            'condition' => [
            'data_table_content_row_type' => 'col',
        ],
        ] );
        $repeater->add_control( 'data_table_content_type', [
            'label'     => esc_html__( 'Content Type', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'icon'     => [
            'title' => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'icon'  => 'fa fa-info',
        ],
            'textarea' => [
            'title' => esc_html__( 'Textarea', 'moose-elementor-kit' ),
            'icon'  => 'fas fa-paragraph',
        ],
            'editor'   => [
            'title' => esc_html__( 'Editor', 'moose-elementor-kit' ),
            'icon'  => 'fas fa-edit',
        ],
            'template' => [
            'title' => esc_html__( 'Templates', 'moose-elementor-kit' ),
            'icon'  => 'fas fa-folder',
        ],
        ],
            'default'   => 'textarea',
            'condition' => [
            'data_table_content_row_type' => 'col',
        ],
        ] );
        $repeater->add_control( 'primary_templates_for_tables', [
            'label'     => __( 'Choose Template', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => Query::elementor_templates(),
            'condition' => [
            'data_table_content_type' => 'template',
        ],
        ] );
        $repeater->add_control( 'data_table_icon_content', [
            'label'     => esc_html__( 'Icon', 'moose-elementor-kit' ),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
            'value'   => 'fas fa-home',
            'library' => 'fa-solid',
        ],
            'condition' => [
            'data_table_content_row_type' => 'col',
            'data_table_content_type'     => [ 'icon' ],
        ],
        ] );
        $repeater->add_control( 'data_table_content_row_title', [
            'label'       => esc_html__( 'Cell Text', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXTAREA,
            'dynamic'     => [
            'active' => true,
        ],
            'label_block' => true,
            'default'     => esc_html__( 'Content', 'moose-elementor-kit' ),
            'condition'   => [
            'data_table_content_row_type' => 'col',
            'data_table_content_type'     => 'textarea',
        ],
        ] );
        $repeater->add_control( 'data_table_content_row_content', [
            'label'       => esc_html__( 'Cell Text', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::WYSIWYG,
            'label_block' => true,
            'default'     => esc_html__( 'Content', 'moose-elementor-kit' ),
            'condition'   => [
            'data_table_content_row_type' => 'col',
            'data_table_content_type'     => 'editor',
        ],
        ] );
        $repeater->add_control( 'data_table_content_row_title_link', [
            'label'         => esc_html__( 'Link', 'moose-elementor-kit' ),
            'type'          => Controls_Manager::URL,
            'dynamic'       => [
            'active' => true,
        ],
            'label_block'   => true,
            'default'       => [
            'url'         => '',
            'is_external' => '',
        ],
            'show_external' => true,
            'separator'     => 'before',
            'condition'     => [
            'data_table_content_row_type' => 'col',
            'data_table_content_type'     => 'textarea',
        ],
        ] );
        $repeater->add_control( 'data_table_content_row_css_class', [
            'label'       => esc_html__( 'CSS Class', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'label_block' => false,
            'condition'   => [
            'data_table_content_row_type' => 'col',
        ],
        ] );
        $repeater->add_control( 'data_table_content_row_css_id', [
            'label'       => esc_html__( 'CSS ID', 'moose-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'label_block' => false,
            'condition'   => [
            'data_table_content_row_type' => 'col',
        ],
        ] );
        $this->add_control( 'data_table_content_rows', [
            'type'        => Controls_Manager::REPEATER,
            'separator'   => 'before',
            'default'     => [
            [
            'data_table_content_row_type' => 'row',
        ],
            [
            'data_table_content_row_type' => 'col',
        ],
            [
            'data_table_content_row_type' => 'col',
        ],
            [
            'data_table_content_row_type' => 'col',
        ],
            [
            'data_table_content_row_type' => 'col',
        ]
        ],
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{data_table_content_row_type}}::{{data_table_content_row_title || data_table_content_row_content}}',
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
            'label'     => esc_html__( 'Alignment', 'moose-elementor-kit' ),
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
            '{{WRAPPER}} .mek-table-wrap, {{WRAPPER}} .mek-table-wrap th' => 'text-align: {{VALUE}};',
        ],
        ] );
        Upsell::add_pro_feature_notice( $this, 'table_customize_', 'We provide the ability to fully customize the table style in %1$s' );
        $this->end_controls_section();
    }
    
    protected function style_table_header_controls()
    {
        $this->start_controls_section( 'section_style_table_header', [
            'label' => esc_html__( 'Header', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'table_header_text_align', [
            'label'     => esc_html__( 'Alignment', 'moose-elementor-kit' ),
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
            '{{WRAPPER}} .mek-table-wrap .mek-thead th' => 'text-align: {{VALUE}};',
        ],
        ] );
        Upsell::add_pro_feature_notice( $this, 'table_header_customize_', 'We provide the ability to fully customize the table header style in %1$s' );
        $this->end_controls_section();
    }
    
    protected function style_table_body_controls()
    {
        $this->start_controls_section( 'section_style_table_body', [
            'label' => esc_html__( 'Body', 'moose-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'table_body_text_align', [
            'label'     => esc_html__( 'Alignment', 'moose-elementor-kit' ),
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
            '{{WRAPPER}} .mek-table-wrap .mek-tbody' => 'text-align: {{VALUE}};',
        ],
        ] );
        Upsell::add_pro_feature_notice( $this, 'table_body_customize_', 'We provide the ability to fully customize the table body style in %1$s' );
        $this->end_controls_section();
    }
    
    protected function render_cell( $index, $data )
    {
        $content_type = $data['data_table_content_type'];
        $this->add_render_attribute( 'cell_' . $index, [
            'colspan' => ( $data['data_table_content_row_colspan'] > 1 ? $data['data_table_content_row_colspan'] : '' ),
            'rowspan' => ( $data['data_table_content_row_rowspan'] > 1 ? $data['data_table_content_row_rowspan'] : '' ),
            'class'   => [ 'mek-px-6 mek-py-4 mek-whitespace-nowrap', $data['data_table_content_row_css_class'] ],
            'id'      => $data['data_table_content_row_css_id'],
        ] );
        ?>

        <td <?php 
        $this->print_render_attribute_string( 'cell_' . $index );
        ?>>
            <div class="mek-prose mek-prose-moose mek-text-sm">
				<?php 
        
        if ( $content_type === 'icon' ) {
            ?>
					<?php 
            Icons_Manager::render_icon( $data['data_table_icon_content'] );
            ?>
				<?php 
        } elseif ( $content_type === 'textarea' ) {
            ?>
					<?php 
            $this->render_link_item( [
                'key'  => 'cell_' . $index,
                'text' => mek_wp_kses( $data['data_table_content_row_title'] ),
                'link' => $data['data_table_content_row_title_link'],
            ] );
            ?>
				<?php 
        } elseif ( $content_type === 'editor' ) {
            ?>
					<?php 
            echo  wp_kses_post( $data['data_table_content_row_content'] ) ;
            ?>
				<?php 
        } elseif ( $content_type === 'template' ) {
            ?>
					<?php 
            echo  Plugin::$instance->frontend->get_builder_content( intval( $data['primary_templates_for_tables'] ), true ) ;
            ?>
				<?php 
        }
        
        ?>
            </div>
        </td>
		<?php 
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $table_tr = [];
        $table_td = [];
        $last_row = null;
        // Storing Data table content values
        foreach ( $settings['data_table_content_rows'] as $data ) {
            $row_id = uniqid();
            
            if ( $data['data_table_content_row_type'] == 'row' ) {
                $last_row = $row_id;
                $table_tr[] = [
                    'id'   => $row_id,
                    'data' => $data,
                    'type' => $data['data_table_content_row_type'],
                ];
            }
            
            if ( $data['data_table_content_row_type'] == 'col' ) {
                $table_td[] = [
                    'row_id' => $last_row,
                    'data'   => $data,
                    'type'   => $data['data_table_content_row_type'],
                ];
            }
        }
        $striped = $settings['data_table_striped'] === 'yes';
        $has_hr_divide = $settings['data_table_hr_divide'] === 'yes';
        $has_vt_divide = $settings['data_table_vt_divide'] === 'yes';
        ?>
        <div class="mek-table-wrap mek-bg-base mek-shadow mek-overflow-hidden mek-border-b mek-border-gray-200 mek-rounded-md">
            <table class="mek-table mek-m-0 mek-min-w-full mek-divide-solid mek-divide-y mek-divide-base-200">
				<?php 
        
        if ( !empty($settings['data_table_header_cols_data']) ) {
            ?>
                    <!-- Thead -->
                    <thead class="mek-thead mek-text-left mek-bg-base-100">
                    <tr class="<?php 
            mek_clsx_echo( [
                'mek-divide-solid mek-divide-x mek-divide-base-200' => $has_hr_divide,
            ] );
            ?>">
						<?php 
            foreach ( $settings['data_table_header_cols_data'] as $index => $header ) {
                ?>
							<?php 
                $this->add_render_attribute( 'th_' . $index, [
                    'class'   => [ 'elementor-repeater-item-' . $header['_id'], $header['data_table_header_css_class'], 'mek-px-6 mek-py-3 mek-text-xs mek-font-medium mek-text-gray-500 mek-align-middle mek-tracking-wider' ],
                    'id'      => $header['data_table_header_css_id'],
                    'colspan' => $header['data_table_header_col_span'],
                ] );
                ?>
                            <th <?php 
                $this->print_render_attribute_string( 'th_' . $index );
                ?>>
								<?php 
                
                if ( $header['data_table_header_col_icon_enabled'] == 'true' ) {
                    echo  '<span class="mek-data-table-header-icon mek-align-middle mr-2">' ;
                    // icon in the header
                    if ( $header['data_table_header_icon_type'] == 'icon' ) {
                        Icons_Manager::render_icon( $header['data_table_header_col_icon'] );
                    }
                    // image in the header
                    if ( $header['data_table_header_icon_type'] == 'image' ) {
                        $this->render_image( $header, 'data_table_header_col_img' );
                    }
                    echo  '</span>' ;
                }
                
                ?>
                                <span class="mek-data-table-header-text mek-align-middle">
                                    <?php 
                echo  mek_wp_kses( $header['data_table_header_col'] ) ;
                ?>
                                </span>
                            </th>
						<?php 
            }
            ?>
                    </tr>
                    </thead>
				<?php 
        }
        
        ?>

                <!-- Tbody -->
                <tbody class="<?php 
        mek_clsx_echo( [ 'mek-tbody', 'mek-divide-solid mek-divide-y mek-divide-base-200' => $has_vt_divide ] );
        ?>">
				<?php 
        foreach ( $table_tr as $row_index => $row ) {
            ?>
                    <tr class="<?php 
            mek_clsx_echo( [
                'mek-divide-solid mek-divide-x mek-divide-base-200' => $has_hr_divide,
                'even:mek-bg-base-100/50'                           => $striped,
            ] );
            ?>">
						<?php 
            foreach ( $table_td as $cell_index => $cell ) {
                ?>
							<?php 
                
                if ( $cell['row_id'] === $row['id'] ) {
                    ?>
								<?php 
                    $this->render_cell( $row_index . $cell_index, $cell['data'] );
                    ?>
							<?php 
                }
                
                ?>
						<?php 
            }
            ?>
                    </tr>
				<?php 
        }
        ?>
                </tbody>
            </table>
        </div>
		<?php 
    }

}