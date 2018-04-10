<?php
/**
 * Hides the admin bar on the backend. 
 */

namespace Think_Nathan\Abettor\DisableBackendAdminBar;

function add_admin_styles() {
?>
  <style>
    /**
    * wp-abettor plugin
    * Hide admin bar for large screens
    */
    @media only screen and (min-width: 783px) {
      #wpadminbar {
        display: none !important;
      }
      html { 
        padding-top: 0 !important;
      }
    }
    
    /**
    * Hide WordPress icon on top menu
    */
    #wp-admin-bar-wp-logo {
      display: none !important;
    }
  </style>
<?php
}
add_action( 'admin_head', __NAMESPACE__ . '\\add_admin_styles', 6 );
