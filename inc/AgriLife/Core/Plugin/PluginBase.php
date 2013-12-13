<?php
namespace AgriLife\Core\Plugin;

/**
 * Plugin starter class
 * @package AgriLife-Core
 * @since 1.0.0
 */
abstract class PluginBase {

	/**
	 * The plugin version number
	 * @var string
	 */
	protected $plugin_version;

	/**
	 * The plugin slug. Used for i10n and other things
	 * @var string
	 */
	protected static $plugin_slug;

	/**
	 * The class instance
	 * @var object|null
	 */
	protected static $instance = array();

	/**
	 * The class constructor
	 */
	protected function __construct() {

		// Load the plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

	}

	/**
	 * Class initialization
	 * @return void
	 */
	abstract public function init();

	/**
	 * Gets the class instance or creates one if it doesn't exist
	 * @return object The class instance
	 */
	public static function get_instance() {

		$class = get_called_class();

		if ( ! isset( self::$instance[$class] ) ) {
			self::$instance[$class] = new $class();
			self::$instance[$class]->init();
		}

		return self::$instance[$class];

	}

	/**
	 * Easy method for retrieving the plugin slug
	 * @return string The plugin slug
	 */
	public static function get_plugin_slug() {

		$class = get_called_class();

		$instance = self::$instance[$class];

		return $instance->plugin_slug;

	}

	/**
	 * Loads the plugin text domain
	 * @return void
	 */
	public function load_plugin_textdomain() {

		$domain = self::$plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}

}