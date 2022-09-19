<?php

/*
Plugin Name:        WordPress Abettor
Plugin URI:         https://github.com/thinknathan/
Description:        Helper plugin to enable a variety of theme-agnostic features.
Version:            2.0.2
Author:             Think_Nathan
Author URI:         https://thinknathan.ca/
License:            GPLv2
License URI:        https://github.com/thinknathan/wp-abettor/blob/master/LICENSE.txt
GitHub Plugin URI:  https://github.com/thinknathan/wp-abettor/
*/

namespace Think_Nathan\Abettor;

add_action('plugins_loaded', function () {
	if (!class_exists(Abettor::class)) {
			require_once file_exists($autoloader = __DIR__ . '/vendor/autoload.php')
					? $autoloader
					: __DIR__ . '/src/autoload.php';
	}

		$modules = Abettor::discoverModules();

		add_action('after_setup_theme', new Abettor($modules), 100);
});
