<?php

namespace DynamicTags\Lib\DynamicTags;

use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class UserAuthorImageUrl extends \Elementor\Core\DynamicTags\Tag {

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
        return [ Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {
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

    public function render() {
        $settings = $this->get_settings();

        if ( $settings['authorOrUser'] === 'user' ) {
            $userId = get_current_user_id();
        } else {
            $userId = get_post()->post_author;
        }

        if ( empty( $userId ) ) {
            return;
        }


        $imageData = get_avatar_data($userId,[
            'default' => '404',

        ]);

        if (empty($imageData) || empty( $imageData['url'])) {
            return;
        }

        $ch = curl_init($imageData['url']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_TIMEOUT,10);
        curl_setopt($ch, CURLOPT_HEADER  , true);  // we want headers
        curl_setopt($ch, CURLOPT_NOBODY  , true);  // we don't need body
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 404) {
            echo $httpcode;
            return;
        }

        echo $imageData['url'];
    }

}