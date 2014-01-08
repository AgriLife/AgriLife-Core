<?php
namespace AgriLife\Core\Parser;

use \AgriLife\Core\Parser\Parser;

class TaxonomyLabelParser extends Parser {

	public function __construct( array $passed ) {

		parent::__construct( $passed );

		return $this->parsed;

	}

	protected function set_default() {

		$default = array(
			'singular' => '',
			'plural' => '',
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