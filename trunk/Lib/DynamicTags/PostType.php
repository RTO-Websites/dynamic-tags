<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Core\DynamicTags\Tag;
use ElementorPro\Modules\DynamicTags\Module;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PostType extends Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-post-type';
    }

    public function get_title() {
        return __( 'Post-Type', 'elementor-pro' );
    }

    public function get_group() {
        return Module::POST_GROUP;
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    public function render() {
        $post = get_post();

        if ( !$post || empty( $post->post_type ) ) {
            return;
        }

        echo $post->post_type;
    }
}
