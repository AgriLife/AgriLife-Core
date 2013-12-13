<?php
namespace AgriLife\Core\PostType;

/**
 * The Post Type creater
 * @package AgriLife-Core
 * @since 1.0.0
 */
class PostType {

	/**
	 * The plugin slug. Used for i10n
	 * @var string
	 */
	protected $plugin_slug;

	/**
	 * The labels array, ready to be passed to the post type arguments
	 * @var array
	 */
	private $labels_ready;

	/**
	 * The post type arguments, ready to be passed to the registration method
	 * @var array
	 */
	private $args_ready;

	public function __construct( $slug, $labels, $args ) {

		$this->labels_ready = $this->setup_labels( $labels );

		$this->args_ready = $this->setup_args( $args );

		return $this->register_post_type( sanitize_title( $slug ) );

	}

	/**
	 * Sets up the labels array
	 * @param  string $passed The post type labels
	 * @return array The labels array
	 */
	private function setup_labels( $passed ) {

		$passed_labels = $passed->get_parsed();

		$labels = array(
			'name' => _x( $passed_labels['plural'], 'Post Type General Name', $this->plugin_slug ),
			'singular_name' => _x( $passed_labels['singular'], 'Post Type Singular Name', $this->plugin_slug ),
			'add_new' => __( 'Add New', $this->plugin_slug ),
			'add_new_item' => __( 'Add New ' . $passed_labels['singular'], $this->plugin_slug ),
			'edit_item' => __( 'Edit ' . $passed_labels['singular'], $this->plugin_slug ),
			'new_item' => __( 'New ' . $passed_labels['singular'], $this->plugin_slug ),
			'all_items' => __( 'All ' . $passed_labels['plural'], $this->plugin_slug ),
			'view_item' => __( 'View ' . $passed_labels['singular'], $this->plugin_slug ),
			'search_items' => __( 'Search ' . $passed_labels['plural'], $this->plugin_slug ),
			'not_found' => __( 'No ' . $passed_labels['plural'] . ' found', $this->plugin_slug ),
			'not_found_in_trash' => __( 'No ' . $passed_labels['plural'] . ' found in trash', $this->plugin_slug ),
			'parent_item_colon' => __( 'Parent ' . $passed_labels['singular'] . ':', $this->plugin_slug ),
			'menu_name' => __( $passed_labels['plural'], $this->plugin_slug ),
		);

		return $labels;

	}

	/**
	 * Sets up the post type arguments
	 * @param  string $passed The post type arguments
	 * @return array The post type arguments
	 */
	private function setup_args( $passed ) {

		$passed_args = $passed->get_parsed();

		$this->plugin_slug = $passed_args['plugin-slug'];

		$args = array(
			'labels' => $this->labels_ready,
		);

		foreach ( $passed_args as $key => $value ) {
			$args[$key] = $value;
		}

		return $args;

	}

	/**
	 * Registers the post type with WordPress
	 * @param string $slug The post type slug
	 * @return object|WP_Error The registered post type object or error object
	 */
	private function register_post_type( $slug ) {

		return register_post_type( $slug, $this->args_ready );

	}

}