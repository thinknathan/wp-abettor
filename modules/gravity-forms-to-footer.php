<?php
/**
 * Moves Gravity Forms code to footer.
 */

namespace Think_Nathan\Abettor\GravityFormsToFooter;

/**
* Move Gravity Forms code to the footer
* Credit: https://gist.github.com/eriteric/5d6ca5969a662339c4b3
*/
add_filter( 'gform_init_scripts_footer', '__return_true' );

/**
* Delay gform functions until DOM is loaded
*/
function wrap_gform_cdata_open( $content = '' ) {
  if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
    return $content;
  }
  $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
  return $content;
}
add_filter( 'gform_cdata_open', __NAMESPACE__ . '\\wrap_gform_cdata_open', 1 );

function wrap_gform_cdata_close( $content = '' ) {
  if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
    return $content;
  }
  $content = ' }, false );';
  return $content;
}
add_filter( 'gform_cdata_close', __NAMESPACE__ . '\\wrap_gform_cdata_close', 99 );

/**
* Prevents scripts from Gravity Forms shortcodes from being printed, and instead enqueues the scripts.
*/
add_filter( 'gform_disable_print_form_scripts', '__return_true' );
