<?php
/**
 * Core plugin class
 *
 * @package    Videogram
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
 * @package    Videogram
 */
class Videogram {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Videogram_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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
	 */
	public function __construct() {

		$this->version     = VIDEOGRAM_VERSION;
		$this->plugin_name = 'videogram';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->wpgraphql();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-videogram-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-videogram-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-videogram-admin.php';

		/**
		 * Integration with WPGraphQL
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-graphql/fields.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-graphql/class-videogram-wpgraphql.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-graphql/meta-query-featured.php';

		$this->loader = new Videogram_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Videogram_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 */
	private function set_locale() {

		$plugin_i18n = new Videogram_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Videogram_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'editor_assets' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_post_types' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_taxonomies' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_fields' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'register_menus' );

	}

	/**
	 * Initialize WPGraphQL
	 */
	private function wpgraphql() {

		$wpgraphql = new Videogram_WPGraphQL();

		$this->loader->add_action( 'graphql_register_types', $wpgraphql, 'register_fields' );
		$this->loader->add_action( 'register_post_type_args', $wpgraphql, 'expose_post_type', 10, 2 );
		$this->loader->add_action( 'register_taxonomy_args', $wpgraphql, 'expose_taxonomy', 10, 2 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Videogram_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
