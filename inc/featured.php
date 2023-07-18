<div class="row">
	<div class="large-12 columns featured-slider">
		<div id="featured" data-orbit <?php startup_orbit_options(); ?>>
			<?php
			$opt = get_option('startup_theme_options');
			$args = apply_filters( 'startup_feat_slider_args',array( 'post_type' => 'post') );
			$loop = new WP_Query( $args );
			$is_attachment = isset($args['post_type']) && 'attachment' == $args['post_type'];
			$linked = ! empty($opt['featured_slider']['link_to']);
				while ( $loop->have_posts() ) {
					$loop->the_post();
					$classes = array('slide');
					$has_thumb = has_post_thumbnail() || $is_attachment;
					if ( ! $has_thumb ) {
						$classes[] = 'no-thumbnail';
					}
					$classes = apply_filters('startup_feat_slide_classes', $classes, $post);
					echo '<div class="'.join(' ',$classes).'" >';
					if ( $linked ) {
						echo '<a href="'.esc_url(get_permalink()).'">';
					}
					if ( $is_attachment ) {
						echo wp_get_attachment_image( $post->ID,'large' );
					} else {
						echo '<h2>'.get_the_title().'</h2>'.
						     $has_thumb ? get_the_post_thumbnail($post->ID, 'large') : '<span class="placeholder"></span>'.
						     '';
					}
					do_action('startup_feat_after_slide', $post);
					if ( $linked ) {
						echo '</a>';
					}
					echo '</div>';
				}
			wp_reset_postdata();
			?>
		</div>
	</div>
</div>