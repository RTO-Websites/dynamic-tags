<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use ElementorPro\Modules\DynamicTags\Module;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PostParent extends Tag {
    use ElementBase;

    public function get_name(): string {
        return 'dynamic-tags-post-parent';
    }

    public function get_title(): string {
        return __( 'Post Parent', 'elementor-pro' );
    }

    public function get_group(): string {
        return Module::POST_GROUP;
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls(): void {
        $this->add_control(
            'output',
            [
                'label' => __( 'Output', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'id',
                'options' => [
                    'id' => 'ID',
                    'post_title' => __('Post-Title', 'dynamic-tags'),
                    'post_name' => __('Post-Name', 'dynamic-tags'),
                ],
            ]
        );
    }

    public function render(): void {
        $post = get_post();

        if ( !$post || empty( $post->post_parent ) ) {
            return;
        }

        switch ($this->get_settings('output')) {
            case 'post_title':
                echo get_the_title($post->post_parent);
                break;
            case 'post_name':
                $parent = get_post($post->post_parent);
                echo !empty($parent) ? $parent->post_name : '';
                break;
            case 'id':
            default:
                echo $post->post_parent;
                break;
        }
    }

    public function get_panel_template_setting_key(): string {
        return 'output';
    }
}
