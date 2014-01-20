<?php

use \AgriLife\Core\Parser\PostTypeLabelParser;

class Test_Parsers extends WP_UnitTestCase {

	public function setUp() {

		parent::setUp();

	}

	public function tearDown() {

		parent::tearDown();

	}

	public function testPostTypeParserPassing() {

		$raw_labels = array(
			'singular' => 'Test',
			'plural' => 'Tests',
		);

		$labels = new PostTypeLabelParser( $raw_labels );

		$this->assertEquals( $raw_labels, $labels->get_parsed() );
	}

}
