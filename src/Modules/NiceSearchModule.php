<?php

/*
Copyright (c) Roots Software LLC

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

namespace Think_Nathan\Abettor\Modules;

use function is_search;
use function wp_safe_redirect;
use function get_search_link;

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */
class NiceSearchModule extends AbstractModule
{
		/**
		 * Name of the module.
		 *
		 * @var string
		 */
		protected $name = 'nice-search';

		/**
		 * Module handle.
		 *
		 * @return void
		 */
		public function handle()
		{
				$this->filter('template_redirect', 'redirect');

				$this->compat();
		}

		/**
		 * Redirect query string search results to pretty URL.
		 *
		 * @internal Used by `template_redirect`
		 *
		 * @return void
		 */
		public function redirect()
		{
				global $wp_rewrite;

				if (!isset($_SERVER['REQUEST_URI']) || !isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->get_search_permastruct()) {
						return;
				}

				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
				$request = wp_unslash(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));

				$search_base = $wp_rewrite->search_base;

				if (
						is_search()
						&& strpos($request, "/{$search_base}/") === false
						&& strpos($request, '&') === false
				) {
						wp_safe_redirect(get_search_link());
						exit;
				}
		}

		/**
		 * Rewrite query string search URL as pretty URL.
		 *
		 * @internal Used by `wpseo_json_ld_search_url`
		 *
		 * @param string $url
		 * @return string
		 */
		public function rewrite($url)
		{
				return str_replace('/?s=', '/search/', $url);
		}

		/**
		 * Add compatibility with third-party plugins.
		 *
		 * @return void
		 */
		protected function compat()
		{
				$this->compatYoastSeo();
		}

		/**
		 * Add compatibility for Yoast SEO.
		 *
		 * @return void
		 */
		protected function compatYoastSeo()
		{
				$this->filter('wpseo_json_ld_search_url', 'rewrite');
		}
}
