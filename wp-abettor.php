<?php
/*
Plugin Name:  WordPress Abettor
Plugin URI:   https://github.com/thinknathan/
Description:  Helper plugin to enable a variety of theme-agnostic features.
Version:      1.0.2
Author:       Think_Nathan
Author URI:   https://thinknathan.ca/
License:      GPLv2
GitHub Plugin URI: thinknathan/wp-abettor
*/

namespace Think_Nathan\Abettor;

function load_modules() {
  foreach (glob(__DIR__ . '/modules/*.php') as $file) {
    $feature = 'abet-' . basename($file, '.php');
    require_if_theme_supports($feature, $file);
  }
}
add_action('after_setup_theme', __NAMESPACE__ . '\\load_modules', 100);
