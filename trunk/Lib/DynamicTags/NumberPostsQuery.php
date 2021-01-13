<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class NumberPostsQuery extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;
    public function get_name() {
        return 'dynamic-tags-numberposts-query';
    }

    public function get_title() {
        return __( 'Number posts query', 'dynamic-tags' );
    }

    public function get_group() {
        return [ Module::POST_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY, Module::NUMBER_CATEGORY ];
    }

    protected function register_controls() {

        $this->add_control(
            'category',
            [
                'label' => __( 'Category', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => [],
                'options' => $this->getCategories(),
                'multiple' => true,
            ]
        );
        $this->add_control(
            'posttypes',
            [
                'label' => __( 'Post-Types', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => [],
                'options' => get_post_types(),
                'multiple' => true,
            ]
        );
        $this->add_control(
            'custom-query',
            [
                'label' => __( 'Custom-Query', 'dynamic-tags' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => '',
                'description' => __( 'One per line, example:', 'dynamic-tags' ) . '<br />post_parent=17<br />post_type=page',
            ]
        );
    }

    /**
     * Get a list of all categories
     *
     * @return array
     */
    private function getCategories() {
        $result = [];
        foreach ( get_categories() as $category ) {
            $result[$category->term_id] = $category->name;
        }

        return $result;
    }


    /**
     * Print the number of posts in category/post-type
     */
    public function render() {
        $settings = $this->get_settings();
        $args = [
            'category' => implode( ',', $settings['category'] ),
            'post_type' => empty( $settings['posttypes'] ) ? 'any' : $settings['posttypes'],
            'numberposts' => -1,
            'posts_per_page' => -1,
            'fields' => 'ids',
        ];


        if ( !empty( $settings['custom-query'] ) ) {
            $lines = explode( "\n", $settings['custom-query'] );
            foreach ( $lines as $line ) {
                $line = explode( '=', $line );
                if ( count( $line ) !== 2 ) {
                    continue;
                }

                $args[$line[0]] = $line[1];
            }
        }

        $posts = get_posts( $args );

        echo count( $posts );
    }
}