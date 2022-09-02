<?php
namespace Think_Nathan\Abettor\Modules;

use function add_action;
use function add_menu_page;
use function is_admin;

/**
 * Adds "View Site" link to admin sidebar
 */
class AddViewSiteAdminSidebarModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'add-view-site-admin-sidebar';

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
		/* Add new "View Home" item to admin menu */
		add_action( 'admin_menu', function () {
			add_menu_page( 'view_the_site_url', 'View Site', 'read', 'view_the_site', '', '
		dashicons-admin-site', 1 );
		} );

		/* Attach home URL to "View Home" item */
		add_action( 'admin_menu', function () {
			global $menu;
			$menu[1][2] = get_home_url();
		} );
	}
}
