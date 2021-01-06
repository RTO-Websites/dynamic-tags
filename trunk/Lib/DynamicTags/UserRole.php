<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class UserRole extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-user-role';
    }

    public function get_title() {
        return __( 'User role', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {

        $options = [
            'currentuser' => 'Current User',
            'currentauthor' => 'Current Author',
        ];

        $users = get_users( [ 'fields' => [ 'id', 'user_login' ] ] );
        foreach ( $users as $user ) {
            $options[$user->id] = $user->user_login;
        }

        $this->add_control(
            'key',
            [
                'label' => __( 'Key', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'currentuser',
                'options' => $options,
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => __( 'Seperator', 'elementor-pro' ),
                'type' => Controls_Manager::TEXT,
                'default' => ', ',
            ]
        );
    }

    public function render() {
        $userId = $this->get_settings( 'key' );

        switch ( $userId ) {
            case 'currentuser':
                $userId = get_current_user_id();
                break;

            case 'currentauthor':
                $userId = get_the_author_meta('id');
                break;
        }

        if ( empty( $userId ) ) {
            return;
        }
        $separator = $this->get_settings( 'separator' ) ?? '';
        $userInfo = get_userdata( $userId );
        $userRoles = implode( $separator, $userInfo->roles );
        echo $userRoles;
    }

}