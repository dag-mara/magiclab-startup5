	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?> >

			<div class="inner">

				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<div class="entry">
					<?php the_content(); ?>
				</div>

			</div>

		</article>

	<?php endwhile; else: ?>

		<div class="alert-box error"><?php _e('Sorry, the page you requested was not found','startup');?></div>

	<?php endif; ?>