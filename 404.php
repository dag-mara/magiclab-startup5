<?php get_header(); ?>

		<article <?php post_class(); ?> >

			<div class="inner">

				<h1><?php _e('Page not found','startup'); ?></h1>

				<div class="entry">
					<?php dynamic_sidebar('page-404'); ?>
				</div>

			</div>

		</article>

<?php get_footer(); ?>




