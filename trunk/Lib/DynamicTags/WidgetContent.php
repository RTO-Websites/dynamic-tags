<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use ElementorPro\Modules\DynamicTags\Module;

class WidgetContent extends \Elementor\Core\DynamicTags\Data_Tag {
    use ElementBase;

    public function get_name() {

        return 'dynamic-tags-widget-content';
    }

    public function get_title() {
        return __( 'Widget Content', 'dynamic-tags' );
    }


    public function get_group() {
        return [ Module::SITE_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {
        $this->add_control(
            'post-id',
            [
                'label' => __( 'Post ID' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
            ]
        );
        $this->add_control(
            'widget-id',
            [
                'label' => __( 'Widget ID' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
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
                return;
            }
        }
        $settings = $this->get_settings();

        if ( empty( $settings['widget-id'] ) ) {
            return;
        }

        $widgetId = $settings['widget-id'];
        $postId = $settings['post-id'] ?: get_post()->ID;

        if ( empty( $postId ) ) {
            return;
        }

        $document = Plugin::$instance->documents->get_doc_for_frontend( $postId );

        if ( empty( $document ) ) {
            return;
        }

        $elementorData = $document->get_elements_data();

        $flatData = [];
        $this->makeFlat( $flatData, $elementorData );

        if ( empty( $flatData[$widgetId] ) ) {
            return;
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

    /**
     * @param array &$flatData
     * @param array $data
     * @return mixed
     */
    private function makeFlat( &$flatData, $data ) {
        foreach ( $data as $element ) {
            if ( $element['elType'] === 'widget' ) {
                $flatData[$element['id']] = $element;
            }

            if ( !empty( $element['elements'] ) ) {
                $this->makeFlat( $flatData, $element['elements'] );
            }
        }

        return $flatData;
    }

}