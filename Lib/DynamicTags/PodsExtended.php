<?php
/**
 * This will add bool for pods
 */

namespace DynamicTags\Lib\DynamicTags;


use ElementorPro\Modules\DynamicTags\Module;
use ElementorPro\Modules\DynamicTags\Pods\Tags\Pods_Text;
use ElementorPro\Modules\DynamicTags\Pods\pods_api;
if (function_exists('pods_api')) {
    class PodsExtended extends Pods_Text {

        public function get_name() {
            return 'dynamic-tags-pods-extended';
        }


        public function get_title() {
            return __( 'Pods', 'elementor-pro' ) . ' ' . __( 'Field', 'elementor-pro' ) . ' Extended';
        }


        protected function get_supported_fields() {
            $fields = parent::get_supported_fields();
            array_push($fields, 'boolean');

            return $fields;
        }

    }
}