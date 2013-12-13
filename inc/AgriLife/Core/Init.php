<?php
namespace AgriLife\Core;

use \AgriLife\Core\Plugin\PluginBase;

class Init extends PluginBase {

	protected function __construct() {}

	public function init() {

		$this->plugin_slug = 'agrilife-core';

	}

}