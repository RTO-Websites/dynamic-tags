<?php

namespace DynamicTags\Lib\DynamicTags;

use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class CurrentUserCan extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {

        return 'dynamic-tags-current-user-can';
    }

    public function get_title() {
        return __( 'Current user can', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {
        $this->add_control(
            'capability',
            [
                'label' => __( 'Capability' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
            ]
        );
    }

    public function render() {
        $settings = $this->get_settings();
        if ( empty( $settings['capability'] ) ) {
            echo 'false';
        }

        echo current_user_can( $settings['capability'] );
    }

}