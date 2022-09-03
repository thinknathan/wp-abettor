<?php

namespace Think_Nathan\Abettor\Modules;

use function add_action;
use function is_admin;
use function remove_meta_box;
use function remove_action;

/**
 * Removes default dashboard widgets
 */
class CleanAdminDashboardModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'clean-admin-dashboard';

	/**
	 * Condition under which the module is loaded.
	 *
	 * @return bool
	 */
	protected function condition()
	{
			return apply_filters(
				'abettor/load-module/' . $this->provides(),
				$this->options->enabled && is_admin()
			);
	}

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
		// Remove WP admin dashboard widgets
		add_action('admin_menu', function () {
			// Remove "At a Glance"
			remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
			// Remove "Activity" which includes "Recent Comments"
			remove_meta_box('dashboard_activity', 'dashboard', 'normal');
			// Remove Quick Draft
			remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
			// Remove WordPress Events and News
			remove_meta_box('dashboard_primary', 'dashboard', 'core');
			// Remove Welcome panel
			remove_action('welcome_panel', 'wp_welcome_panel');
			// Remove Yoast SEO widget
			remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'core');
			// Remove Wordfence widget
			remove_meta_box('wordfence_activity_report_widget', 'dashboard', 'core');
		});

		// Hide unwanted elements via CSS
		add_action('admin_head', function () {
			?>
		<style id="Think_Nathan_Abettor_Modules_CleanAdminDashboardModule">
			.yoast-notice-go-premium,
			.wpseo-tab-video-container,
			.wpseo-metabox-buy-premium,
			.update-nag,
			#wpfooter {
				display: none !important;
			}
		</style>
			<?php
		}, 6);
	}
}
