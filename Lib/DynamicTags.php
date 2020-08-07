<?php namespace DynamicTags\Lib;

use DynamicTags\Admin\DynamicTagsAdmin;
use DynamicTags\Pub\DynamicTagsPublic;

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
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $pluginName    The string used to uniquely identify this plugin.
	 */
	protected $pluginName;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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
		$this->defineAdminHooks();
		$this->definePublicHooks();

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

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function defineAdminHooks() {

		$pluginAdmin = new DynamicTagsAdmin( $this->getDynamicTags(), $this->getVersion() );

		$this->loader->addAction( 'admin_enqueue_scripts', $pluginAdmin, 'enqueueStyles' );
		$this->loader->addAction( 'admin_enqueue_scripts', $pluginAdmin, 'enqueueScripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function definePublicHooks() {

		$pluginPublic = new DynamicTagsPublic( $this->getDynamicTags(), $this->getVersion() );

		$this->loader->addAction( 'wp_enqueue_scripts', $pluginPublic, 'enqueueStyles' );
		$this->loader->addAction( 'wp_enqueue_scripts', $pluginPublic, 'enqueueScripts' );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function getDynamicTags() {
		return $this->pluginName;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 *@since     1.0.0
	 */
	public function getLoader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
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
