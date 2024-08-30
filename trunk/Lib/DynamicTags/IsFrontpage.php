<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use ElementorPro\Modules\DynamicTags\Module;

Class IsFrontpage extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name(): string {
        return 'dynamic-tags-is-frontpage';
    }

    public function get_title(): string {
        return __( 'Is front page', 'dynamic-tags' );
    }


    public function get_group(): array {
        return [ Module::POST_GROUP ];
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls(): void {

    }

    public function render(): void {
        echo is_front_page();
    }


}