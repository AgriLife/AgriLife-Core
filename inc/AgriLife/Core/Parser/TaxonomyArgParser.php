<?php
namespace AgriLife\Core\Parser;

use \AgriLife\Core\Parser\Parser;

/**
 * Parses the Custom Taxonomy arguments
 * @package AgriLife-Core
 * @since 1.0.0
 */
class TaxonomyArgParser extends Parser {

	public function __construct( $passed = array() ) {

		parent::__construct( $passed );

		return $this->parsed;

	}

	protected function set_default() {

		$default = array(
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
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