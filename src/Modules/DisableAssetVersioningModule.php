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

use function esc_url;
use function remove_query_arg;

/**
 * Remove version query string from all styles and scripts
 */
class DisableAssetVersioningModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'disable-asset-versioning';

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
			$this->filters(['script_loader_src', 'style_loader_src'], 'removeVersionQueryVar', 15, 1);
	}

	/**
	 * Remove `ver` query variable from URL.
	 *
	 * @internal Used by `script_loader_src` and `style_loader_src`
	 *
	 * @param string $url
	 * @return string|bool
	 */
	public function removeVersionQueryVar($url)
	{
			return $url ? esc_url(remove_query_arg('ver', $url)) : false;
	}
}
