<?php

	/* TINYMCE STYLESHEET */
   	add_filter( 'mce_css', 'mau_mce_css' );
	function mau_mce_css($wp) {
		return $wp .= ',' . get_stylesheet_directory_uri() . '/css/tinymce.css';
	}

	/* TINYMCE FORMATS */
	add_filter( 'tiny_mce_before_init', 'mau_tiny_mce_before_init' );
	function mau_tiny_mce_before_init( $init_array ) {
		$init_array['block_formats'] = "Paragraph=p;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5;Pre=pre";
		return $init_array;
	}

	/* REMOVE META BOXES */
	add_action('admin_menu','mau_remove_metaboxes');
	function mau_remove_metaboxes() {
		$mau_rmb_post_types = get_post_types();
		$mau_rmb_boxes = array('postcustom','commentstatusdiv','trackbacksdiv');
		foreach ($mau_rmb_post_types as $mau_rmb_post_type) {
			foreach ($mau_rmb_boxes as $mau_rmb_box) {
				remove_meta_box( $mau_rmb_box, $mau_rmb_post_type,'normal' );
			}
		}
	}

	/* REMOVE DEFAULT DASHBOARD WIDGETS & ADD SUPPORT WIDGET */
	add_action('wp_dashboard_setup', 'mau_custom_dashboard_widgets');
	function mau_custom_dashboard_widgets() {
	   global $wp_meta_boxes;
		//Right Now - Comments, Posts, Pages at a glance
		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	    //Quick Press Form
		//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		//Recent Comments
	    //Recent Drafts List
		//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		//Incoming Links
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		//Plugins - Popular, New and Recently updated Wordpress Plugins
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		//Wordpress Development Blog Feed
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		//Other Wordpress News Feed
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

	}

?>