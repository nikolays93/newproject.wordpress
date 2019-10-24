<article <?php post_class(); ?>>
	<?php the_post_thumbnail( 'medium', array( 'class' => 'al' ) ); ?>
	<div class="post__body">
		<?php the_title( '<h1 class="post__name">', '</h1>' ); ?>
		<?php the_content( '<span class="post__more more meta-nav">Подробнее</span>' ); ?>
	</div>
</article>
