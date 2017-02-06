<?php
namespace AgriLife\Core\PostType;

use \AgriLife\Core\Parser\PostTypeLabelParser;
use \AgriLife\Core\Parser\PostTypeArgParser;

/**
 * The Post Type Factory
 * @package AgriLife-Core
 * @since 1.0.0
 */
class PostTypeFactory {

	/**
	 * Creates the post type from the passed argument
	 * @param string 							$slug 	The post type slug
	 * @param PostTypeLabelParser $labels The post type singular and plural labels
	 * @param PostTypeArgParser		$args 	The post type arguments
	 * @see http://codex.wordpress.org/Function_Reference/register_post_type
	 * @return object       The post type object
	 */
	public static function create( $slug, PostTypeLabelParser $labels, PostTypeArgParser $args ) {

		return new PostType( $slug, $labels, $args );

	}

}