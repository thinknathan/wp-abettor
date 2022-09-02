<?php

namespace Think_Nathan\Abettor\DisableRestApi;

/**
 * Disable WordPress REST API
 */
remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
remove_action('template_redirect', 'rest_output_link_header', 11);
remove_action('wp_head', 'rest_output_link_wp_head', 10);

add_filter('rest_authentication_errors', function ($result) {
  if (!empty($result)) {
    return $result;
  }

  if (!is_user_logged_in()) {
    return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', ['status' => 401]);
  }

  return $result;
});
