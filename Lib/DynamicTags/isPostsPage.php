<?php


namespace DynamicTags\Lib\DynamicTags;


use ElementorPro\Modules\DynamicTags\Module;

class isPostsPage extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'rto-collection-is-posts-page';
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
        if ( is_home() ) {
            echo "true";
        } else {
            echo "false";
        }
    }

}