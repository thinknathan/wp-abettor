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

use WP_Error;

use function __;
use function remove_action;
use function rest_authorization_required_code;

/**
 * Disable WordPress REST API
 */
class DisableRestApiModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'disable-rest-api';

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
			remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
			remove_action('template_redirect', 'rest_output_link_header', 11);
			remove_action('wp_head', 'rest_output_link_wp_head', 10);

			$this->filter('rest_authentication_errors', 'restAuthenticationError', 15);
	}

	/**
	 * Return an error when REST API is accessed.
	 *
	 * @internal Used by `rest_authentication_errors`
	 *
	 * @return WP_Error
	 */
	public function restAuthenticationError()
	{
			return new WP_Error(
				'rest_forbidden',
				__('REST API forbidden.', 'abettor'),
				['status' => rest_authorization_required_code()]
			);
	}
}
