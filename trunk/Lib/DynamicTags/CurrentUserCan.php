<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class CurrentUserCan extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

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

    protected function register_controls() {
        $this->add_control(
            'capability',
            [
                'label' => __( 'Capability' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => '',
                'options' => $this->getAllCapatibilities(),
            ]
        );
    }

    public function render() {
        $settings = $this->get_settings();

        if ( empty( $settings['capability'] ) ) {
            echo false;
        }

        echo current_user_can( $settings['capability'] );
    }

    public function getAllCapatibilities() {
        global $wp_roles;
        $roles = $wp_roles->roles;
        $list = [];

        foreach ( $roles as $group ) {
            foreach ( $group['capabilities'] as $capability => $null ) {
                if ( in_array( $capability, $list ) ) {
                    continue;
                }
                $list[$capability] = $capability;
            }
        }

        return $list;
    }

}