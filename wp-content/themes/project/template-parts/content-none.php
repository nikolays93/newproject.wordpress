<article class="no-results not-found">
	<h1 class="post-title"><?= __( 'Ничего не найдено', 'project' ); ?></h1>
	<div class="no-results-content error-content content-body">
		<?php
		if ( is_search() ) {
			printf( '<p>%s</p>',
				__( 'К сожалению по вашему запросу ничего не найдено. Попробуйте снова исользуя другой запрос.',
					'project' ) );
			get_search_form();
		} else {
			_e( 'К сожалению на этой странице пока нет дынных, пожалуйста, посетите страницу позже.',
				'project' );
		}
		?>
	</div><!-- .entry-content -->
</article>
