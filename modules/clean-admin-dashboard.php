<?php
/**
 * Removes default dashboard widgets
 */

namespace Think_Nathan\Abettor\CleanAdminDashboard;

// Remove WP admin dashboard widgets
function disable_dashboard_widgets() {
  // Remove "At a Glance"
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); 
  // Remove "Activity" which includes "Recent Comments"
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); 
  // Remove Quick Draft
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); 
  // Remove WordPress Events and News
  remove_meta_box( 'dashboard_primary', 'dashboard', 'core' ); 
  
  // Remove welcome panel
  remove_action( 'welcome_panel', 'wp_welcome_panel' ); 
  
  // Remove Wordfence widget
  remove_meta_box( 'wordfence_activity_report_widget', 'dashboard', 'core' ); 
  // Remove Yoast SEO widget
  remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'core' );
  // Remove Gravity Forms widget
  remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'core' );
}
add_action('admin_menu', __NAMESPACE__ . '\\disable_dashboard_widgets');
