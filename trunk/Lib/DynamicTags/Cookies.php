<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class Cookies extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-cookies';
    }

    public function get_title() {
        return __( 'Cookies', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {
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
    }

    public function render() {
        $settings = $this->get_settings();
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