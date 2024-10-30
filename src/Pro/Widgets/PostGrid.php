<?php

namespace MEK\Pro\Widgets;

use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Icons_Manager ;
use  Elementor\Repeater ;
use  Elementor\Widget_Base ;
use  MEK\Pro\Traits\Components\Posts ;
use  MEK\Traits\Components\Badge ;
use  MEK\Traits\Components\Button ;
use  MEK\Traits\Components\Card ;
use  MEK\Traits\Render ;
use  MEK\Utils\Query ;
use  MEK\Utils\Upsell ;
class PostGrid extends Widget_Base
{
    use  Posts ;
    use  Card ;
    use  Render ;
    use  Badge ;
    use  Button ;
    public function get_name()
    {
        return 'mek_post_grid';
    }
    
    public function get_title()
    {
        return esc_html__( 'MEK: Post Grid', 'moose-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'mek-widget-icon mek-widget-pro-icon eicon-gallery-grid';
    }
    
    public function get_categories()
    {
        return [ 'moose-elementor-kit' ];
    }
    
    public function get_keywords()
    {
        return [
            'post',
            'grid',
            'mek',
            'moose'
        ];
    }
    
    public function get_script_depends()
    {
        return [ 'infinite-scroll' ];
    }
    
    protected function register_controls()
    {
    }
    
    protected function render()
    {
    }

}