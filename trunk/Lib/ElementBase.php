<?php namespace DynamicTags\Lib;

trait ElementBase {
    /**
     * Legacy for elementor < 3.1
     */
    protected function _register_controls() {
        if ( method_exists( $this, 'register_controls' ) ) {
            $this->register_controls();
        }
    }
}