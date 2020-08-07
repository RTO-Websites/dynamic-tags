<?php

namespace DynamicTags\Lib\DynamicTags;

use ElementorPro\Modules\DynamicTags\Module;

Class IsFrontpage extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'rto-collection-is-frontpage';
    }

    public function get_title() {
        return __( 'Is front page', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::POST_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {

    }

    public function render() {
        if ( is_front_page() ) {
            echo "true";
        } else {
            echo "false";
        }
    }


}