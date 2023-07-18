<?php

	/* LOAD THEME OPTIONS */
	$options = get_option('startup_theme_options');

	/* MULTIMEDIA */
	add_theme_support( 'html5', array( 'gallery','caption' ) );
	add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size( 210, 350 );
	//add_image_size( 'new-thumbnail', 310, 165, true );

	/* AUTOMATIC FEED LINKS */
	add_theme_support( 'automatic-feed-links' );

	/* L10N */
	load_theme_textdomain( 'startup', get_template_directory() . '/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/* JAVASCRIPT */
	add_action('wp_enqueue_scripts', 'startup_scripts');
	function startup_scripts(){
		wp_enqueue_script('modernizr',  get_template_directory_uri().'/foundation/js/vendor/modernizr.js', '', '5.0', false);
		wp_enqueue_script('fastclick',  get_template_directory_uri().'/foundation/js/vendor/fastclick.js', 'jquery', '5.0', true);
		wp_enqueue_script('foundation', get_template_directory_uri().'/foundation/js/foundation.min.js', array('modernizr','jquery','fastclick'), '5.0', true);
		wp_enqueue_script('startup',    get_template_directory_uri().'/js/app.min.js', array('jquery','foundation'), '1.5', true);
	}

	/* CUSTOM NAVIGATION */
	add_theme_support('nav-menus');
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
				'navbar-menu'       => 'Nav Bar',
				'topbar-menu'		=> 'Top Bar',
				'topbar-menu-right' => 'Top Bar Right',
			)
		);
	}

	/* WIDGET AREAS */
	if ( function_exists('register_sidebar') ) {

		// Header
		register_sidebar(array(
			'name'          => 'Header',
			'id'            => 'header',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		));

		// Sidebar
		register_sidebar(array(
			'name'          => 'Sidebar',
			'id'            => 'sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		));

		// Footer
		$footer_columns = empty( $options['footer_widgets_columns']) ? 1 : $options['footer_widgets_columns'];
		$footer_columns = apply_filters('startup_footer_widgets_columns', $footer_columns);
		$footer_columns = startup_reword_columns( $footer_columns );
		register_sidebar(array(
			'name'          => 'Footer',
			'id'            => 'footer',
			'before_widget' => '<div id="%1$s" class="'.esc_attr($footer_columns).' columns %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		));

		// 404 Page
		register_sidebar(array(
			'name'          => '404 Page',
			'id'            => 'page-404',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		));
	}

	/* BREADCRUMBS */
	add_action('startup_breadcrumbs','startup_breadcrumbs');
	function startup_breadcrumbs(){
		global $post;
		$min_depth = 2;
		if ( ! function_exists('yoast_breadcrumb') || is_home() || is_front_page() )
			return false;
		if ( $min_depth-1 > count(get_post_ancestors($post->ID)) )
			return false;
		yoast_breadcrumb('<div class="breadcrumbs simple">','</div>');
	}

	/* LOGIN LOGO */
   	// add_action('login_head', 'mau_login_logo');
	function mau_login_logo() {
	    echo '<style type="text/css">
	        h1 {display:none}
	        form {
	        background: #fff url('.get_stylesheet_directory_uri().'/images/login-logo.jpg) center -10px no-repeat !important;
	        padding-top:100px !important;
	        }
	    </style>';
	}

	/* EMAIL ADDRESS */
	//add_filter('wp_mail_from','mau_mail_from');
	//add_filter('wp_mail_from_name','mau_mail_from_name');
	function mau_mail_from($old) {return 'startup@grafique.cz';}
	function mau_mail_from_name($old) {return '$tArt▲p';}

	/* BODY CLASS */
	add_filter('body_class','startup_body_class');
	function startup_body_class($classes){
		if ( has_nav_menu( 'topbar-menu' ) || has_nav_menu( 'topbar-menu-right' ) )
			$classes[] = 'topbar-menu';
		return $classes;
	}
?>