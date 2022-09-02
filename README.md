# WP Abettor

## Installing

Install & activate via composer.

## Functions

_Activate functionality by adding these commands to your functions.php:_

- **Hide default dashboard widgets on the back-end**<br>
  `add_theme_support('abet-clean-admin-dashboard');`

- **Add a fixed position emblem & modifies favicon to differentiate development sites from production sites** (Requires get_env)<br>
  `add_theme_support('abet-demarcate-development');`

- **Disable the admin bar on the front-end**<br>
  `add_theme_support('abet-disable-admin-bar');`

- **Turn off comments and related options and widgets in the back-end interface**<br>
  `add_theme_support('abet-disable-comments');`

- **Disable Yoast SEO columns for posts and pages on the back-end interface**<br>
  `add_theme_support('abet-disable-yoast-admin-columns');`

- **Set default settings for Gravity Forms: HTML5 output on & CSS output off**<br>
  `add_theme_support('abet-gravity-forms-setup');`

- **Move Gravity Forms injected scripts to the footer**<br>
  `add_theme_support('abet-gravity-forms-to-footer');`

- **Remove cruft from text when pasting into the TinyMCE editor**<br>
  `add_theme_support('abet-tinymce-clean-paste');`

- **Removes the back-end admin top bar from larger screens**<br>
  `add_theme_support('abet-disable-backend-admin-bar');`

- **Adds a View Site link to the admin sidebar**<br>
  `add_theme_support('abet-add-view-site-admin-sidebar');`

- **Adds a Logout link to the admin sidebar**<br>
  `add_theme_support('abet-add-add-logout-link-admin-sidebar');`

- **Cleaner WordPress markup**<br>
  `add_theme_support('abet-clean-up');`

- **Disable REST API**<br>
  `add_theme_support('abet-disable-rest-api');`

- **Disable asset versioning**<br>
  `add_theme_support('abet-disable-asset-versioning');`

- **Disable trackbacks**<br>
  `add_theme_support('abet-disable-trackbacks');`

- **Convert search results from `/?s=query` to `/search/query/`**<br>
  `add_theme_support('abet-nice-search');`

## WIP - not yet tested

- **Default WP Setup**<br>
  `add_theme_support('abet-default-setup');`

- **Relevanssi & Yoast SEO compatibility - may no longer be needed**<br>
  `add_theme_support('abet-relevanssi-remove-meta');`

## Credits

This project is forked from [Roots Soil](https://github.com/roots/soil/).

## License

This project is licensed under the [GPLv2](https://github.com/thinknathan/wp-abettor/blob/master/LICENSE.txt) or any later version.
