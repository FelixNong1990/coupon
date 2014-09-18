<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<title><?php wp_title(''); ?></title>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo appthemes_get_feed_url(); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/styles/ie.css" media="screen"/><![endif]-->
       <!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/styles/ie7.css" media="screen"/><![endif]-->

	<?php wp_head(); ?>

</head>

<body id="top" <?php body_class(); ?>>

	<?php appthemes_before(); ?>

	<div id="wrapper">

		<div class="w1">

			<?php appthemes_before_header(); ?>
			<?php get_header( app_template_base() ); ?>
			<?php appthemes_after_header(); ?>

			<div id="main">

				<?php load_template( app_template_path() ); ?>

			</div> <!-- #main -->

		</div> <!-- #w1 -->

		<?php appthemes_before_footer(); ?>
		<?php get_footer( app_template_base() ); ?>
		<?php appthemes_after_footer(); ?>

	</div> <!-- #wrapper -->

	<?php wp_footer(); ?>

	<?php appthemes_after(); ?>

</body>

</html>
