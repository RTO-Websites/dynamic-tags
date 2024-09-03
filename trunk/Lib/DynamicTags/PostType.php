<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use ElementorPro\Modules\DynamicTags\Module;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PostType extends Tag {
    use ElementBase;

    public function get_name(): string {
        return 'dynamic-tags-post-type';
    }

    public function get_title(): string {
        return __( 'Post-Type', 'elementor-pro' );
    }

    public function get_group(): string {
        return Module::POST_GROUP;
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls(): void {
        $this->add_control(
            'format',
            [
                'label' => __( 'Format', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'plain',
                'options' => [
                    'plain' => 'Plain',
                    'singular' => 'Singular',
                    'plural' => 'Plural',
                ],
            ]
        );

    }

    public function render(): void {
        $post = get_post();

        if ( !$post || empty( $post->post_type ) ) {
            return;
        }

        switch ( $this->get_settings('format')) {
            case 'singular':
                echo get_post_type_object($post->post_type)->labels->singular_name;
                break;
            case 'plural':
                echo get_post_type_object($post->post_type)->labels->name;
                break;
            case'plain':
            default:
                echo $post->post_type;
                break;
        }
    }

    public function get_panel_template_setting_key(): string {
        return 'format';
    }
}
