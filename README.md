# WP Abettor

## Installing

Install & activate like any WordPress plugin.

## Functions

*Activate functionality by adding these commands to your functions.php:*

Hide default dashboard widgets on the back-end
`add_theme_support('abet-clean-admin-dashboard');`

Add a fixed position emblem & modifies favicon to differentiate development sites from production sites
Requires get_env
`add_theme_support('abet-demarcate-development');`

Disable the admin bar on the front-end
`add_theme_support('abet-disable-admin-bar');`

Turn off comments and related comments in the back-end interface
`add_theme_support('abet-disable-comments');`

Disable Yoast SEO columns for posts and pages on the back-end interface
`add_theme_support('abet-disable-yoast-admin-columns');`

Set default settings for Gravity Forms: HTML5 output on & CSS output off
`add_theme_support('abet-gravity-forms-setup');`

Move Gravity Forms injected scripts to the footer
`add_theme_support('abet-gravity-forms-to-footer');`

Remove cruft from text when pasting into the TinyMCE editor
`add_theme_support('abet-tinymce-clean-paste');`
