<?php

namespace AgriLife\Core;

class CustomFields {

	public function __construct( $group, $path ) {

		$this->group = $group;
		$this->path  = $path;

		// Create the Options page
		add_filter( 'acf/options_page/settings', array( $this, 'create_options_page' ) );
		add_action( 'plugins_loaded', array( $this, 'create_options_page' ) );

		// Allow JSON to be written into a plugin
		add_action( 'acf/update_field_group', array( $this, 'update_field_group' ), 10, 1 );
		add_action( 'acf/duplicate_field_group', array( $this, 'update_field_group' ), 10, 1 );
		add_action( 'acf/untrash_field_group', array( $this, 'update_field_group' ), 10, 1 );
		add_action( 'acf/trash_field_group', array( $this, 'delete_field_group' ), 10, 1 );
		add_action( 'acf/delete_field_group', array( $this, 'delete_field_group' ), 10, 1 );
		add_action( 'acf/include_fields', array( $this, 'include_fields' ), 10, 1 );

        // Hide ACF menu from all users
        add_filter('acf/settings/show_admin', array( $this, 'my_acf_hide_admin'));

	}

	public function create_options_page() {

		acf_update_setting( 'show_options_page', true );
		acf_add_options_page(array(
			'page_title' 	=> __('Options','acf'),
			'menu_title'	=> __('Options','acf'),
			'menu_slug' 	=> 'acf-options',
			'capability'	=> 'edit_posts',
			'parent_slug'	=> '',
			'position'		=> false,
			'icon_url'		=> false,
		));
	}

	/*
	*  update_field_group
	*
	*  This function is hooked into the acf/update_field_group action and will save all field group data to a .json file
	*
	*  @type	function
	*  @date	10/03/2014
	*  @since	5.0.0
	*
	*  @param	$field_group (array)
	*  @return	n/a
	*/

	public function update_field_group( $field_group ) {

		if ( $field_group['title'] != $this->group ) {
			return;
		}

		// vars
		$path = $this->path;
		$file = sanitize_title( $this->group ) . '.json';

		// remove trailing slash
		$path = untrailingslashit( $path );

		// bail early if dir does not exist
		if ( !is_writable( $path ) ) {

			//error_log( 'ACF failed to save field group to .json file. Path does not exist: ' . $path );
			return;

		}

		// load fields
		$fields = acf_get_fields( $field_group );

		// prepare fields
		$fields = acf_prepare_fields_for_export( $fields );

		// add to field group
		$field_group['fields'] = $fields;

		// extract field group ID
		$id = acf_extract_var( $field_group, 'ID' );

		// write file
		$f = fopen( "{$path}/{$file}", 'w' );
		fwrite( $f, acf_json_encode( $field_group ) );
		fclose( $f );

	}

	/*
	*  delete_field_group
	*
	*  This function will remove the field group .json file
	*
	*  @type	function
	*  @date	10/03/2014
	*  @since	5.0.0
	*
	*  @param	$field_group (array)
	*  @return	n/a
	*/

	function delete_field_group( $field_group ) {

		if ( $field_group['title'] != $this->group )
			return;

		// vars
		$path = $this->path;
		$file = sanitize_title( $this->group ) . '.json';

		// remove trailing slash
		$path = untrailingslashit( $path );

		// bail early if file does not exist
		if ( !is_readable( "{$path}/{$file}" ) ) {

			//error_log( 'ACF failed to save field group to .json file. Path does not exist: ' . $path );
			return;

		}

		// remove file
		unlink( "{$path}/{$file}" );

	}


	/*
	*  include_fields
	*
	*  This function will include any JSON files found in the active theme
	*
	*  @type	function
	*  @date	10/03/2014
	*  @since	5.0.0
	*
	*  @param	$version (int)
	*  @return	n/a
	*/

	function include_fields() {

		// validate
		if ( !is_readable( $this->path ) ) {

			//error_log( 'ACF failed to save field group to .json file. Path does not exist: ' . $path );
			return;

		}

		// vars
		$path = $this->path;

		// loop through and add to cache

		// remove trailing slash
		$path = untrailingslashit( $path );

		// check that path exists
		if ( !file_exists( $path ) ) {

			return;

		}

		$dir = opendir( $path );

		while ( false !== ( $file = readdir( $dir ) ) ) {

			// only json files
			if ( strpos( $file, '.json' ) === false ) {

				continue;

			}

			// read json
			$json = file_get_contents( "{$path}/{$file}" );

			// validate json
			if ( empty( $json ) ) {
				continue;
			}

			$json = json_decode( $json, true );

			acf_add_local_field_group( $json );

		}

	}

    function my_acf_hide_admin() {

        // Only show ACF admin to Super Users
        return current_user_can('manage_network');

    }
}