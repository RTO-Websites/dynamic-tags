<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ServerVars extends Tag {
    use ElementBase;

    public function get_name(): string {
        return 'dynamic-tags-server-vars';
    }

    public function get_title(): string {
        return __( 'Server Variables', 'dynamic-tags' );
    }

    public function get_group(): string {
        return Module::SITE_GROUP;
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls(): void {
        $options = [];
        foreach ( array_keys( $_SERVER ) as $key ) {
            $key = esc_attr( $key );
            $options[$key] = $key;
        }

        if ( empty( $options['HTTP_REFERER'] ) ) {
            $options['HTTP_REFERER'] = 'HTTP_REFERER';
        }

        $this->add_control(
            'variable',
            [
                'label' => __( 'Variable', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => [],
                'options' => $options,

            ]
        );
    }

    public function get_panel_template_setting_key(): string {
        return 'variable';
    }

    public function render(): void {
        $settings = $this->get_settings();
        $key = $settings['variable'];
        if ( empty( $key ) ) {
            return;
        }
        echo wp_kses_post( $_SERVER[$key] ?? '' );
    }
}
