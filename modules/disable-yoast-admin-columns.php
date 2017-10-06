<?php
/**
 * Remove Yoast SEO columns from admin post tables
 */

namespace Think_Nathan\Abettor\DisableYoastAdminColumns;

function yoast_remove_columns( $columns ) {
	// SEO score icon
	unset( $columns['wpseo-score'] );
  // SEO title
	unset( $columns['wpseo-title'] );
  // Meta Desc.
	unset( $columns['wpseo-metadesc'] );
  // Focus Keyword
	unset( $columns['wpseo-focuskw'] );
  // # links in post
	unset( $columns['wpseo-links'] );
  // Readability score icon
  unset( $columns['wpseo-score-readability'] );
	return $columns;
}
add_filter ( 'manage_edit-post_columns', __NAMESPACE__ . '\\yoast_remove_columns' );
add_filter ( 'manage_edit-page_columns', __NAMESPACE__ . '\\yoast_remove_columns' );
