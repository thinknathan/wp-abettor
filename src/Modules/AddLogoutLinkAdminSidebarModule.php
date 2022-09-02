<?php
namespace Think_Nathan\Abettor\Modules;

use function add_action;
use function add_menu_page;
use function wp_redirect;
use function wp_logout_url;
use function is_admin;

/**
 * Adds logout link to the admin menu
 */
class AddLogoutLinkAdminSidebarModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'add-logout-link-admin-sidebar';

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
		/**
		 * Add the page which redirects to the logout page
		 *
		 * @return void
		 */
		add_action( 'admin_menu', function() {
			add_menu_page(
				__( 'Logout', 'sage' ),
				__( 'Logout', 'sage' ),
				'read',
				'logout',
				'__return_false',
				'dashicons-arrow-left-alt',
				200
			);
		} );

		/**
		 * Add the link to the admin sidebar
		 *
		 * @return void
		 */
		add_action( 'admin_init', function() {
			if ( isset($_GET['page']) && $_GET['page'] == 'logout' ) {
				wp_redirect( wp_logout_url() );
				exit();
			}
		} );
	}
}
