<?php
/**
 * Tests for testing PHPUnit
 */

class Test_Test extends WP_UnitTestCase {

	function test_tests() {
		$this->assertTrue( true );
		$this->assertFalse( false );
		$this->assertEquals('test', 'test');
	}
}
