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

use function wp_die;

/**
 * Disables trackbacks/pingbacks
 */
class DisableTrackbacksModule extends AbstractModule
{
		/**
		 * Name of the module.
		 *
		 * @var string
		 */
		protected $name = 'disable-trackbacks';

		/**
		 * Module handle.
		 *
		 * @return void
		 */
		public function handle()
		{
				$this->filter('xmlrpc_methods', 'disablePingback');
				$this->filter('wp_headers', 'removePingbackHeaders');
				$this->filter('bloginfo_url', 'removePingbackUrl', 10, 2);
				$this->filter('xmlrpc_call', 'removePingbackXmlrpc');
				$this->filter('rewrite_rules_array', 'removeTrackbackRewriteRules');
		}

		/**
		 * Disable pingback XMLRPC method.
		 *
		 * @internal Used by `xmlrpc_methods`
		 *
		 * @param array $methods
		 * @return array
		 */
		public function disablePingback($methods)
		{
				unset($methods['pingback.ping']);
				return $methods;
		}

		/**
		 * Remove pingback headers.
		 *
		 * @internal Used by `wp_headers`
		 *
		 * @param array $headers
		 * @return array
		 */
		public function removePingbackHeaders($headers)
		{
				unset($headers['X-Pingback']);
				return $headers;
		}

		/**
		 * Remove bloginfo('pingback_url').
		 *
		 * @internal Used by `bloginfo_url`
		 *
		 * @param string $output
		 * @param string $show
		 * @return string
		 */
		public function removePingbackUrl($output, $show)
		{
				return $show === 'pingback_url' ? '' : $output;
		}

		/**
		 * Disable XMLRPC pingback action.
		 *
		 * @internal Used by `xmlrpc_call`
		 *
		 * @param string $action
		 * @return void
		 */
		public function removePingbackXmlrpc($action)
		{
				if ($action === 'pingback.ping') {
						wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
				}
		}

		/**
		 * Remove trackback rewrite rules.
		 *
		 * @internal Used by `rewrite_rules_array`
		 *
		 * @param array $rules
		 * @return array
		 */
		public function removeTrackbackRewriteRules($rules)
		{
				foreach (array_keys($rules) as $rule) {
						if (preg_match('/trackback\/\?\$$/i', $rule)) {
								unset($rules[$rule]);
						}
				}
				return $rules;
		}
}
