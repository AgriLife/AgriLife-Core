<?php
namespace AgriLife\Core;

class RemoveWidgets {

	public function __construct() {

		add_action( 'widgets_init', array( $this, 'remove_calendar_widget' ) );

	}

	public function remove_search_widget() {

		unregister_widget( 'WP_Widget_Search' );

	}

	public function remove_calendar_widget() {

		unregister_widget( 'WP_Widget_Calendar' );

	}

}