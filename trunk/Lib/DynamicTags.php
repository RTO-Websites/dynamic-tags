<?php namespace DynamicTags\Lib;

use Elementor\Core\DynamicTags\Manager;


class DynamicTags {

    protected Loader $loader;

    protected string $pluginName;

    protected string $version;


    const INCLUDE_DIR = DynamicTags_DIR . '/Lib';
    const TAG_NAMESPACE = 'DynamicTags\\Lib\\';

    public function __construct() {

        $this->pluginName = 'dynamic-tags';
        $this->version = DynamicTags_VERSION;

        $this->loadDependencies();
        $this->setLocale();
        $this->defineElementorHooks();

    }

    private function loadDependencies(): void {

        $this->loader = new Loader();

    }

    private function setLocale(): void {

        $pluginI18n = new I18n();
        $pluginI18n->setDomain( $this->getDynamicTags() );

        $this->loader->addAction( 'plugins_loaded', $pluginI18n, 'loadPluginTextdomain' );

    }

    public function defineElementorHooks() {
        $this->getLoader()->addAction( 'elementor/dynamic_tags/register', $this, 'registerDynamicTags', 10, 1 );
    }

    public function registerDynamicTags( Manager $dynamicTags ) {
        $dir = self::INCLUDE_DIR . '/DynamicTags';
        foreach ( scandir( $dir ) as $tag ) {
            $className = explode( '.php', $tag )[0];
            $fullClassName = self::TAG_NAMESPACE . 'DynamicTags\\' . $className;
            if ( !file_exists( $dir . '/' . $tag ) || is_dir( $dir . '/' . $tag ) ) {
                continue;
            }

            #include_once( $dir . '/' . $tag );

            if ( class_exists( $fullClassName ) ) {
                $className = $fullClassName;
            } else if ( !class_exists( $className ) ) {
                continue;
            }

            $dynamicTags->register( new $className() );
        }
    }

    public function getDynamicTags(): string {
        return $this->pluginName;
    }

    public function getLoader(): Loader {
        return $this->loader;
    }

    public function getVersion(): string {
        return $this->version;
    }

    public static function run(): void {
        $plugin = new self();
        $plugin->loader->run();
    }

}
