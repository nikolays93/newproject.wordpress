<?php
/**
 * Основной файл темы WordPress
 *
 * Это самый первичный файл в теме WordPress
 * И один из двух необходимых (еще необходим style.css).
 * Он используется если ничего более конкретного не соответствует запросу.
 * к пр. этот файл покажется на главной странице, если нет home.php.
 *
 * @see https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package project
 * @version 1.0
 */

get_header();

?>
	<div class="row">
		<?php do_action( 'site_before_main_row_content' ); ?>

		<div id="primary" class="<?php echo apply_filters( 'site_primary_class', 'site-primary col-12' ); ?>">
			<main id="main" class="main content" role="main">
				<?php
				if ( have_posts() ) {
					if ( is_search() ) {
						echo sprintf(
							'<header class="archive-header"><h1>%s %s</h1></header>',
							'Результаты поиска:',
							get_search_query()
						);

						the_template_search_content();
					} else {
						if ( ! is_front_page() && is_archive() ) {
							the_archive_title( '<h1 class="archive-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						}

						the_template_content();
					}

					the_template_pagination();
				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
				?>
			</main><!-- #main -->
		</div><!-- .col -->

		<?php do_action( 'site_after_main_row_content' ); ?>
	</div><!-- .row -->
<?php
get_footer();
