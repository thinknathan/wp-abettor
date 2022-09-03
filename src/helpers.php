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

namespace Think_Nathan\Abettor;

use function wp_parse_url;

/**
 * Checks whether two URLs share the same base URL.
 *
 * This checks whether the following URL properties match:
 * - scheme
 * - domain
 * - host
 * - port
 *
 * @param string $base_url
 * @param string $input_url
 * @param bool $strict
 * @return bool
 */
function compare_base_url($base_url, $input_url, $strict_scheme = true)
{
	$base_url = trailingslashit($base_url);
	$input_url = trailingslashit($input_url);

	if ($base_url === $input_url) {
			return true;
	}

	$input_url = wp_parse_url($input_url);

	if (!isset($input_url['host'])) {
			return true;
	}

	$base_url = wp_parse_url($base_url);

	if (!isset($base_url['host'])) {
			return false;
	}

	if (!$strict_scheme || !isset($input_url['scheme']) || !isset($base_url['scheme'])) {
			$input_url['scheme'] = $base_url['scheme'] = 'abettor';
	}

	if (($base_url['scheme'] !== $input_url['scheme'])) {
			return false;
	}

	if ($base_url['host'] !== $input_url['host']) {
			return false;
	}

	if ((isset($base_url['port']) || isset($input_url['port']))) {
			return isset($base_url['port'], $input_url['port']) && $base_url['port'] === $input_url['port'];
	}

	return true;
}


/**
 * Determine whether current environment type is production.
 *
 * WP_ENV constant predates wp_get_environment_type function (introduced in WP 5.5), so check it first.
 * {@see https://github.com/roots/soil/pull/266}
 *
 * Assume production as default environment type when neither WP_ENV is set nor wp_get_environment_type() is available.
 *
 * @return bool
 */
function is_production_environment()
{
	if (defined('WP_ENV')) {
			return \WP_ENV === 'production';
	}

	if (function_exists('wp_get_environment_type')) {
			return wp_get_environment_type() === 'production';
	}

	return true;
}
