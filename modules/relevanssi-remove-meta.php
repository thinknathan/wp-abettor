<?php
/**
 * Relevanssi & Yoast SEO compatibility
 * Removes problematic meta data from queries
 */

namespace Think_Nathan\Abettor\RelevanssiRemoveMeta;

function relevanssi_remove_meta_query( $query ) { 
  $query->query_vars['meta_query'] = null; 
  $query->meta_query = null; 
  return $query; 
}
add_filter( 'relevanssi_modify_wp_query', __NAMESPACE__ . '\\relevanssi_remove_meta_query', 999 ); 
