<?php


namespace DynamicTags\Lib\DynamicTags;


use ElementorPro\Modules\DynamicTags\Module;

class IsHome extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'dynamic-tags-is-home';
    }

    public function get_title() {
        return __( 'Is home', 'dynamic-tags' );
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
        echo is_home();
    }

}