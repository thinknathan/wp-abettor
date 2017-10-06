<?php
/**
 * Hides front-end admin bar for all users.
 */

namespace Think_Nathan\Abettor\DisableAdminBar;

add_action( 'show_admin_bar', '__return_false' );
