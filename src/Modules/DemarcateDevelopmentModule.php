<?php

namespace Think_Nathan\Abettor\Modules;

use function add_action;

/**
 * Provides visual differentiators for development sites.
 */
class DemarcateDevelopmentModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'demarcate-development';

	/**
	 * Condition under which the module is loaded.
	 *
	 * @return bool
	 */
	protected function condition()
	{
		return apply_filters(
			'abettor/load-module/' . $this->provides(),
			$this->options->enabled && (defined('WP_ENV') && WP_ENV === 'development')
		);
	}

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
		add_action('wp_head', [$this, 'addDevelopmentStyles'], 5);
		add_action('admin_head', [$this, 'addDevelopmentStyles'], 5);
		add_action('wp_footer', [$this, 'addDevelopmentFavicon'], 5);
		add_action('admin_footer', [$this, 'addDevelopmentFavicon'], 5);
	}

	/**
	 * Custom development message on dev environment
	 * Adds a red box to the top-left of all pages with the word "DEV"
	 *
	 * @return void
	 */
	public function addDevelopmentStyles()
	{
		?>
			<style id="Think_Nathan_Abettor_Modules_DemarcateDevelopmentModule_AddDevelopmentStyles">
				/**
				* wp-abettor plugin
				* Adds a red box to the top-left of all pages with the word "DEV" 
				*/
				html::before {
					content: 'DEV';
					font-weight: 700;
					letter-spacing: 1px;
					line-height: 3;
					text-align: center;
					width: 3rem;
					height: 3rem;
					background: red;
					display: block;
					position: fixed;
					top: 0;
					left: 0;
					z-index: 10000;
					pointer-events: none;
					opacity: 0.33;
				}
			</style>
		<?php
	}

	/**
	 * Custom development favicon
	 * Adds the letter D on top of the existing favicon
	 * Credit: http://www.totallycommunications.com/latest/dynamic-favicons-step-by-step-guide/
	 *
	 * @return void
	 */
	public function addDevelopmentFavicon()
	{
		?>
			<script id="Think_Nathan_Abettor_Modules_DemarcateDevelopmentModule_AddDevelopmentFavicon">
				/**
				* wp-abettor plugin
				* Adds the letter D on top of the existing favicon 
				*/
				(function () {
					const b = document.createElement("canvas");
					const d = document.createElement("img");
					const e = document.querySelector("link[rel=icon]");
					if (!e) return;
					const f = e.cloneNode(true);
					if ("function" == typeof b.getContext) {
						const size = 32;
						b.width = size;
						b.height = size;
						const a = b.getContext("2d");
						d.onload = function () {
							a.drawImage(this, 0, 0, size, size);
							a.font = "bold " + size * 0.75 + "px Arial";
							a.fillStyle = "red";
							a.strokeStyle = "white";
							a.lineWidth = 2;
							a.textAlign = "center";
							a.strokeText("D", size / 2, size / 1.25);
							a.fillText("D", size / 2, size / 1.25);
							f.href = b.toDataURL("image/png");
							document.head.appendChild(f);
						};
						d.src = e.href;
					};
				})();
			</script>
		<?php
	}
}
