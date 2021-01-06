<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use ElementorPro\Modules\DynamicTags\Module;

class CurrentUrl extends \Elementor\Core\DynamicTags\Data_Tag {
    use ElementBase;

    public function get_name() {

        return 'dynamic-tags-current-url';
    }

    public function get_title() {
        return __( 'Current-URL', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY, Module::URL_CATEGORY ];
    }

    protected function register_controls() {
    }

    public function get_value(array $options = []) {
        return ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

}