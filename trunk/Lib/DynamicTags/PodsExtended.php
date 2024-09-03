<?php
/**
 * This will add boolean for pods
 */

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use ElementorPro\Modules\DynamicTags\Pods\Tags\Pods_Text;

if ( function_exists( 'pods_api' ) ) {
    class PodsExtended extends Pods_Text {
        use ElementBase;

        public function get_name(): string {
            return 'dynamic-tags-pods-extended';
        }

        public function get_title(): string {
            return parent::get_title() . ' Extended';
        }

        protected function get_supported_fields(): array {
            $fields = parent::get_supported_fields();
            $fields[] = 'boolean';

            return $fields;
        }
    }
}