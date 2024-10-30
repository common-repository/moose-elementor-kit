<?php

namespace MEK\Pro\Traits\Components;

use  Elementor\Controls_Manager ;
use  MEK\Utils\Query ;
trait Posts
{
    /**
     * Post elements
     *
     * @return array
     */
    protected function get_post_element_options()
    {
        return [
            'title'     => esc_html__( 'Title', 'moose-elementor-kit' ),
            'metas'     => esc_html__( 'Metas', 'moose-elementor-kit' ),
            'content'   => esc_html__( 'Content', 'moose-elementor-kit' ),
            'excerpt'   => esc_html__( 'Excerpt', 'moose-elementor-kit' ),
            'read-more' => esc_html__( 'Read More', 'moose-elementor-kit' ),
            'divider'   => esc_html__( 'Divider', 'moose-elementor-kit' ),
        ];
    }

}