<?php
/**
 * Hides the admin bar on the backend. 
 */

namespace Think_Nathan\Abettor\DisableBackendAdminBar;

function add_admin_styles() {
  $output = "<style>#wpadminbar{display:none!important}html{padding-top:0!important}</style>";
  echo $output;
}
add_action( 'admin_head', __NAMESPACE__ . '\\add_admin_styles', 6 );
