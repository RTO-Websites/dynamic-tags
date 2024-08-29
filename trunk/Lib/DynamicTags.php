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

        if (is_admin()) {
            $this->defineAdminHooks();
        }

    }

    private function loadDependencies(): void {

        $this->loader = new Loader();

    }

    private function setLocale(): void {

        $pluginI18n = new I18n();
        $pluginI18n->setDomain( $this->getDynamicTags() );

        $this->loader->addAction( 'plugins_loaded', $pluginI18n, 'loadPluginTextdomain' );

    }

    public function defineElementorHooks(): void {
        $this->getLoader()->addAction( 'elementor/dynamic_tags/register', $this, 'registerDynamicTags', 10, 1 );
    }

    public function defineAdminHooks(): void {
        // Register ajax
        $this->loader->addAction( 'wp_ajax_dynamic_tags_get_elementor_data', $this, 'ajaxGetElementorData' );
        $this->loader->addAction( 'admin_enqueue_scripts', $this, 'enqueueScripts' );
        $this->loader->addAction( 'elementor/editor/before_enqueue_scripts', $this, 'enqueueScripts', 99999 );
    }

    public function ajaxGetElementorData() :void {
        $postid = filter_input(INPUT_GET, 'postid');
        $output = self::getElementorWidgets($postid);

        echo json_encode($output);
        die();

    }

    public static function getElementorWidgets($postid): array {
        global $wpdb;
        $queryString = "
            SELECT
                $wpdb->postmeta.meta_value
                FROM $wpdb->postmeta
                WHERE post_id = $postid 
                  AND meta_key = '_elementor_data'";

        $allPosts = $wpdb->get_results( $queryString, OBJECT );
        $flatData = [];
        self::makeElementorDataFlat( $flatData, json_decode($allPosts[0]->meta_value, true) );

        $output = [];
        foreach ($flatData as $widgetId => $widget) {
            $output[$widgetId] = $widget['widgetType'] . ' ('.$widgetId.')';
        }

        return $output;
    }

    public function registerDynamicTags( Manager $dynamicTags ): void {
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
    public static function makeElementorDataFlat( array &$flatData, array $data ): array {
        foreach ( $data as $element ) {
            if ( $element['elType'] === 'widget' ) {
                $flatData[$element['id']] = $element;
            }

            if ( !empty( $element['elements'] ) ) {
                self::makeElementorDataFlat( $flatData, $element['elements'] );
            }
        }

        return $flatData;
    }

    public function getDynamicTags(): string {
        return $this->pluginName;
    }

    public function getLoader(): Loader {
        return $this->loader;
    }

    public function enqueueScripts() {
        wp_enqueue_script( $this->pluginName, DynamicTags_URL . '/Admin/js/main.js', [ 'jquery' ], $this->version, false );
    }


    public function getVersion(): string {
        return $this->version;
    }

    public static function run(): void {
        $plugin = new self();
        $plugin->loader->run();
    }

}
