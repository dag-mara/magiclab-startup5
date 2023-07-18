<?php

	/* MAIN LAYOUT COLUMNS */
	add_action('startup_columns_class','startup_columns_class');
	function startup_columns_class( $is_sidebar=false ){

		$options    = get_option('startup_theme_options');
		$columns    = array('columns');
		$side_width = isset( $options['sidebar_width'] ) ? $options['sidebar_width'] : 4;
		$side_width = $options['sidebar_active'] ? $side_width : 0;
		$main_width = 12 - (int) $side_width;

		$columns[] = $is_sidebar ? 'medium-'.$side_width : 'medium-'.$main_width;

		if ( $is_sidebar ) {
			$columns[] = $options['sidebar_after'] ? 'sidebar-after' : 'sidebar-before';
			$columns[] = $options['sidebar_left']  ? 'sidebar-left'  : 'sidebar-right';
		}

		if ( $options['sidebar_after'] && $options['sidebar_left'] )
			$columns[] = $is_sidebar ? 'pull-'.$main_width : 'push-'.$side_width ;
		elseif ( ! $options['sidebar_after'] && ! $options['sidebar_left'] )
			$columns[] = $is_sidebar ? 'push-'.$main_width : 'pull-'.$side_width ;

		echo join( ' ', apply_filters( 'startup_columns',  $columns, $is_sidebar ) );
	}

	/* SIDEBAR */
	add_action('startup_sidebar','startup_sidebar');
	function startup_sidebar( $location = 'footer' ) {
		$options  = get_option('startup_theme_options');
		if ( ! $options['sidebar_active'] )
			return false;
		if ( 'header' == $location && ! $options['sidebar_after'] ||
			 'footer' == $location &&   $options['sidebar_after']
		) get_sidebar();
	}

	/* HOOK UP CUSTOMIZER */
	add_action('template_redirect', 'startup_customize_layout');
	function startup_customize_layout(){

		$pt = startup_get_current_post_type();
		if ( ! $pt ) return;

		if ( startup_get_archive_option('cols',$pt) > 1 ) :

			/* grid markup */
			add_filter( 'post_class', 'startup_post_columns' );
			add_action( 'startup_archive_before_loop', 'startup_archive_before_loop' );
			add_action( 'startup_archive_after_loop', 'startup_archive_after_loop' );

			/* masonry */
			if ( startup_get_archive_option( 'masonry', $pt ) )
				add_action( 'wp_enqueue_scripts', 'startup_masonry_script' );

		endif;

		/* remove date? */
		$date_filter = startup_get_archive_option( 'date', $pt ) ? '__return_false':'startup_date_wrap';
		add_filter( 'get_the_date', $date_filter );


		add_action('startup_thumbnail','startup_thumbnail');
		add_action('startup_title','startup_title');
		add_action('startup_content','startup_content');


	}

	function startup_get_current_post_type(){

		if ( is_post_type_archive() ) {
			return get_query_var('post_type');
		}

		if ( is_category() ) {
			return 'category';
		}

		if ( is_tag() ) {
			return 'post_tag';
		}

		if ( is_tax() ) {
			return get_query_var('taxonomy');
		}

		return false;

		// $options = get_option('startup_theme_options');
		// if ( ! isset($options['archives']) || empty($options['archives'][$tax]) ) {
			// return false;
		// }
		// var_dump($options['archives']);die;
		// return reset( array_flip( $options['archives'][$tax] ) );

	}

	/* NAV BAR MENU */

		add_action('startup_nav_bar','startup_nav_bar');
		function startup_nav_bar(){

			if ( ! has_nav_menu( 'navbar-menu' ) )
				return false;

			wp_nav_menu( array(
				'theme_location'  => 'navbar-menu',
				'container'       => 'nav',
				'menu_class'      => 'nav-bar',
			) );

		}



	/* TOP BAR MENU */

		add_action('startup_top_bar', 'startup_top_bar');
		function startup_top_bar(){
			if ( ! has_nav_menu( 'topbar-menu' ) && ! has_nav_menu( 'topbar-menu-right' ) )
				return false;
			$options    = get_option('startup_theme_options');
			$fixed      = isset($options['topbar']['fixed']) && $options['topbar']['fixed'];
			$sticky     = isset($options['topbar']['sticky']) && $options['topbar']['sticky'];
			$menu_title = __( apply_filters('startup_top_bar_menu_title', 'Menu' ), 'startup' );
			if ( $sticky ) echo '<div class="sticky">';
			elseif ( $fixed ) echo '<div class="fixed">';
			?>
				<nav class="top-bar" data-topbar >
					<ul class="title-area">
						<li class="name">
							<?php echo startup_logo(); ?>
							<h1><a href="<?php echo site_url(); ?>"><?php echo wp_kses(apply_filters('startup_topbar_site_title', get_bloginfo('title')),array('span'=>array('class'=>true))); ?></a></h1>
						</li>
						<li class="toggle-topbar menu-icon"><a href="#"><span><?php echo $menu_title ?></span></a></li>
					</ul>
				  <section class="top-bar-section">
					<?php wp_nav_menu( array(
							'theme_location' => 'topbar-menu',
							'menu_class'     => 'left',
							'container'      => false,
							'walker'         => new StartUp_Walker_TopBar()
						) ); ?>
				    <?php wp_nav_menu( array(
							'theme_location' => 'topbar-menu-right',
							'menu_class'     => 'right',
							'container'      => false,
							'walker'         => new StartUp_Walker_TopBar()
						) ); ?>
				  </section>
				</nav>
			<?php
			if ( $sticky || $fixed ) echo '</div>';
		}


		class StartUp_Walker_TopBar extends Walker_Nav_Menu {
			/**
			 * @see Walker::start_lvl()
			 * @since 3.0.0
			 *
			 * @param string $output Passed by reference. Used to append additional content.
			 * @param int $depth Depth of page. Used for padding.
			 */
			function start_lvl( &$output, $depth = 0, $args = array() ) {
				$indent = str_repeat("\t", $depth);
				$output .= "\n$indent<ul class=\"dropdown\">\n";
			}
		}

		add_filter( 'wp_nav_menu_objects', 'startup_add_menu_parent_class' );
		function startup_add_menu_parent_class( $items ) {

			$parents = array();
			foreach ( $items as $item )
				if ( $item->menu_item_parent && $item->menu_item_parent > 0 )
					$parents[] = $item->menu_item_parent;

			foreach ( $items as $item )
				if ( in_array( $item->ID, $parents ) )
					$item->classes[] = 'has-dropdown';

			return $items;
		}


	/* HEADER TITLE / LOGO */
	add_action('startup_header_title','startup_header_title');
	function startup_header_title(){

		$out = '<h1><a href="'.get_site_url().'">'.get_bloginfo('title').'</a></h1>';

		$desc = get_bloginfo('description');
		if ( '' != $desc )
			$out = '<hgroup>'.$out.'<h4 class="subheader">'.$desc.'</h4></hgroup>';

		echo $out;

	}
	add_action('startup_header_logo','startup_header_logo');
	function startup_header_logo(){
		echo startup_logo();
	}

	function startup_logo( $linked = true ) {

		$options = get_option('startup_theme_options');
		$logo	 = esc_url( apply_filters( 'startup_logo', isset($options['logo']) ? $options['logo'] : '' ) );
		if ( '' == $logo)
			return false;

		//$size    = getimagesize($logo);
		$title   = get_bloginfo('title');
		$href	 = get_home_url();
		$logo    = "<img src='$logo' alt='$title Logo' />";

		if ( $linked )
			$logo = "<a class='site-logo' href='$href' title='$title'>$logo</a>";

		return $logo;
	}

	function startup_title(){
		global $post;
		$pt = startup_get_current_post_type();
		if ( ! $pt ) return false;
		if ( ! startup_get_archive_option( 'title', $pt ) )
			echo '<h2><a href="'.get_permalink($post->ID).'" rel="bookmark">'.get_the_title($post->ID).'</a></h2>';
	}


	function startup_content(){
		global $post;
		$pt = startup_get_current_post_type();
		if ( ! $pt ) return false;
		$length = startup_get_archive_option( 'content', $pt );
		if (  0   == $length ) return '';
		if (  999 == $length ) the_content();
		else echo mau_get_the_excerpt($post->ID,$length,'&nbsp;<a href="'.get_permalink($post->ID).'">[...]</a>');
	}

	function startup_thumbnail(){
		$pt = startup_get_current_post_type();
		if ( ! $pt ) return;
		$size = startup_get_archive_option( 'thumbs', $pt );
		if ( ! $size )
			return '';
		echo '<a class="thumb-link" href="'.get_permalink().'">';
		the_post_thumbnail($size);
		echo '</a>';
	}

	function startup_date_wrap($date){
		return '<span class="date">'.$date.'</span>';
	}

	function startup_post_columns($classes){

		$pt = startup_get_current_post_type();
		if ( ! $pt ) return;

		$classes[] = startup_reword_columns( startup_get_archive_option('cols',$pt) );
		$classes[] = 'columns';

		if ( startup_get_archive_option('masonry',$pt) )
			$classes[] = 'startup-maso-item';

		return $classes;
	}

	function startup_masonry_script(){
		$pt = startup_get_current_post_type();
		if ( ! $pt ) return;
		$columns = startup_get_archive_option('cols',$pt);
		wp_enqueue_script('masonry', get_template_directory_uri().'/js/jquery.masonry.min.js', 'jquery', '1.0', true);
		wp_localize_script('startup', 'su_masonry', array('columns'=>$columns) );
	}

	/* Wrap with grid row if needed */
	function startup_archive_before_loop(){
		$pt = startup_get_current_post_type();
		if ( ! $pt ) return;
		$id = startup_get_archive_option('masonry',$pt) ? "id='startup-maso'":"";
		echo "<div class='row' $id >";
	}
	function startup_archive_after_loop(){
		echo "</div>";
	}

	/* Get Archives Options */
	function startup_get_archive_option($option,$post_type='post'){
		$options = get_option('startup_theme_options');
		if ( ! isset( $options['archives'][$post_type][$option] ) )
			return null;
		return  $options['archives'][$post_type][$option];
	}

?>