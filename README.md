# WP Abettor

A WordPress plugin which contains a collection of modules to apply theme-agnostic front-end modifications.

## Requirements

<table>
  <thead>
    <tr>
      <th>Prerequisite</th>
      <th>How to check</th>
      <th>How to install</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>PHP &gt;= 5.6.x</td>
      <td><code>php -v</code></td>
      <td>
        <a href="http://php.net/manual/en/install.php">php.net</a>
      </td>
    </tr>
  </tbody>
</table>

## Installation

You can install this plugin via composer or the WordPress admin panel.

### via WordPress Admin Panel

1. Download the latest zip of this repo.
2. In your WordPress admin panel, navigate to Plugins->Add New
3. Click Upload Plugin
4. Upload the zip file that you downloaded.

## Newly Added Modules

- **Disable the admin bar on the front-end**<br>
  `add_theme_support('abettor', 'disable-admin-bar');`

- **Turn off comments and related options and widgets in the back-end interface**<br>
  `add_theme_support('abettor', 'disable-comments');`

- **Logs enqueued scripts and stylesheets to the browser console** (Requires get_env)<br>
  `add_theme_support('abettor', 'console-log-enqueue');`

- **Adds a Logout link to the admin sidebar**<br>
  `add_theme_support('abettor', 'add-logout-link-admin-sidebar');`

- **Adds a View Site link to the admin sidebar**<br>
  `add_theme_support('abettor', 'add-view-site-admin-sidebar');`

- **Remove cruft from text when pasting into the TinyMCE editor**<br>
  `add_theme_support('abettor', 'tinymce-clean-paste');`

- **Removes the back-end admin top bar from larger screens**<br>
  `add_theme_support('abettor', 'disable-backend-admin-bar');`

- **Hide default dashboard widgets on the back-end**<br>
  `add_theme_support('abettor', 'clean-admin-dashboard');`

- **Set default settings for Gravity Forms: CSS output off**<br>
  `add_theme_support('abettor', 'gravity-forms-setup');`

- **Add a fixed position emblem & modifies favicon to differentiate development sites from production sites** (Requires get_env)<br>
  `add_theme_support('abettor', 'demarcate-development');`

## Modules

- **Cleaner WordPress markup**<br>
  `add_theme_support('abettor', 'clean-up');`

- **Disable REST API**<br>
  `add_theme_support('abettor', 'disable-rest-api');`

- **Disable asset versioning**<br>
  `add_theme_support('abettor', 'disable-asset-versioning');`

- **Disable trackbacks**<br>
  `add_theme_support('abettor', 'disable-trackbacks');`

- **Move all JS to the footer**<br>
  `add_theme_support('abettor', 'js-to-footer');`

- **Convert search results from `/?s=query` to `/search/query/`**<br>
  `add_theme_support('abettor', 'nice-search');`

- **Root relative URLs**<br>
  `add_theme_support('abettor', 'relative-urls');`

And in a format you can copy & paste into your theme:

```php
/**
 * Enable features from WP Abettor when plugin is activated
 * @link https://github.com/thinknathan/wp-abettor/
 */
add_theme_support('abettor', [
    'clean-up',
    'disable-rest-api',
    'disable-asset-versioning',
    'disable-trackbacks',
    'js-to-footer',
    'nice-search',
    'relative-urls'
]);
```

### Module options

<details>
<summary>Full annotated list of features and options</summary>

```php

/**
 * Enable features from WP Abettor when plugin is activated
 * @link https://github.com/thinknathan/wp-abettor/
 */
add_theme_support('abettor', [
    /**
     * Clean up WordPress
     */
    'clean-up' => [
        /**
         * Obscure and suppress WordPress information.
         */
        'wp_obscurity',

        /**
         * Disable WordPress emojis.
         */
        'disable_emojis',

        /**
         * Disable Gutenberg block library CSS.
         */
        'disable_gutenberg_block_css',

        /**
         * Disable extra RSS feeds.
         */
        'disable_extra_rss',

        /**
         * Disable recent comments CSS.
         */
        'disable_recent_comments_css',

        /**
         * Disable gallery CSS.
         */
        'disable_gallery_css',

        /**
         * Clean HTML5 markup.
         */
        'clean_html5_markup',
    ],

    /**
     * Disable WordPress REST API
     */
    'disable-rest-api',

    /**
     * Remove version query string from all styles and scripts
     */
    'disable-asset-versioning',

    /**
     * Disables trackbacks/pingbacks
     */
    'disable-trackbacks',

    /**
     * Moves all scripts to wp_footer action
     */
    'js-to-footer',

    /**
     * Redirects search results from /?s=query to /search/query/, converts %20 to +
     *
     * @link http://txfx.net/wordpress-plugins/nice-search/
     */
    'nice-search',

    /**
     * Convert absolute URLs to relative URLs
     *
     * Inspired by {@link https://web.archive.org/web/20180529232418/http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/}
     */
    'relative-urls',
]);
```

</details>

## Credits

This project is forked from [Roots Soil](https://github.com/roots/soil/).

## License

This project is licensed under the [GPLv2](https://github.com/thinknathan/wp-abettor/blob/master/LICENSE.txt) or any later version.
