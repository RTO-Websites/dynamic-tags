<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use ElementorPro\Modules\DynamicTags\Module;

class CurrentLanguage extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-language';
    }

    public function get_title() {
        return __( 'Current-Language (WPML or Polylang)', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {

    }

    public function render() {
        if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
            echo ICL_LANGUAGE_CODE;
            return;
        }

        if ( function_exists( 'pll_current_language' ) ) {
            echo pll_current_language();
            return;
        }

        echo get_locale();
    }

}