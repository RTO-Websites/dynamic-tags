<?php


namespace DynamicTags\Lib\DynamicTags;


use DynamicTags\Lib\ElementBase;
use ElementorPro\Modules\DynamicTags\Module;

class IsHome extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

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

    protected function register_controls() {

    }

    public function render() {
        echo is_home();
    }

}