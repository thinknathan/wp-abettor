<?php
/**
 * Adds preload syntax to enqueued stylesheets
 * Follows loadCSS setup
 * @link https://github.com/filamentgroup/loadCSS
 */
 
namespace Think_Nathan\Abettor\LazyloadCss;

function style_loadcss($html, $handle) {
	if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php') {
		return $html;
	}
  if (strpos($html, 'print') === false) {
    $html = str_replace(' href', ' media="print" onload="this.media=\'all\'; this.onload=null;" href', $html);
  }
	return $html;
}
add_filter('style_loader_tag', __NAMESPACE__ . '\\style_loadcss', 20, 2);
