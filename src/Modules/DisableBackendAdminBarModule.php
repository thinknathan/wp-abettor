<?php

namespace Think_Nathan\Abettor\Modules;

use function add_action;
use function is_admin;

/**
 * Hides the admin bar on the backend.
 */
class DisableBackendAdminBarModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'disable-backend-admin-bar';

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
		add_action('admin_head', function () {
			?>
		<style id="Think_Nathan_Abettor_Modules_DisableBackendAdminBarModule">
			/**
			 * wp-abettor plugin
			 * Hide admin bar for large screens
			 */
			@media only screen and (min-width: 783px) {
				#wpadminbar {
					display: none !important;
				}
				html { 
					padding-top: 0 !important;
				}
				.acf-headerbar,
				.woocommerce-layout__header {
					top: 0 !important;
				}
			}

			/**
			 * Hide WordPress icon on top menu
			 */
			#wp-admin-bar-wp-logo {
				display: none !important;
			}
		</style>
			<?php
		}, 6);
	}
}
