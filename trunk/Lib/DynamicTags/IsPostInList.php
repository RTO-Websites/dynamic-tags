<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class IsPostInList extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-is-post-in-list';
    }

    public function get_title() {
        return __( 'Is post in list', 'dynamic-tags' );
    }

    public function get_group() {
        return [ Module::POST_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {


        $this->add_control(
            'ids',
            [
                'label' => __( 'IDs', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => [],
                'options' => $this->getIds(),
                'multiple' => true,
            ]
        );
    }

    public function get_panel_template_setting_key() {
        return 'ids';
    }

    public function render() {
        $settings = $this->get_settings();
        $ids = $this->getIds();
        $query = [];

        for ( $i = 0; $i < count( $settings['ids'] ); $i++ ) {
            $query[] = $ids[$settings['ids'][$i]];
        }

        echo in_array( get_the_ID(), $query );
    }

    private function getIds() {
        return get_posts(
            [
                'fields' => 'ids',
                'posts_per_page' => -1,
            ]
        );
    }
}