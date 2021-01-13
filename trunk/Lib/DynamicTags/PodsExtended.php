<?php
/**
 * This will add boolean for pods
 */

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use ElementorPro\Modules\DynamicTags\Pods\Tags\Pods_Text;
use ElementorPro\Modules\DynamicTags\Pods\pods_api;

if (function_exists('pods_api')) {
    class PodsExtended extends Pods_Text {
        use ElementBase;

        public function get_name() {
            return 'dynamic-tags-pods-extended';
        }


        public function get_title() {
            return __( 'Pods', 'elementor-pro' ) . ' ' . __( 'Field', 'elementor-pro' ) . ' Extended';
        }


        protected function get_supported_fields() {
            $fields = parent::get_supported_fields();
            $fields[] = 'boolean';

            return $fields;
        }

    }
}