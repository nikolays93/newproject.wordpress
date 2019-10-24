<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post__body media">
		<div class="post__prev">
			<?php the_thumbnail( null, true ); ?>
		</div>
		<div class="media-body post__content">
			<?php the_title( '<h4 class="post__title">', '</h4>' ); ?>
			<?php the_content( '<span class="post__more more meta-nav">Подробнее</span>' ); ?>
		</div>
	</div>
</article>
