<?php
namespace Think_Nathan\Abettor\Modules;

use function add_action;
use function remove_menu_page;
use function remove_submenu_page;
use function remove_meta_box;
use function unregister_widget;
use function update_option;
use function remove_action;
use function add_filter;
use function remove_post_type_support;

/**
 * Removes options and widgets related to comments.
 *
 * Credit to https://wordpress.org/plugins/disable-comments/
 * which is a more comprehensive, better version of this plugin
 */
class DisableCommentsModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'disable-comments';

	/**
	 * Condition under which the module is loaded.
	 *
	 * @return bool
	 */
	protected function condition()
	{
			return apply_filters(
					'abettor/load-module/' . $this->provides(),
					$this->options->enabled
			);
	}

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
		// Remove support for comments from posts and pages
		add_action('init', function () {
			remove_post_type_support( 'page', 'comments' );
			remove_post_type_support( 'post', 'comments' );
			remove_post_type_support( 'page', 'trackbacks' );
			remove_post_type_support( 'post', 'trackbacks' );
		}, 100);

		// Remove comments widget in sidebar
		add_action( 'widgets_init', function () {
			unregister_widget( 'WP_Widget_Recent_Comments' );
		} );

		add_action( 'wp_loaded', function () {
			// Set comments to closed in options
			update_option( 'default_comment_status', 'closed' );

			// Remove comments links from admin bar
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );

			// Disable comments
			add_filter( 'comments_open', '__return_false', 10, 2 );

			// Disables comments feed link
			add_filter( 'feed_links_show_comments_feed', '__return_false' );
		} );

		// Remove comments page and comments options page
		add_action( 'admin_menu', function () {
			remove_menu_page( 'edit-comments.php' );
			remove_submenu_page( 'options-general.php', 'options-discussion.php' );
			
			// Remove discussion meta box
			remove_meta_box( 'commentstatusdiv','post','normal' );
			remove_meta_box( 'commentstatusdiv','page','normal' );
			
			// Remove trackback meta box
			remove_meta_box( 'trackbacksdiv','post','normal' );
			remove_meta_box( 'trackbacksdiv','page','normal' );
			
			// Remove comments meta box
			remove_meta_box( 'commentsdiv','page','normal' );
		}, 999 );

		// Remove "Activity" which includes "Recent Comments"
		add_action( 'wp_dashboard_setup', function () {
			remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
		} );
	}
}
