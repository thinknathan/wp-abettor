<?php
/**
 * Default setup for Gravity Forms.
 */

namespace Think_Nathan\Abettor\GravityFormsSetup;

/**
* Turn off Gravity Forms CSS
*/
add_filter( 'pre_option_rg_gforms_disable_css', '__return_true' );

/**
* Turn on Gravity Forms HTML5 output
*/
add_filter('pre_option_rg_gforms_enable_html5', '__return_true' );
