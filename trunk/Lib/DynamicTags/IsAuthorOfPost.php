<?php

namespace DynamicTags\Lib\DynamicTags;

use ElementorPro\Modules\DynamicTags\Module;

Class IsAuthorOfPost extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'dynamic-tags-is-author-of-post';
    }

    public function get_title() {
        return __( 'Is current user author of post', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::POST_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {

    }

    public function render() {
        $userId = get_current_user_id();
        $authorId = get_the_author_meta( 'ID' );

        echo $userId === $authorId;
    }

}