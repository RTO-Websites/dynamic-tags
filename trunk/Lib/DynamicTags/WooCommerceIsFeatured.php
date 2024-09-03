<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class WooCommerceIsFeatured extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name(): string {
        return 'dynamic-tags-woocommerce-visibility';
    }

    public function get_title(): string {
        return __( 'WooCommerce is a featured product', 'dynamic-tags' );
    }

    public function get_categories(): array {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls(): void {

    }

    public function get_group(): array {
        if ( !class_exists( 'WooCommerce' ) ) {
            return [];
        }
        return [ Module::POST_GROUP ];
    }

    public function render(): void {
        if ( !function_exists( 'wc_get_product' ) ) {
            return;
        }
        $post = get_post();
        $product = wc_get_product( $post );
        if ( !empty( $product ) ) {
            echo $product->is_featured();
        }
    }
}