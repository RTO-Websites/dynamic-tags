<?php

namespace DynamicTags\Lib\DynamicTags;

use Elementor\Core\DynamicTags\Tag;
use ElementorPro\Modules\DynamicTags\Module;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PostContent extends Tag {
    public function get_name() {
        return 'rto-collection-post-content';
    }

    public function get_title() {
        return __( 'Post Content', 'elementor-pro' );
    }

    public function get_group() {
        return Module::POST_GROUP;
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    public function render() {
        $post = get_post();

        if ( !$post || empty( $post->post_content ) ) {
            return;
        }

        $content = wp_kses_post( $post->post_content );
        $content = apply_filters( 'the_content', $content );
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            $content = strip_tags( $content, '<br><p><a>' );
        }
        echo $content;
    }
}
