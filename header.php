<?php get_template_part( 'head' ); ?>

<?php
	$header_widgets = is_active_sidebar( 'header' );
	$header_columns = $header_widgets ? 'medium-8 large-10' : 'large-12';
?>

<body <?php body_class(); ?> >

	<header class="row" >
		<div class="<?php echo $header_columns ?> columns" id="header" >
			<?php do_action('startup_header_logo'); ?>
			<?php do_action('startup_header_title'); ?>
		</div>
		<?php if ( $header_widgets ) : ?>
			<div class="medium-4 large-2 columns header-widget-area" >
				<?php dynamic_sidebar('header'); ?>
			</div>
		<?php endif; ?>
	</header>

	<?php do_action('startup_feat_slider'); ?>

	<div class="row">
		<div class="medium-12 columns" id="access" role="navigation" >
			<?php do_action('startup_top_bar'); ?>
			<?php do_action('startup_nav_bar'); ?>
		</div>
	</div>

	<div class="row">
		<?php do_action('startup_sidebar','header'); ?>
		<div class="<?php do_action('startup_columns_class'); ?>" id="main" >
			<?php do_action('startup_breadcrumbs'); ?>
