<?php

namespace AgriLife\Core;

class Widgets {

	public function __construct() {

		add_filter( 'widget_text', 'do_shortcode' );

	}

}