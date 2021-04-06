<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class Session extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-session';
    }

    public function get_title() {
        return __( 'Session', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {
        $this->add_control(
            'SessionKey',
            [
                'label' => __( 'Session Key', 'dynamic-tags' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
            ]
        );
    }

    public function render() {
        $settings = $this->get_settings();
        $key = $settings['SessionKey'];
        if ( empty( $key ) || empty( $_SESSION[$key] ) ) {
            return;
        }
        $value = filter_var( $_SESSION[$key] );
        echo wp_kses_post( $value );
    }

    public function get_panel_template_setting_key() {
        return 'SessionKey';
    }
}