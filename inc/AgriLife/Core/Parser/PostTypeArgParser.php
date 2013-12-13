<?php
namespace AgriLife\Core\Parser;

use \AgriLife\Core\Parser\Parser;

/**
 * Parses the singular and plural names for Custom Post Types
 * @package AgriLife-Core
 * @since 1.0.0
 */
class PostTypeArgParser extends Parser {

	public function __construct( $passed = array() ) {

		parent::__construct( $passed );

		return $this->parsed;

	}

	protected function set_default() {

	$default = array(
		'description' => '',
		'public' => true,
		'exclude_from_search' => false,
		'show_in_nav_menus' => true,
		'menu_position' => 26,
		'menu_icon' => null,
		'capability_type' => 'post',
		'supports' => array( 'title', 'editor' ),
		'has_archive' => true,
	);

		$this->default = $default;

	}

	public function set_passed( $passed ) {

		$this->passed = $passed;

	}

	protected function parse_arguments() {

		$this->parsed = wp_parse_args( $this->passed, $this->default );

	}

}