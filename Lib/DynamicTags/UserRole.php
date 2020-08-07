<?php

namespace DynamicTags\Lib\DynamicTags;

use ElementorPro\Modules\DynamicTags\Module;

Class UserRole extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {

        return 'rto-collection-user-role';
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

    protected function _register_controls() {

    }

    public function render() {
        $userId = get_current_user_id();
        $userInfo = get_userdata( $userId );
        $userRoles = implode( ', ', $userInfo->roles );
        echo $userRoles;
    }

}