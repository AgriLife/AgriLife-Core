<?php
namespace AgriLife\Core\Taxonomy;

/**
 * The Taxonomy creator
 * @package AgriLife-Core
 * @since 1.0.0
 */
class Taxonomy {

	/**
	 * The plugin slug. Used for i10n
	 * @var string
	 */
	protected $plugin_slug;

	/**
	 * The post type(s) to be attached
	 * @var string|array
	 */
	private $post_type;

	/**
	 * The labels array, ready to be passed to the taxonomy arguments
	 * @var array
	 */
	private $labels_ready;

	/**
	 * The taxonomy arguments, ready to be passed to the registration method
	 * @var array
	 */
	private $args_ready;

	public function __construct( $slug, $object, $labels, $args ) {

		$this->post_type = $object;

		$this->labels_ready = $this->setup_labels( $labels );

		$this->args_ready = $this->setup_args( $args );

		return $this->register_taxonomy( sanitize_title( $slug ) );

	}

	/**
	 * Sets up the labels array
	 * @param  object $passed The taxonomy label object
	 * @return array          The labels array
	 */
	private function setup_labels( $passed ) {

		$passed_labels = $passed->get_parsed();

		$labels = array(
			'name'                       => _x( $passed_labels['plural'], 'Taxonomy General Name', $this->plugin_slug ),
			'singular_name'              => _x( $passed_labels['singular'], 'Taxonomy Singular Name' ),
			'search_items'               => __( 'Search ' . $passed_labels['plural'] ),
			'popular_items'              => __( 'Popular ' . $passed_labels['plural'] ),
			'all_items'                  => __( 'All ' . $passed_labels['plural'] ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit ' . $passed_labels['singular'] ),
			'update_item'                => __( 'Update ' . $passed_labels['singular'] ),
			'add_new_item'               => __( 'Add New ' . $passed_labels['singular'] ),
			'new_item_name'              => __( 'New ' . $passed_labels['singular'] . ' Name' ),
			'separate_items_with_commas' => __( 'Separate ' . $passed_labels['plural'] . ' with commas' ),
			'add_or_remove_items'        => __( 'Add or remove ' . $passed_labels['plural'] ),
			'choose_from_most_used'      => __( 'Choose from the most used ' . $passed_labels['plural'] ),
			'not_found'                  => __( 'No ' . $passed_labels['plural'] . ' found.' ),
			'menu_name'                  => __( $passed_labels['plural'] ),
		);

		return $labels;

	}

	/**
	 * Sets up the taxonomy arguments
	 * @param  object $passed The taxonomy arguments object
	 * @return array          The taxonomy arguments
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
	 * Regsiters the taxonomy with WordPress
	 * @param  string $slug 		The taxonomy slug
	 * @return object|WP_Error  The registered taxonomy object or error object
	 */
	private function register_taxonomy( $slug ) {

		return register_taxonomy( $slug, $this->post_type, $this->args_ready );

	}

}