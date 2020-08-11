<?php namespace DynamicTags\Lib;

use DynamicTags\Admin\DynamicTagsAdmin;
use DynamicTags\Pub\DynamicTagsPublic;
use Elementor\Core\DynamicTags\Manager;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.rto.de
 * @since      1.0.0
 *
 * @package    DynamicTags
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    DynamicTags
 * @author     RTO GmbH <kdhp-dev@rto.de>
 */
class DynamicTags {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $pluginName The string used to uniquely identify this plugin.
     */
    protected $pluginName;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;


    const INCLUDE_DIR = DynamicTags_DIR . '/Lib';
    const TAG_NAMESPACE = 'DynamicTags\\Lib\\';

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->pluginName = 'dynamic-tags';
        $this->version = DynamicTags_VERSION;

        $this->loadDependencies();
        $this->setLocale();
        $this->defineElementorHooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - DynamicTagsLoader. Orchestrates the hooks of the plugin.
     * - DynamicTagsI18n. Defines internationalization functionality.
     * - DynamicTagsAdmin. Defines all hooks for the admin area.
     * - DynamicTagsPublic. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function loadDependencies() {

        $this->loader = new Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the DynamicTagsI18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setLocale() {

        $pluginI18n = new I18n();
        $pluginI18n->setDomain( $this->getDynamicTags() );

        $this->loader->addAction( 'plugins_loaded', $pluginI18n, 'loadPluginTextdomain' );

    }

    public function defineElementorHooks() {
        $this->getLoader()->addAction( 'elementor/dynamic_tags/register_tags', $this, 'registerDynamicTags', 10, 1 );
    }

    /**
     * Register dynamic tags
     *
     * @param Manager $dynamicTags
     */
    public function registerDynamicTags( $dynamicTags ) {
        $dir = self::INCLUDE_DIR . '/DynamicTags';
        foreach ( scandir( $dir ) as $tag ) {
            $className = explode( '.php', $tag )[0];
            $fullClassName = self::TAG_NAMESPACE . 'DynamicTags\\' . $className;
            if ( !file_exists( $dir . '/' . $tag ) || is_dir( $dir . '/' . $tag ) ) {
                continue;
            }

            include_once( $dir . '/' . $tag );

            if ( class_exists( $fullClassName ) ) {
                $className = $fullClassName;
            } else if ( !class_exists( $className ) ) {
                continue;
            }

            $dynamicTags->register_tag( $className );
        }
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function getDynamicTags() {
        return $this->pluginName;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function getLoader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public static function run() {
        $plugin = new self();
        $plugin->loader->run();
    }

}
