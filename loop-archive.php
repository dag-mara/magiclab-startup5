	<?php do_action('startup_archive_before_loop') ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
			<article <?php post_class(); ?> >
				<div class="inner">
					
					<?php do_action('startup_title'); ?>
					
					<?php do_action('startup_thumbnail'); ?>

					<?php echo get_the_date(); ?>

					<div class="entry">
						<?php do_action('startup_content'); ?>
					</div>

				</div>
			
			</article>
			
		<?php endwhile; else: ?>
	
		<div class="alert-box error"><?php _e('Sorry, the page you requested was not found','startup');?></div>
	
	<?php endif; ?>
	
	<?php do_action('startup_archive_after_loop') ?>

	<?php do_action('startup_pagination') ?>