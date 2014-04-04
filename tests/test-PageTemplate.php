<?php
/**
 * Tests for testing PHPUnit
 */

use org\bovigo\vfs as VFS;

class Test_PageTemplate extends WP_UnitTestCase {

	protected $root;

	protected $plugin_dir;

	protected $input_path;

	protected $input_file;

	protected $input_name;

	protected $pagetemplate;

	function setUp() {

		parent::setUp();

		$this->root = VFS\vfsStream::setup( 'srv' );
		$www = VFS\vfsStream::newDirectory( 'www' )->at( $this->root );
		$default = VFS\vfsStream::newDirectory( 'wordpress-default' )->at( $www );
		$wp_content = VFS\vfsStream::newDirectory( 'wp-content' )->at( $default );
		$plugins = VFS\vfsStream::newDirectory( 'plugins' )->at( $wp_content );
		$this->plugin_dir = VFS\vfsStream::newDirectory( 'agrilife-core' )->at( $plugins );

		$template_dir = VFS\vfsStream::newDirectory( 'templates' )->at( $this->plugin_dir );
		VFS\vfsStream::newFile( 'template-test.php' )->at( $template_dir );
		$this->input_path = VFS\vfsStream::url( 'srv/www/wordpress-default/wp-content/plugins/agrilife-core/templates' );
		$this->input_file = VFS\vfsStream::url( 'srv/www/wordpress-default/wp-content/plugins/agrilife-core/templates/template-test.php' );

		$this->input_name = 'Test Template';

	}

	function test_PathCannotBeBlank() {

		$this->setExpectedException( 'Exception', 'The path cannot be blank' );
		$this->pagetemplate = new AgriLife\Core\PageTemplate( '' );

	}

	function test_PathMustExist() {

		$bad_path = VFS\vfsStream::url( 'srv/www/wordpress-default/wp-content/plugins/agrilife-core/some_dir' );

		$this->setExpectedException( 'Exception', 'The path must exist' );
		$this->pagetemplate = new AgriLife\Core\PageTemplate( $bad_path );

	}

	function test_SetInputPathInConstructor() {

		$this->pagetemplate = new AgriLife\Core\PageTemplate( $this->input_path );
		$path = $this->pagetemplate->get_path();
		$this->assertSame( $this->input_path, $path );

	}

	function test_SetInputPathInMethod() {

		$this->pagetemplate = new AgriLife\Core\PageTemplate();
		$this->pagetemplate->with_path( $this->input_path );
		$path = $this->pagetemplate->get_path();
		$this->assertSame( $this->input_path, $path );

	}

	function test_FileNotBlank() {

		$this->setExpectedException( 'Exception', 'The filename cannot be blank' );
		$this->pagetemplate = new AgriLife\Core\PageTemplate( $this->input_path, '' );

	}

	function test_FileMustExist() {

		$this->setExpectedException( 'Exception', 'The template file must exist' );
		$this->pagetemplate = new AgriLife\Core\PageTemplate( $this->input_path, 'bad-file' );

	}

	function test_SetFileInConstructor() {

		$this->pagetemplate = new AgriLife\Core\PageTemplate( $this->input_path, 'template-test' );
		$file = $this->pagetemplate->get_file();
		$this->assertSame( $this->input_file, $file );

	}

	function test_SetFileInMethod() {

		$this->pagetemplate = new AgriLife\Core\PageTemplate( $this->input_path );
		$this->pagetemplate->with_file( 'template-test' );
		$file = $this->pagetemplate->get_file();
		$this->assertSame( $this->input_file, $file );

	}

	function test_SetPathAndFileInMethodChain() {

		$this->pagetemplate = new AgriLife\Core\PageTemplate();
		$this->pagetemplate->with_path( $this->input_path )->with_file( 'template-test' );

		$path = $this->pagetemplate->get_path();
		$this->assertSame( $this->input_path, $path );

		$file = $this->pagetemplate->get_file();
		$this->assertSame( $this->input_file, $file );

	}

	function test_SetNameInConstructor() {

		$template = new AgriLife\Core\PageTemplate( $this->input_path, 'template-test', $this->input_name );
		$name = $template->get_name();
		$this->assertSame( $this->input_name, $name );

	}

	function test_SetNameInMethodChain() {

		$this->pagetemplate = new AgriLife\Core\PageTemplate();
		$this->pagetemplate->with_path( $this->input_path )->with_file( 'template-test' )->with_name( $this->input_name );
		$name = $this->pagetemplate->get_name();
		$this->assertSame( $this->input_name, $name );

	}

	function test_TemplateRegistered() {

		$this->pagetemplate = new AgriLife\Core\PageTemplate();
		$this->pagetemplate->with_path( $this->input_path )->with_file( 'template-test' )->with_name( $this->input_name );
		$filters = $this->pagetemplate->register();

		$templates = wp_get_theme()->get_page_templates();
		$this->assertArrayNotHasKey( $this->pagetemplate->get_file(), $templates );

		apply_filters( 'page_attributes_dropdown_pages_args', '' );

		$templates = wp_get_theme()->get_page_templates();
		$this->assertArrayHasKey( $this->pagetemplate->get_file(), $templates );

	}

	function test_TemplateCanBeApplied() {


		$regular_page = $this->factory->post->create_and_get( array( 'post_type' => 'page' ) );
		update_post_meta( $regular_page->ID, '_wp_page_template', 'default' );
		$regular_page_template = get_post_meta( $regular_page->ID, '_wp_page_template', true );
		$this->assertSame( 'default', $regular_page_template );

		$special_page = $this->factory->post->create_and_get( array( 'post_type' => 'page' ) );
		update_post_meta( $special_page->ID, '_wp_page_template', $this->input_file );
		$special_page_template = get_post_meta( $special_page->ID, '_wp_page_template', true );
		$this->assertSame( $this->input_file, $special_page_template );

	}

}
