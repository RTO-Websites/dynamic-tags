<?php

namespace DynamicTags\Lib\DynamicTags;

use DynamicTags\Lib\ElementBase;
use Elementor\Controls_Manager;
use ElementorPro\Modules\DynamicTags\Module;

class WooCommerceIsFeatured extends \Elementor\Core\DynamicTags\Tag {
    use ElementBase;

    public function get_name() {
        return 'dynamic-tags-woocommerce-visibility';
    }

    public function get_title() {
        return __( 'WooCommerce is featured', 'dynamic-tags' );
    }

    public function get_group() {
        return [ Module::POST_GROUP ];
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {

    }

    public function render() {
        if ( !function_exists( 'wp_get_product' ) ) {
            return;
        }
        $product = wc_get_product();
        echo $product->is_featured();
    }
}