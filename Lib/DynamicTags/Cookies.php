<?php

namespace DynamicTags\Lib\DynamicTags;

use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

Class Cookies extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'rto-collection-cookies';
    }

    public function get_title() {
        return __( 'Cookies', 'rto-collection' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {
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
        $keys = $this->getCookieNames();
        foreach ( $_COOKIE as $key => $val ) {
            if ( $key === $keys[$settings['CookieName']] ) {
                echo $val;
            }
        }
    }

    public function get_panel_template_setting_key() {
        return 'CookieName';
    }

    private function getCookieNames() {
        $keys = [];
        foreach ( $_COOKIE as $key => $val ) {
            array_push( $keys, $key );
        }
        return $keys;
    }
}