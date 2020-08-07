<?php


namespace DynamicTags\Lib\DynamicTags;

use ElementorPro\Modules\DynamicTags\Module;

class isFeed extends \Elementor\Core\DynamicTags\Tag {
    public function get_name() {
        return 'rto-collection-is-feed';
    }

    public function get_title() {
        return __( 'Is feed', 'dynamic-tags' );
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

        if ( is_feed() ) {
            echo "true";
        } else {
            echo "false";
        }
    }
}