<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class Cookies extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name(): string {
        return 'dynamic-tags-cookies';
    }

    public function get_title(): string {
        return __( 'Cookies', 'dynamic-tags' );
    }


    public function get_group(): array {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls(): void {
        $this->add_control(
            'CookieName',
            [
                'label' => __( 'Cookie Name', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => [],
                'options' => $this->getCookieNames(),

            ]
        );

        $this->add_control(
            'CustomCookieName',
            [
                'label' => __( 'Custom Cookie Name', 'dynamic-tags' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
            ]
        );
    }

    public function render(): void {
        $settings = $this->get_settings();
        $customKey = $settings['CustomCookieName'];
        if ( !empty( $customKey ) ) {
            $value = filter_input( INPUT_COOKIE, $customKey );
            echo wp_kses_post( $value );
            return;
        }

        $key = $settings['CookieName'];
        $value = filter_input( INPUT_COOKIE, $key );
        echo wp_kses_post( $value );
    }

    public function get_panel_template_setting_key() {
        return 'CookieName';
    }

    private function getCookieNames() {
        $names = [];
        foreach ( $_COOKIE as $key => $val ) {
            $key = esc_attr( $key );
            $names[$key] = $key;
        }
        return $names;
    }
}