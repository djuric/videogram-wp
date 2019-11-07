<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Videogram
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Videogram
 */
class Videogram_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Videogram_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Videogram_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/videogram-admin.css', [], $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Videogram_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Videogram_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/videogram-admin.js', [ 'jquery' ], $this->version, false );

	}

	/**
	 * Enqueue editor scripts and styles
	 */
	public function editor_assets() {

		wp_enqueue_script( 'videogram-block-script', VIDEOGRAM_PLUGIN_URL . 'block-editor/dist/index.js', [ 'wp-blocks', 'wp-editor' ], $this->version, false );

		wp_enqueue_style( 'videogram-block-editor-style', VIDEOGRAM_PLUGIN_URL . 'block-editor/dist/editor.css', [ 'wp-edit-blocks' ], $this->version );

	}

	/**
	 * Register post types
	 */
	public function register_post_types() {
		register_post_type(
			VIDEOGRAM_VIDEO_POST_TYPE,
			[
				'labels'             => [
					'name'          => __( 'Videos', 'videogram' ),
					'singular_name' => __( 'Video', 'videogram' ),
					'add_new_item'  => __( 'Add New Video', 'videogram' ),
					'edit_item'     => __( 'Edit Video', 'videogram' ),
					'new_item'      => __( 'New Video', 'videogram' ),
					'all_items'     => __( 'All Videos', 'videogram' ),
					'search_items'  => __( 'Search Videos', 'videogram' ),
				],
				'public'             => true,
				'publicly_queryable' => true,
				'menu_position'      => 7,
				'menu_icon'          => 'dashicons-video-alt3',
				'rewrite'            => [
					'slug' => 'video',
				],
				'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ],
				'show_in_rest'       => true,
				'template'           => [
					[ 'videogram/video' ],
				],
			]
		);
	}

	/**
	 * Register taxonomies
	 */
	public function register_taxonomies() {
		$args = [
			'hierarchical'        => true,
			'labels'              => [
				'name'          => __( 'Video Categories', 'videogram' ),
				'singular_name' => __( 'Video Category', 'videogram' ),
			],
			'show_in_rest'        => true,
			'show_in_graphql'     => true,
			'graphql_single_name' => 'VideoCategory',
			'graphql_plural_name' => 'VideoCategories',
		];

		register_taxonomy( 'video-category', VIDEOGRAM_VIDEO_POST_TYPE, $args );
		register_taxonomy_for_object_type( 'video-category', VIDEOGRAM_VIDEO_POST_TYPE );
	}

	/**
	 * Register navigation menus
	 */
	public function register_menus() {

		register_nav_menus(
			[
				'videogram_header_main' => __( 'VideoGram Header Primary', 'videoegram' ),
			]
		);

	}

}
