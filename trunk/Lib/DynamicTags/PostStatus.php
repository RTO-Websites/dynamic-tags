<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Core\DynamicTags\Tag;
use ElementorPro\Modules\DynamicTags\Module;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PostStatus extends Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-post-status';
    }

    public function get_title() {
        return __( 'Post-Status', 'elementor-pro' );
    }

    public function get_group() {
        return Module::POST_GROUP;
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    public function render() {
        $post = get_post();

        if ( !$post ) {
            return;
        }

        echo get_post_status($post->ID);
    }
}
