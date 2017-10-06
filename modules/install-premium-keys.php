<?php
/**
 * Sets keys for premium WP plugins.
 */

namespace Think_Nathan\Abettor\InstallPremiumKeys;

// Gravity Forms
if ( getenv('GFORMS_KEY') ) {
  define( 'GF_LICENSE_KEY', getenv('GFORMS_KEY') );
}

function install_premium_keys() {
  // WP Rocket
  if ( function_exists ('update_rocket_option') && getenv('WP_ROCKET_KEY') ) {
    update_rocket_option( 'consumer_key', getenv('WP_ROCKET_KEY') );
  }
  // Advanced Custom Fields Pro
  if ( class_exists('acf') && getenv('ACF_PRO_KEY') ) {
    $save = array(
      'key'	=> getenv('ACF_PRO_KEY'),
      'url'	=> home_url()
	);
    $save = maybe_serialize($save);
    $save = base64_encode($save);
    update_option( 'acf_pro_license', $save );
  }
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\install_premium_keys' );
