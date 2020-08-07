<?php

namespace DynamicTags\Lib\DynamicTags;

use ElementorPro\Modules\DynamicTags\Module;

Class WpmlLanguage extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'rto-collection-wpml-language';
    }

    public function get_title() {
        return __( 'Language (WPML)', 'dynamic-tags' );
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
        if (!defined('ICL_LANGUAGE_CODE')) {
            echo get_locale();
        }

        echo ICL_LANGUAGE_CODE;
    }

}