<?php
namespace AgriLife\Core\Parser;

abstract class Parser {

	protected $default;

	protected $passed;

	protected $parsed;

	protected function __construct( $passed ) {

		$this->set_default();

		$this->set_passed( $passed );

		$this->parse_arguments();

	}

	abstract protected function set_default();

	abstract protected function set_passed( $passed );

	abstract protected function parse_arguments();

	public function get_parsed() {

		return $this->parsed;

	}

}