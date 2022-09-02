<?php
namespace Think_Nathan\Abettor\Modules;

use function add_action;

/**
 * Hides front-end admin bar for all users.
 */
class DisableAdminBarModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'disable-admin-bar';

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
		add_action( 'show_admin_bar', '__return_false' );
	}
}
