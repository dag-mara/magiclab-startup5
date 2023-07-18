<?php


	function startup_customize_register( $wp_customize ) {

		/* NAVIGATION SECTION */

			/* Fixed Top Bar */
			$wp_customize->add_setting( 'startup_theme_options[topbar][fixed]', array(
				'default'           => 1,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			) );

			$wp_customize->add_control( 'startup_topbar_fixed', array(
				'label'    => __( 'Top Bar Fixed', 'startup' ),
				'section'  => 'nav',
				'settings' => 'startup_theme_options[topbar][fixed]',
				'type'     => 'checkbox',
			) );

			/* Sticky Top Bar */
			$wp_customize->add_setting( 'startup_theme_options[topbar][sticky]', array(
				'default'           => 1,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			) );

			$wp_customize->add_control( 'startup_topbar_sticky', array(
				'label'    => __( 'Top Bar Sticky', 'startup' ),
				'section'  => 'nav',
				'settings' => 'startup_theme_options[topbar][sticky]',
				'type'     => 'checkbox',
			) );


		/* ARCHIVES SECTION */
			$section_panel = '';
			if ( method_exists($wp_customize, 'add_panel') ) {
				$section_panel = 'startup_archives';
				$wp_customize->add_panel($section_panel, array(
					'title'    => __('Archives', 'startup'),
					'priority' => 300,
				));
			}
			$i=0;
			$post_types = array('post'=>__('Posts')) + startup_get_post_types_array(array('public'=>true,'has_archive'=>true));
			//$taxonomies = startup_get_taxonomies_array();
			//$post_types = array('home'=>'Index')+$post_types + $taxonomies;

			foreach( $post_types as $pt => $label ) : $i++;

				$wp_customize->add_section( "startup_archives_$pt", array(
					'title'          => $label,
					'priority'       => 300+$i,
					'capability'	 => 'update_core',
					'panel'			 => $section_panel,
				) );

				/* Columns */
				$wp_customize->add_setting( "startup_theme_options[archives][$pt][cols]", array(
					'default'           => 1,
					'type'              => 'option',
					'capability'        => 'update_core',
					'sanitize_callback' => 'absint',
				) );
				$wp_customize->add_control( 'startup_archives_'.$pt.'_cols', array(
					'label'    => __( 'Layout', 'startup' ).':',
					'section'  => "startup_archives_$pt",
					'settings' => "startup_theme_options[archives][$pt][cols]",
					'type'     => 'select',
					'priority' => 10,
					'choices'  => array(
						1 => __( 'One column', 'startup' ),
						2 => __( 'Two columns', 'startup' ),
						3 => __( 'Three columns', 'startup' ),
						4 => __( 'Four columns', 'startup' ),
					),
				) );

				/* Masonry */
				$wp_customize->add_setting( "startup_theme_options[archives][$pt][masonry]", array(
					'default'    => 0,
					'type'       => 'option',
					'capability' => 'update_core',
				) );
				$wp_customize->add_control( 'startup_archives_'.$pt.'_masonry', array(
					'label'    => __( 'Activate Masonry (beta)', 'startup' ),
					'section'  => "startup_archives_$pt",
					'settings' => "startup_theme_options[archives][$pt][masonry]",
					'type'     => 'checkbox',
					'priority' => 20,
				) );

				/* Images */
				$wp_customize->add_setting( "startup_theme_options[archives][$pt][thumbs]", array(
					'default'           => 0,
					'type'              => 'option',
					'capability'        => 'update_core',
				) );
				$wp_customize->add_control( 'startup_archives_'.$pt.'_thumbs', array(
					'label'    => __( 'Thumbnails', 'startup' ).':',
					'section'  => "startup_archives_$pt",
					'settings' => "startup_theme_options[archives][$pt][thumbs]",
					'type'     => 'select',
					'choices'  => startup_get_sizes_array(),
					'priority' => 30,
				) );

				/* Content */
				$wp_customize->add_setting( "startup_theme_options[archives][$pt][content]", array(
					'default'           => 25,
					'type'              => 'option',
					'capability'        => 'update_core',
				) );
				$wp_customize->add_control( 'startup_archives_'.$pt.'_content', array(
					'label'    => __( 'Text', 'startup' ).':',
					'section'  => "startup_archives_$pt",
					'settings' => "startup_theme_options[archives][$pt][content]",
					'type'     => 'select',
					'priority' => 40,
					'choices'  => array(
						0   => __('No Content','startup'),
						10  => '10 '.__('words'),
						25  => '25 '.__('words'),
						50  => '50 '.__('words'),
						75  => '75 '.__('words'),
						100 => '100 '.__('words'),
						999 => __('Full Content'),
					),
				) );

				/* Hide Date */
				$wp_customize->add_setting( "startup_theme_options[archives][$pt][date]", array(
					'default'    => 0,
					'type'       => 'option',
					'capability' => 'update_core',
				) );
				$wp_customize->add_control( 'startup_archives_'.$pt.'_date', array(
					'label'    => __( 'Hide Date', 'startup' ),
					'section'  => "startup_archives_$pt",
					'settings' => "startup_theme_options[archives][$pt][date]",
					'type'     => 'checkbox',
					'priority' => 50,
				) );

				/* Hide Title */
				$wp_customize->add_setting( "startup_theme_options[archives][$pt][title]", array(
					'default'    => 0,
					'type'       => 'option',
					'capability' => 'update_core',
				) );
				$wp_customize->add_control( 'startup_archives_'.$pt.'_title', array(
					'label'    => __( 'Hide Title', 'startup' ),
					'section'  => "startup_archives_$pt",
					'settings' => "startup_theme_options[archives][$pt][title]",
					'type'     => 'checkbox',
					'priority' => 60,
				) );

				/* Taxonomies */
				foreach ( startup_get_taxonomies_for_pt($pt) as $tax => $name ) {
					$wp_customize->add_setting( "startup_theme_options[archives][$tax][$pt]", array(
						'default'           => 1,
						'type'              => 'option',
						'capability'        => 'update_core',
					) );
					$wp_customize->add_control( 'startup_archives_'.$pt.'_'.$tax, array(
						'label'    => __( 'Apply to', 'startup' ).' "'.$name.'"',
						'section'  => "startup_archives_$pt",
						'settings' => "startup_theme_options[archives][$tax][$pt]",
						'type'     => 'checkbox',
						'priority' => 70,
					) );
				}


			endforeach;



		/* SIDEBAR SETTINGS SECTION */

			$wp_customize->add_section( 'startup_featured_general', array(
				'title'          => __( 'Sidebar', 'startup' ),
				'priority'       => 200,
				'capability'	 => 'update_core',
			) );
			/* sidebar active */
			$wp_customize->add_setting( 'startup_theme_options[sidebar_active]', array(
				'default'           => 1,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( 'startup_featured_sidebar', array(
				'label'    => __( 'Enable Sidebar','startup' ),
				'section'  => 'startup_featured_general',
				'settings' => 'startup_theme_options[sidebar_active]',
				'type'     => 'checkbox',
			) );

			/* sidebar position */
			$wp_customize->add_setting( 'startup_theme_options[sidebar_left]', array(
				'default'           => 0,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			) );

			$wp_customize->add_control( 'startup_featured_sidebar_left', array(
				'label'    => __( 'Sidebar Position','startup' ),
				'section'  => 'startup_featured_general',
				'settings' => 'startup_theme_options[sidebar_left]',
				'type'     => 'select',
				'choices'  => array(
					0 => __( 'Right', 'startup'),
					1 => __( 'Left', 'startup')
				),
			) );

			$wp_customize->add_setting( 'startup_theme_options[sidebar_after]', array(
				'default'           => 1,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			) );

			$wp_customize->add_control( 'startup_featured_sidebar_after', array(
				'label'    => __( 'Sidebar Position','startup' ),
				'section'  => 'startup_featured_general',
				'settings' => 'startup_theme_options[sidebar_after]',
				'type'     => 'select',
				'choices'  => array(
					0 => __( 'Before Content', 'startup'),
					1 => __( 'After Content', 'startup')
				),
			) );

			/* sidebar width */
			$wp_customize->add_setting( 'startup_theme_options[sidebar_width]', array(
				'default'           => 4,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'startup_sanitize_columns',
			) );

			$wp_customize->add_control( 'startup_featured_sidebar_width', array(
				'label'    => __( 'Sidebar Width','startup' ),
				'section'  => 'startup_featured_general',
				'settings' => 'startup_theme_options[sidebar_width]',
				'type'     => 'select',
				'choices'  => array(
					2 => '2 '.__( 'Columns', 'startup'),
					3 => '3 '.__( 'Columns', 'startup'),
					4 => '4 '.__( 'Columns', 'startup'),
					5 => '5 '.__( 'Columns', 'startup'),
					6 => '6 '.__( 'Columns', 'startup'),
				),
			) );


		/* FEATURED SLIDER SECTION */

			$i=1;
			$wp_customize->add_section( 'startup_featured_slider', array(
				'title'          => __( 'Slider', 'startup' ),
				'priority'       => 190,
				'capability'	 => 'update_core',
			) );

			/* active */
			$wp_customize->add_setting( 'startup_theme_options[featured_slider][active]', array(
				'default'           => 0,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( 'startup_featured_slider_active', array(
				'label'    => __( 'Active','startup' ),
				'section'  => 'startup_featured_slider',
				'settings' => 'startup_theme_options[featured_slider][active]',
				'type'     => 'checkbox',
				'priority' => ++$i,
			) );

			/* home only */
			$wp_customize->add_setting( 'startup_theme_options[featured_slider][honly]', array(
				'default'           => 0,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			) );

			$wp_customize->add_control( 'startup_featured_slider_honly', array(
				'label'    => __( 'Homepage Only.','startup' ),
				'section'  => 'startup_featured_slider',
				'settings' => 'startup_theme_options[featured_slider][honly]',
				'type'     => 'checkbox',
				'priority' => ++$i,
			) );

			/* ratio */
			$wp_customize->add_setting( 'startup_theme_options[featured_slider][orbit][ratio]', array(
				'default'           => '16x6',
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'startup_sanitize_ratio',
				//'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( 'startup_featured_slider_rat', array(
				'label'    => __( 'Slider Ratio: (e.g. 4x3)','startup' ),
				'section'  => 'startup_featured_slider',
				'settings' => 'startup_theme_options[featured_slider][orbit][ratio]',
				'type'     => 'text',
				'priority' => ++$i,
			) );

			/* orbit options */
			$orbit_options = array(
				array('animation','Animation','fade','select',startup_get_animations(),'startup_sanitize_animation'),
				array('animation_speed','Animation Speed (ms)',1000,'text'),
				array('timer_speed','Advance Speed (ms)',5000,'text'),
				array('bullets','Bullets',1),
				array('navigation_arrows','Arrows',0),
				array('timer','Timer',1),
				array('pause_on_hover','Pause on Hover',1),
			);
			foreach ( $orbit_options as $opt ) :

				$wp_customize->add_setting( 'startup_theme_options[featured_slider][orbit]['.$opt[0].']', array(
					'default'           => $opt[2],
					'type'              => 'option',
					'capability'        => 'update_core',
					'sanitize_callback' => isset($opt[5]) ? $opt[5] : 'absint',
					//'transport'         => 'postMessage',
				));

				$wp_customize->add_control( 'startup_featured_slider_'.$opt[0], array(
					'label'    => __( $opt[1],'startup' ),
					'section'  => 'startup_featured_slider',
					'settings' => 'startup_theme_options[featured_slider][orbit]['.$opt[0].']',
					'type'     => isset($opt[3]) ? $opt[3] : 'checkbox',
					'choices'  => isset($opt[4]) ? $opt[4] : array(),
					'priority' => ++$i,
				));

			endforeach;

			/* post type */
			$wp_customize->add_setting('startup_theme_options[featured_slider][post_type]', array(
			    'default'    => 'post',
			    'capability' => 'update_core',
			    'type'       => 'option',

			));
			$wp_customize->add_control( 'startup_featured_slider_pts', array(
			    'settings' => 'startup_theme_options[featured_slider][post_type]',
			    'label'   => __('Feed with post type:','startup'),
			    'section' => 'startup_featured_slider',
			    'type'    => 'select',
			    'choices' => startup_get_post_types_array(),
			    'priority' => ++$i,
			));

			/* override with attachments */
			$wp_customize->add_setting( 'startup_theme_options[featured_slider][use_page]', array(
				'default'           => 0,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			));
			$wp_customize->add_control( 'startup_featured_slider_use_page', array(
				'label'    => __( 'Override with Attachments','startup' ),
				'section'  => 'startup_featured_slider',
				'settings' => 'startup_theme_options[featured_slider][use_page]',
				'type'     => 'checkbox',
				'priority' => ++$i,
			));

			/* override with mau featured */
			if ( class_exists('mauFeatured') ) :
				$wp_customize->add_setting( 'startup_theme_options[featured_slider][use_mf]', array(
					'default'           => 0,
					'type'              => 'option',
					'capability'        => 'update_core',
					'sanitize_callback' => 'absint',
				) );
				$wp_customize->add_control( 'startup_featured_slider_use_mf', array(
					'label'    => __( 'Override with Mau Featured','startup' ),
					'section'  => 'startup_featured_slider',
					'settings' => 'startup_theme_options[featured_slider][use_mf]',
					'type'     => 'checkbox',
					'priority' => ++$i,
				) );
			endif; // class_exists mauFeatured

			/* link to post */
			$wp_customize->add_setting( 'startup_theme_options[featured_slider][link_to]', array(
				'default'           => 0,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'absint',
			));
			$wp_customize->add_control( 'startup_featured_slider_link_to', array(
				'label'    => __( 'Link to post','startup' ),
				'section'  => 'startup_featured_slider',
				'settings' => 'startup_theme_options[featured_slider][link_to]',
				'type'     => 'checkbox',
				'priority' => ++$i,
			));

			/* Logo */
			$wp_customize->add_setting('startup_theme_options[logo]', array(
				'default'    => '',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			));

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'startup_site_logo', array(
			    'label'    => __('Site Logo', 'themename'),
			    'section'  => 'title_tagline',
			    'settings' => 'startup_theme_options[logo]',
			)));

		/* FOOTER SETTINGS SECTION */

			$wp_customize->add_section( 'startup_footer', array(
				'title'          => __( 'Footer', 'startup' ),
				'priority'       => 210,
				'capability'	 => 'update_core',
			) );

			/* footer widgets columns */
			$wp_customize->add_setting( 'startup_theme_options[footer_widgets_columns]', array(
				'default'           => 3,
				'type'              => 'option',
				'capability'        => 'update_core',
				'sanitize_callback' => 'startup_sanitize_columns',
			) );
			$wp_customize->add_control( 'startup_footer_widget_columns', array(
				'label'    => __( 'Footer Widgets Layout','startup' ),
				'section'  => 'startup_footer',
				'settings' => 'startup_theme_options[footer_widgets_columns]',
				'type'     => 'select',
				'choices'  => array(
					1  => '1 '. __( 'Column',  'startup'),
					2  => '2 '. __( 'Columns', 'startup'),
					3  => '3 '. __( 'Columns', 'startup'),
					4  => '4 '. __( 'Columns', 'startup'),
					6  => '6 '. __( 'Columns', 'startup'),
					12 => '12 '.__( 'Columns', 'startup'),
				),
			) );

	}

	/* HELPERS */

		function startup_get_animations(){
			return array(
				'fade'  => __('Fade', 'startup'),
				'slide' => __('Slide', 'startup'),
			);
		}

		function startup_sanitize_animation($input){
			$white_list = array_keys( startup_get_animations() );
			if ( in_array( $input, $white_list ) )
				return $input;
			else
				return $white_list[0];

		}

		function startup_get_sizes_array(){
			$sizes[0] = __('No Thumbnails','startup');
			foreach( get_intermediate_image_sizes() as $size)
				(array) $sizes[$size] = ucfirst($size);
			return $sizes;
		}

		function startup_get_taxonomies_for_pt($pt){
			$taxonomies = get_taxonomies(array('public'=>true),'objects');
			unset($taxonomies['post_format']);
			$out = array();
			foreach ( $taxonomies as $tax ) {
				foreach ( $tax->object_type as $type )
					if ( $pt == $type ) $out[$tax->name] = $tax->labels->name;
			}
			return $out;
		}

		// Deprecated / Unused:
		// function startup_get_taxonomies_array( $args = array('public'=>true) ){
		// 	$tx = get_taxonomies($args,'objects');
		// 	unset($tx['post_format']);
		// 	foreach ($tx as $t)
		// 		(array) $taxonomies[$t->name] = $t->labels->name;
		// 	return $taxonomies;
		// }

		function startup_get_post_types_array( $args = array('public'=>true) ){
			foreach( get_post_types( $args, 'objects' ) as $pt)
			    (array) $post_types[$pt->name] = $pt->labels->name;
			return (array)$post_types;
		}

		function startup_sanitize_ratio($ratio) {
			return preg_match( "/^[\d]+x[\d]+$/", $ratio ) ? $ratio : null;
		}

		function startup_sanitize_columns($width){
			return in_array( $width , array(1,2,3,4,5,6,12) ) ? $width : 4;
		}

		function startup_customize_preview() {
			wp_enqueue_script(
				'startup-customizer',
				get_template_directory_uri() . '/js/customizer.min.js',
				array('jquery'),
				wp_get_theme()->get('Version'),
				true
			);
		}

	add_action( 'customize_register', 'startup_customize_register',99 );
	add_action( 'customize_preview_init', 'startup_customize_preview', 99);

?>