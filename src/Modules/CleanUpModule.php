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

use DOMDocument;
use Think_Nathan\Abettor\DOM;

use function add_action;
use function add_filter;
use function esc_url;
use function get_bloginfo;
use function get_default_feed;
use function get_feed_link;
use function get_option;
use function get_permalink;
use function is_front_page;
use function is_page;
use function is_rtl;
use function is_single;
use function remove_action;
use function __;

/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS and JS from WP emoji support
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag
 */
class CleanUpModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'clean-up';

	/**
	 * Default options.
	 *
	 * @var array
	 */
	protected $defaults = [
			/**
			 * Enable this module.
			 *
			 * @var bool
			 */
			'enabled' => true,

			/**
			 * Obscure and suppress WordPress information.
			 *
			 * @var bool
			 */
			'wp_obscurity' => true,

			/**
			 * Disable WordPress emojis.
			 *
			 * @var bool
			 */
			'disable_emojis' => true,

			/**
			 * Disable Gutenberg block library CSS.
			 *
			 * @var bool
			 */
			'disable_gutenberg_block_css' => true,

			/**
			 * Disable extra RSS feeds.
			 *
			 * @var bool
			 */
			'disable_extra_rss' => true,

			/**
			 * Disable recent comments CSS.
			 *
			 * @var bool
			 */
			'disable_recent_comments_css' => true,

			/**
			 * Disable gallery CSS.
			 *
			 * @var bool
			 */
			'disable_gallery_css' => true,

			/**
			 * Clean HTML5 markup.
			 *
			 * @var bool
			 */
			'clean_html5_markup' => true,
	];

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
			$tasks = [
					'wp_obscurity' => 'wpObscurity',
					'disable_emojis' => 'disableEmojis',
					'disable_gutenberg_block_css' => 'disableGutenbergBlockCss',
					'disable_extra_rss' => 'disableExtraRss',
					'disable_recent_comments_css' => 'disableRecentCommentsCss',
					'disable_gallery_css' => 'disableGalleryCss',
					'clean_html5_markup' => 'cleanHtmlMarkup',
			];

			$enabled_tasks = array_keys(array_filter($this->options->all()));

			foreach ($enabled_tasks as $task) {
				if (isset($tasks[$task])) {
						$this->{$tasks[$task]}();
				}
			}
	}

	/**
	 * Obscure and suppress WordPress information.
	 *
	 * @return void
	 */
	protected function wpObscurity()
	{
			$this->filter('get_bloginfo_rss', 'removeDefaultSiteTagline');
			add_filter('the_generator', '__return_false');
			remove_action('wp_head', 'rsd_link');
			remove_action('wp_head', 'wlwmanifest_link');
			remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
			remove_action('wp_head', 'wp_generator');
			remove_action('wp_head', 'wp_shortlink_wp_head', 10);
			remove_action('wp_head', 'rest_output_link_wp_head', 10);
			remove_action('wp_head', 'wp_oembed_add_discovery_links');
			remove_action('wp_head', 'wp_oembed_add_host_js');
	}

	/**
	 * Disable WordPress emojis.
	 *
	 * @return void
	 */
	protected function disableEmojis()
	{
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('admin_print_scripts', 'print_emoji_detection_script');
			remove_action('wp_print_styles', 'print_emoji_styles');
			remove_action('admin_print_styles', 'print_emoji_styles');
			remove_filter('the_content_feed', 'wp_staticize_emoji');
			remove_filter('comment_text_rss', 'wp_staticize_emoji');
			remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
			add_filter('emoji_svg_url', '__return_false');
	}

	/**
	 * Disable Gutenberg block library CSS.
	 *
	 * @return void
	 */
	protected function disableGutenbergBlockCss()
	{
			add_action('wp_enqueue_scripts', function () {
					wp_dequeue_style('wp-block-library');
			}, 200);
	}

	/**
	 * Disable extra RSS feeds.
	 *
	 * @return void
	 */
	protected function disableExtraRss()
	{
			add_filter('feed_links_show_comments_feed', '__return_false');
			remove_action('wp_head', 'feed_links_extra', 3);
	}

	/**
	 * Disable recent comments CSS.
	 *
	 * @return void
	 */
	protected function disableRecentCommentsCss()
	{
			add_filter('show_recent_comments_widget_style', '__return_false');
	}

	/**
	 * Disable gallery CSS.
	 *
	 * @return void
	 */
	protected function disableGalleryCss()
	{
			add_filter('use_default_gallery_style', '__return_false');
	}

	/**
	 * Clean HTML5 markup.
	 *
	 * @return void
	 */
	protected function cleanHtmlMarkup()
	{
			$this->filter('body_class', 'bodyClass');
			$this->filter('language_attributes', 'languageAttributes');

			$this->filters([
					'get_avatar',          // <img />
					'comment_id_fields',   // <input />
					'post_thumbnail_html', // <img />
			], 'removeSelfClosingTags');

			add_filter('site_icon_meta_tags', function ($meta_tags) {
					return array_map([$this, 'removeSelfClosingTags'], $meta_tags);
			}, 20);
	}

	/**
	 * Clean up language_attributes() used in <html> tag
	 *
	 * Remove dir="ltr"
	 *
	 * @internal Used by `language_attributes`
	 *
	 * @return void
	 */
	public function languageAttributes()
	{
			$attributes = [];

		if (is_rtl()) {
				$attributes[] = 'dir="rtl"';
		}

			$lang = esc_attr(get_bloginfo('language'));

		if ($lang) {
				$attributes[] = "lang=\"{$lang}\"";
		}

			return implode(' ', $attributes);
	}

	/**
	 * Add and remove body_class() classes.
	 *
	 * @internal Used by `body_class`
	 *
	 * @param array $classes
	 * @return array
	 */
	public function bodyClass($classes)
	{
			$remove_classes = [
					'page-template-default'
			];

			// Add post/page slug if not present
			if (is_single() || is_page() && !is_front_page()) {
				if (!in_array($slug = basename(get_permalink()), $classes, true)) {
						$classes[] = $slug;
				}
			}

			if (is_front_page()) {
					$remove_classes[] = 'page-id-' . get_option('page_on_front');
			}

			$classes = array_values(array_diff($classes, $remove_classes));

			return $classes;
	}

	/**
	 * Remove the default site tagline from RSS feed.
	 *
	 * @internal Used by `get_bloginfo_rss`
	 *
	 * @param string $bloginfo
	 * @return string
	 */
	public function removeDefaultSiteTagline($bloginfo)
	{
			$default_tagline = __('Just another WordPress site'); // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
			return ($bloginfo === $default_tagline) ? '' : $bloginfo;
	}

	/**
	 * Remove self-closing tags.
	 *
	 * @internal Used by `get_avatar`, `comment_id_fields`, and `post_thumbnail_html`
	 *
	 * @param string|string[] $html
	 * @return string|string[]
	 */
	public function removeSelfClosingTags($html)
	{
			return str_replace(' />', '>', $html);
	}
}
