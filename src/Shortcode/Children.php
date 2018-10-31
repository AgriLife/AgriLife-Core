<?php

namespace AgriLife\Core\Shortcode;

class Children {

	public function __construct() {

		add_shortcode( 'children', array( $this, 'children_shortcode' ) );

	}

	public function children_shortcode() {

		global $post;

		$args = array(
			'echo' => 0,
			'depth' => 0,
			'child_of' => $post->ID,
			'title_li' => ''
		);

		$content = sprintf( '<ul class="children-shortcode">%s</ul>',
			wp_list_pages( $args )
		);

		return $content;

	}

}
