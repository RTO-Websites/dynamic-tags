<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\DynamicTags;
use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use ElementorPro\Modules\DynamicTags\Module;

class WidgetContent extends \Elementor\Core\DynamicTags\Data_Tag {
    use ElementBase;

    public function get_name(): string {

        return 'dynamic-tags-widget-content';
    }

    public function get_title(): string {
        return __( 'Widget Content', 'dynamic-tags' );
    }


    public function get_group(): array {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {
        global $wpdb;
        $queryString = "
                SELECT 
                    $wpdb->posts.ID,
                    $wpdb->posts.post_title,
                    $wpdb->posts.post_name
                FROM $wpdb->posts
                LEFT JOIN $wpdb->postmeta on $wpdb->posts.ID = $wpdb->postmeta.post_id 
                                       AND meta_key = '_elementor_data'
                WHERE $wpdb->postmeta.meta_value NOT IN('', '[]') 
                  AND NOT ISNULL($wpdb->postmeta.meta_value)
                    AND $wpdb->posts.post_status NOT IN ('auto-draft', 'trash')
                    AND $wpdb->posts.post_type NOT IN('revision')
                GROUP BY $wpdb->posts.ID
                ORDER BY $wpdb->posts.post_name ASC
             ";

        $allPosts = $wpdb->get_results( $queryString, OBJECT );

        $postList = [];
        foreach ( $allPosts as $post ) {
            $postList[$post->ID] = ( $post->post_title ?? $post->post_name ) . " ($post->ID)";
        }

        $this->add_control(
            'dynamic-tags-post-id-select',
            [
                'label' => __( 'Post' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => $postList,
                'default' => '',
                'render_type' => 'ui',
            ]
        );
        $this->add_control( 'post-id',
            [
                'label' => __( 'Post ID', 'dynamic-tags' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => '',
            ]
        );
        $this->add_control(
            'dynamic-tags-widget-id-select',
            [
                'label' => __( 'Widget', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [],
                'default' => '',
                'render_type' => 'ui',
            ]
        );
        $this->add_control(
            'widget-id',
            [
                'label' => __( 'Widget ID', 'dynamic-tags' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => '',
            ]
        );
    }

    public function get_value( array $options = [] ) {
        ob_start();
        if ( filter_input( INPUT_POST, 'action' ) === 'elementor_ajax' ) {
            $actions = filter_input( INPUT_POST, 'actions' );
            $actions = json_decode( $actions );

            if ( !empty( $actions->save_builder ) ) {
                return '';
            }
        }
        $settings = $this->get_settings();

        if ( empty( $settings['widget-id'] ) ) {
            ob_clean();
            return '';
        }

        $widgetId = $settings['widget-id'];
        $postId = $settings['post-id'] ?: get_post()->ID;

        if ( empty( $postId ) ) {
            ob_clean();
            return '';
        }

        $document = Plugin::$instance->documents->get_doc_for_frontend( $postId );

        if ( empty( $document ) ) {
            ob_clean();
            return '';
        }

        $elementorData = $document->get_elements_data();

        $flatData = [];
        DynamicTags::makeElementorDataFlat( $flatData, $elementorData );

        if ( empty( $flatData[$widgetId] ) ) {
            ob_clean();
            return '';
        }

        $flatData[$widgetId]['id'] = $widgetId;
        /**
         * @var $tempWidget Widget_Base
         */
        $tempWidget = Plugin::instance()->elements_manager->create_element_instance(
            $flatData[$widgetId],
            []
        );
        $tempWidget->print_element();

        return ob_get_clean();
    }

}