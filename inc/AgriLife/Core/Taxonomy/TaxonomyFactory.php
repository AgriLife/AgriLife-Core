<?php
namespace AgriLife\Core\Taxonomy;

use \AgriLife\Core\Parser\TaxonomyLabelParser;
use \AgriLife\Core\Parser\TaxonomyArgParser;

class TaxonomyFactory {

	public static function create( $slug, $object, TaxonomyLabelParser $labels, TaxonomyArgParser $args ) {

		return new Taxonomy( $slug, $object, $labels, $args );

	}

}