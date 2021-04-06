<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class UserAuthorImageUrl extends \Elementor\Core\DynamicTags\Data_Tag {
    use ElementBase;

    public function get_name() {

        return 'dynamic-tags-user-author-image-url';
    }

    public function get_title() {
        return __( 'User/Author Image Url', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY, Module::URL_CATEGORY ];
    }

    protected function register_controls() {
        $this->add_control(
            'authorOrUser',
            [
                'label' => __( 'Author or User', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'user',
                'options' => [
                    'user' => 'User',
                    'author' => 'Author',
                ],
            ]
        );

    }

    public function get_value( array $options = [] ) {
        $settings = $this->get_settings();

        if ( $settings['authorOrUser'] === 'user' ) {
            $userId = get_current_user_id();
        } else {
            $userId = get_post()->post_author;
        }

        if ( empty( $userId ) ) {
            return '';
        }


        $imageData = get_avatar_data( $userId, [
            'default' => '404',
        ] );

        if ( empty( $imageData ) || empty( $imageData['url'] ) ) {
            return '';
        }

        $response = wp_remote_head( $imageData['url'] );

        if ( is_wp_error( $response ) || $response['response']['code'] === 404 ) {
            return '';
        }

        return wp_kses_post( $imageData['url'] );
    }

}