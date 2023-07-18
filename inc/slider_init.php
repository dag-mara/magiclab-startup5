<?php

	/* Featured Slider */
	add_action('startup_feat_slider','startup_feat_slider');
	function startup_feat_slider(){

		$opt = get_option('startup_theme_options');

		// active check
		if ( empty($opt['featured_slider']['active']) )
			return;

		// home only check
		if ( ( ! is_home() && ! is_front_page() ) && ! empty( $opt['featured_slider']['honly'] ) )
			return;

		// pass orbit js options to the app.js
		// @TODO NOT NEEDED?
		// $orbit_options = ! empty( $opt['featured_slider']['orbit'] ) ? $opt['featured_slider']['orbit'] : array();
		// wp_localize_script( 'startup', 'featured_slider', array_map( 'startup_numboo',$orbit_options ) );

		// generate args for query
		add_filter('startup_feat_slider_args','startup_feat_slider_args');

		// generate and output markup
		get_template_part('inc/featured');
	}

	function startup_numboo($val){
		if ( 0 === $val ) return null;
		else return $val;
	}

	function startup_feat_slider_args(){

		$opt = get_option('startup_theme_options');

		if ( ! empty( $opt['featured_slider']['use_page'] ) ) {
			global $post;
			if ( isset($post->ID) ) {
				return array('parent'=>5,'post_type'=>'attachment','post_status'=>'inherit','nopaging'=>true,'order'=>'ASC','orderby'=>'menu_order');
			}
		}

		// override with mau featured if asked to
		if ( ! empty( $opt['featured_slider']['use_mf'] ) && class_exists( 'mauFeatured' ) ) {
			return array(
				'meta_key'         => '_mau_feat_order',
				'orderby'          => '_mau_feat_order',
				'order'            => 'ASC',
				'post_type'        => 'any',
				'nopaging'         => true,
				'suppress_filters' => false
			);
		}

		$pt = ! empty( $opt['featured_slider']['post_type'] ) ? $opt['featured_slider']['post_type'] : 'post';
		return array( 'post_type' => $pt );
	}

	function startup_orbit_options() {
		$out = '';
		$opt = get_option('startup_theme_options');
		$orbit_options = ! empty( $opt['featured_slider']['orbit'] ) ? $opt['featured_slider']['orbit'] : array();
		$options = apply_filters('startup_orbit_options',$orbit_options);
		foreach ( $options as $key => $val ) {
			if ( is_bool($val) )
				$val = $val ? 'true' : 'false';
			$out .= $key.':'.$val.';';
		}
		echo ' data-options="'.$out.'" ';
	}

 ?>