<?php
/**
 * Файл ошибки 404 темы WordPress
 *
 * Этот файл используется когда запрашиваемая страница не найдена
 *
 * @see https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package project
 * @version 1.0
 */
get_header();
?>
	<div class="container">
		<div class="row">
			<div id="primary" class="<?php echo ( is_active_sidebar( 'archive' ) ) ? "col-9" : "col-12"; ?>">
				<main id="main" class="404 content" role="main">
					<article class="error-404 not-found">
						<h1 class="error-404__title">Ошибка #404: страница не найдена.</h1>

						<div class="error-404__content entry-content">
							<p>К сожалению эта страница не найдена или не доступна. Попробуйте зайти позднее или
								воспользуйтесь главным меню для перехода по основным страницам.</p>
						</div><!-- .entry-content -->
					</article><!-- #post-## -->
				</main><!-- #main -->
				<?php get_sidebar(); ?>
			</div><!-- .col -->
		</div><!-- .row -->
	</div><!-- .container -->
<?php
get_footer();
