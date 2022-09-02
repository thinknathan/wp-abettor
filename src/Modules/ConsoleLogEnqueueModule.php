<?php
namespace Think_Nathan\Abettor\Modules;

use function add_action;
use function is_admin;

/**
 * Logs enqueued scripts and stylesheets to the browser console
 * Only active on development environment
 */
class ConsoleLogEnqueueModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'console-log-enqueue';

	/**
	 * Condition under which the module is loaded.
	 *
	 * @return bool
	 */
	protected function condition()
	{
		return apply_filters(
			'abettor/load-module/' . $this->provides(),
			$this->options->enabled && (!is_admin() || wp_doing_ajax()) && (defined('WP_ENV') && WP_ENV === 'development')
		);
	}

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
		add_action( 'wp_footer', function() {
			global $wp_scripts;
			global $wp_styles;
			echo '<script id="Think_Nathan_Abettor_Modules_ConsoleLogEnqueueModule">';
			echo 'console.log("Enqueued scripts:",', json_encode($wp_scripts->queue), ');';
			echo 'console.log("Enqueued stylesheets:",', json_encode($wp_styles->queue), ');';
			echo '</script>';
		} );
	}
}
