<?php

/* SHARED */

	/* Shared Helpers */
	include_once('inc/helpers.php');

	/* Basic Theme Setup */
	# post-thumbnails, feed-links, l10n, scripts, nav-menus
	# widget areas, breadcrumbs, login logo, body class
	include_once('inc/init.php');

	/* Security */
	# version reporting
	include_once('inc/security.php');

		/* Theme Customizer */
		include_once('inc/customizer.php');

/* ADMIN ONLY */

if ( is_admin() ) {

	/* Admin Tweaks */
	# comments, menu items, e-mail address, admin & editor stylesheets,
	# tinymce stylesheet, tinymce format
	# footer, metaboxes, dashboard widgets
	include_once('inc/admin.php');


/* FRONT-END ONLY */

} else {

	/* Layout, Sidebar, Columns, Masonry */
	include_once('inc/layout.php');

	/* Featured Slider */
	include_once('inc/slider_init.php');

	/* Custom Pagination */
	include_once('inc/pagination.php');

	/* Extra Utils & Helpers */
	# custom excerpt
	include_once('inc/utils.php');

	/* Shortcodes */
	include_once('inc/shortcodes.php');


}
