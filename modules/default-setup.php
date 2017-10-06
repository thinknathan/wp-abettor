<?php
/**
 * Sets default options 
 */

namespace Think_Nathan\Abettor\DefaultSetup;

function default_setup() {
  // set the options to change
  $option = array(
    // change the permalink structure
    'permalink_structure'           => '/%postname%/',
    // use year/month folders for uploads 
    'uploads_use_yearmonth_folders' => 1,
    // don't use those ugly smilies
    'use_smilies'                   => 0,
    // timezone
    'gmt_offset'                   => -7,
    // page on front
    'show_on_front'            => 'page',
    // use the default page
    'page_on_front'                => 2,
    // don't use gravatar
    'show_avatars'                => 0,
  );

  // change the options!
  foreach ( $option as $key => $value ) {  
    update_option( $key, $value );
  }

  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();

  // delete the default comment
  wp_delete_comment( 1 );
  // delete default post
  wp_delete_post( 1, TRUE );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\default_setup' );
