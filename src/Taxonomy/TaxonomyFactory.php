<?php
namespace AgriLife\Core\Taxonomy;

use \AgriLife\Core\Parser\TaxonomyLabelParser;
use \AgriLife\Core\Parser\TaxonomyArgParser;

/**
 * The Taxonomy Factory
 * @package AgriLife-Core
 * @since 1.0.0
 */
class TaxonomyFactory {

	/**
	 * Creates the taxonomy
	 * @param  string              $slug   The taxonomy slug
	 * @param  string|array        $object The post type(s) to attach
	 * @param  TaxonomyLabelParser $labels The parsed labels
	 * @param  TaxonomyArgParser   $args   The parsed arguments
	 * @return object                      The taxonomy object
	 */
	public static function create( $slug, $object, TaxonomyLabelParser $labels, TaxonomyArgParser $args ) {

		return new Taxonomy( $slug, $object, $labels, $args );

	}

}