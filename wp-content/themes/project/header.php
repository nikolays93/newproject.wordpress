<?php
/**
 * Шаблон шапки для сайта
 *
 * Этот шаблон отображает начало сайта до контента включая тэг <head>
 *
 * @see https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package project
 * @version 1.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php /* $viewport = 1170; $max_width = $viewport - (15*2); ?>
	<meta name="viewport" content="width='<?= $viewport ?>'">
	<style type="text/css">
	.container {
		max-width: <?= $max_width ?>px !important;
		width: <?= $max_width ?>px !important;
	}
	</style>
	<?php // */ ?>

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
	<script data-skip-moving="true" type="text/javascript"
			src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
	<![endif]-->

	<script>window.jQuery || document.write('<script src="<?= TPL ?>/assets/jquery/jquery.min.js"><\/script>')</script>
</head>
<body <?php body_class(); ?>>
<!--[if lte IE 9]>
<p class="browserupgrade">Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a
		href="https://browsehappy.com/">обновите ваш браузер</a> для лучшего отображения и безопасности.</p>
<![endif]-->
<div id="page" class="site">
	<!-- <a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content',
		'_s' ); ?></a> -->

	<div id="masthead" class="container site-header">
		<!-- <div itemscope itemtype="http://schema.org/LocalBusiness"> -->
		<div class="row head-info">
			<div class="col-4 logotype">
				<?php
				// echo ( shortcode_exists( 'company' ) ) ? do_shortcode('[company field="image"]') : get_bloginfo("name");
				// the_custom_logo();
				bloginfo( 'description' );
				?>
			</div>
			<div class="col-4 contacts">
				<?php

				/**
				 * From Organized Contacts Plug-in
				 */
				if ( shortcode_exists( 'company' ) ) {
					echo do_shortcode( '[company field="name"]' );
					echo do_shortcode( '[company field="address"]' );
					echo do_shortcode( '[company field="numbers"]' );
					echo do_shortcode( '[company field="email"]' );
					echo do_shortcode( '[company field="time_work"]' );
					echo do_shortcode( '[company field="socials"]' );

					// echo do_shortcode('[phone del="," num="1"]'); // only first phone between ,
				}
				?>
			</div>
			<div class="col-4 callback">
				<!-- <a href="#" id="get-recall"></a> -->
			</div>
		</div><!--.row head-info-->

		<!-- <div class="hidden hidden-xs-up d-none">
			<span itemprop="priceRange">RUB</span>
		</div> -->
		<!-- </div> -->
	</div><!-- .site-header -->

	<?php
	/**
	 * Hook: before_main_content.
	 *
	 * @hooked default_theme_nav - 10
	 * may be @hooked breadcrumbs_from_yoast - 10
	 */
	do_action( 'before_main_content' );
	?>

	<div id="content" class="site-content">
		<div class="<?= apply_filters( 'site-container', 'container' ); ?>">
