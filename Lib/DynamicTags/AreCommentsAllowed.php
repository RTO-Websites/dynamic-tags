<?php

namespace DynamicTags\Lib\DynamicTags;

use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

Class AreCommentsAllowed extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'rto-collection-are-comments-allowed';
    }

    public function get_title() {
        return __( 'Are comments allowed', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::COMMENTS_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {

    }

    public function render() {
        if ( comments_open() ) {
            echo "true";
        } else {
            echo "false";
        }
    }


}