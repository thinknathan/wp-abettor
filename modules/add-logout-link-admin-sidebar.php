<?php
/**
 * Adds logout link to the admin menu
 */

namespace Think_Nathan\Abettor\LogoutLink;

// Add the link to the admin sidebar
function logout_link() {
  add_menu_page(
    __( 'Logout', 'sage' ),
    __( 'Logout', 'sage' ),
    'read',
    'logout',
    '__return_false',
    'dashicons-arrow-left-alt',
    70
  );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\logout_link' );

// Add the page which redirects to the logout page
function redirect_logout() {
  if ( isset($_GET['page']) && $_GET['page'] == 'logout' ) {
    wp_redirect( wp_logout_url() );
    exit();
  }
}
add_action('admin_init', __NAMESPACE__ . '\\redirect_logout');
