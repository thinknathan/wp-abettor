<?php
/**
 * Adds "View Site" link to admin sidebar
 */

namespace Think_Nathan\Abettor\ViewSiteAdminSidebar;

/* Add new "View Home" item to admin menu */
function view_the_site_url() {
  add_menu_page( 'view_the_site_url', 'View Site', 'read', 'view_the_site', '', '
dashicons-admin-site', 1 );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\view_the_site_url' );

/* Attach home URL to "View Home" item */
function view_the_site_url_function() {
  global $menu;
  $menu[1][2] = get_home_url();
}
add_action( 'admin_menu', __NAMESPACE__ . '\\view_the_site_url_function' );
