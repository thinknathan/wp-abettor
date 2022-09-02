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

use function add_action;
use function apply_filters;
use function is_feed;
use function network_home_url;
use function remove_filter;
use function Think_Nathan\Abettor\compare_base_url;
use function wp_make_link_relative;

/**
 * Relative URLs Module
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by {@link http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/}
 */
class RelativeUrlsModule extends AbstractModule
{
		/**
		 * Name of the module.
		 *
		 * @var string
		 */
		protected $name = 'relative-urls';

		/**
		 * Condition under which the module is loaded.
		 *
		 * By default, modules are disabled in admin panel.
		 *
		 * @return bool
		 */
		protected function condition()
		{
				return parent::condition()
						&& !isset($_GET['sitemap']) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						&& !in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'], true);
		}

		/**
		 * Module handle.
		 *
		 * @return void
		 */
		public function handle()
		{
				$this->filters($this->urlFilters(), 'relativeUrl');
				$this->filter('wp_calculate_image_srcset', 'imageSrcset');

				$this->compat();
		}

		/**
		 * Convert an absolute URL to a relative URL.
		 *
		 * @internal Used by {@see self::urlFilters several filters}
		 *
		 * @param string $url
		 * @return string
		 */
		public function relativeUrl($url)
		{
				if (is_feed()) {
						return $url;
				}

				if (compare_base_url(network_home_url(), $url)) {
						return wp_make_link_relative($url);
				}

				return $url;
		}

		/**
		 * Convert multiple URL sources to relative URLs
		 *
		 * @internal Used by `wp_calculate_image_srcset`
		 * @param string[] $sources
		 * @return string[]
		 */
		public function imageSrcset($sources)
		{
				if (!is_array($sources)) {
						return $sources;
				}

				return array_map(function ($source) {
						$source['url'] = $this->relativeUrl($source['url']);

						return $source;
				}, $sources);
		}

		/**
		 * List of URL hooks to be filtered by this module
		 *
		 * @return string[]
		 */
		protected function urlFilters()
		{
				return apply_filters('abettor/relative-url-filters', [
						'bloginfo_url',
						'the_permalink',
						'wp_list_pages',
						'wp_list_categories',
						'wp_get_attachment_url',
						'the_content_more_link',
						'the_tags',
						'get_pagenum_link',
						'get_comment_link',
						'month_link',
						'day_link',
						'year_link',
						'term_link',
						'the_author_posts_link',
						'script_loader_src',
						'style_loader_src',
						'theme_file_uri',
						'parent_theme_file_uri',
				]);
		}

		/**
		 * Add compatibility with third-party plugins.
		 *
		 * @return void
		 */
		protected function compat()
		{
				$this->compatSeoFramework();
		}

		/**
		 * Add The SEO Framework compatibility.
		 *
		 * @return void
		 */
		protected function compatSeoFramework()
		{
				add_action('the_seo_framework_do_before_output', function () {
						remove_filter('wp_get_attachment_url', [$this, 'relativeUrl']);
				});

				add_action('the_seo_framework_do_after_output', function () {
						$this->filter('wp_get_attachment_url', 'relativeUrl');
				});
		}
}
