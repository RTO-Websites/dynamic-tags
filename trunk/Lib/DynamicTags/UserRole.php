<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class UserRole extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name(): string {
        return 'dynamic-tags-user-role';
    }

    public function get_title(): string {
        return __( 'User role', 'dynamic-tags' );
    }


    public function get_group(): array {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls(): void {

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

        $this->add_control(
            'format',
            [
                'label' => __( 'Format', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'plain',
                'options' => [
                    'plain' => 'Plain',
                    'human_readable' => 'Human readable',
                    'translated' => 'Translated',
                ],
            ]
        );

        $this->add_control(
            'addWrapper',
            [
                'label' => __( 'Add wrapper around items', 'dynamic-tags' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
    }

    public function render(): void {
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


        switch ($this->get_settings('format')) {
            case 'human_readable':
                global $wp_roles;
                $roles = $wp_roles->get_names();
                $rolesArray = [];
                foreach ($userInfo->roles as $role) {
                    $rolesArray[] = $roles[$role];
                }
                break;
            case 'translated':
                global $wp_roles;
                $roles = $wp_roles->get_names();
                $rolesArray = [];
                foreach ($userInfo->roles as $role) {
                    $rolesArray[] = translate_user_role($roles[$role]);
                }

                break;
            case 'plain':
            default:
                $rolesArray = $userInfo->roles;
                break;
        }

        if ($this->get_settings('addWrapper') === 'yes') {
            foreach ($rolesArray as &$role) {
                $role = '<span class="user-role">' . $role . '</span>';
            }
        }
        
        $userRoles = implode( $separator, $rolesArray );

        echo $userRoles;
    }

    public function get_panel_template_setting_key(): string {
        return 'key';
    }
}