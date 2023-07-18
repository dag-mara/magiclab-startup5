<?php
/*
Template Name: Children List
*/
?>

<?php get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?> >

			<div class="inner">

				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<div class="entry">

					<ul class="page-children">

						<?php foreach ( get_posts('post_type=page&nopaging=1&order=ASC&orderby=menu_order&post_parent='.$post->ID) as $children ) : ?>

							<li>
								<a href="<?php echo get_permalink( $children->ID ); ?>">
									<?php echo get_the_title( $children->ID ); ?>
								</a>
							</li>

						<?php endforeach; ?>

					</ul>

				</div>

			</div>

		</article>

	<?php endwhile; else: ?>

		<div class="alert-box error"><?php _e('Sorry, the page you requested was not found','startup');?></div>

	<?php endif; ?>

<?php get_footer(); ?>