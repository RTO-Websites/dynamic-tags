<?php


namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class IsPostInCategory extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

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

    protected function register_controls() {


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
        foreach ( $settings['categories'] as $id ) {
            $query[] = $categories[$id];
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
            $categoryNames[$category->term_id] = $category->name;
        }

        return $categoryNames;
    }

}