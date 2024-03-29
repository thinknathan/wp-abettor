<?php

namespace Think_Nathan\Abettor\Modules;

use function add_filter;

/**
 * Default setup for Gravity Forms.
 */
class GravityFormsSetupModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'gravity-forms-setup';

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
		/**
		* Turn off Gravity Forms CSS
		*/
		add_filter('gform_disable_form_theme_css', '__return_true');
		add_filter('pre_option_rg_gforms_disable_css', '__return_true');

		/**
		* Turn on Gravity Forms HTML5 output
		*/
		add_filter('pre_option_rg_gforms_enable_html5', '__return_true');
	}
}
