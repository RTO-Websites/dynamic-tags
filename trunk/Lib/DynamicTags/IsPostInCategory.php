<?php


namespace DynamicTags\Lib\DynamicTags;

use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class IsPostInCategory extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'dynamic-tags-is-post-in-category';
    }

    public function get_title() {
        return __( 'Is post in category', 'dynamic-tags' );
    }

    public function get_group() {
        return [ Module::POST_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {


        $this->add_control(
            'categories',
            [
                'label' => __( 'Categories' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => [],
                'options' => $this->getCategories(),
                'multiple' => true,
            ]
        );
    }

    public function get_panel_template_setting_key() {
        return 'categories';
    }

    public function render() {

        $settings = $this->get_settings();
        $categories = $this->getCategories();
        $query = [];
        for ( $i = 0; $i < count( $settings['categories'] ); $i++ ) {
            array_push( $query, $categories[$settings['categories'][$i]] );
        }

        echo in_category( $query );
    }

    private function getCategories() {
        $categoryNames = [];
        $categories = get_categories(
            [
                "hide_empty" => false,
                "type" => get_post_types(),
                'orderby' => 'name',
                'order' => 'ASC',
            ]
        );
        foreach ( $categories as $category ) {
            array_push( $categoryNames, '' . $category->name . '' );
        }

        return $categoryNames;
    }

}