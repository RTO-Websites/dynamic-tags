<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use ElementorPro\Modules\DynamicTags\Module;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PostContent extends Tag {
    use ElementBase;
    public function get_name() {
        return 'dynamic-tags-post-content';
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

    protected function register_controls() {
        $this->add_control(
            'withoutFilters',
            [
                'label' => __( 'Without filters', 'dynamic-tags' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
    }

    public function render() {
        $withoutFilters = $this->get_settings( 'withoutFilters' );
        $postContent = get_the_content();

        $content = wp_kses_post( $postContent );
        if ( empty( $withoutFilters ) ) {
            $content = apply_filters( 'the_content', $content );
        }
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            $content = strip_tags( $content, '<br><p><a>' );
        }
        echo $content;
    }
}
