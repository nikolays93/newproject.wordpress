<?php
/**
 * Этот шаблон показывает "подвал" сайта
 *
 * Он включает в себя закрывающий слой #content и заканчивает страницу.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package project
 * @version 1.1
 */
?>
	</div><!-- #content -->

	<footer class="site__footer" id="colophon">
		<div class="container">
			<div class="row align-items-center site-foot">
				<?php footer_links( array( 'menu_class' => 'site-foot__menu' ) ); ?>

				<div class="col-12 col-md-3">
					<div class="site-foot__by">Developed by: Me</div>
					<a href="javascript:;" class="privacy">Политика конфедициальности</a>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -*remove me*->
<script>
	window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
	ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
<!-- *remove me* -->

<?php wp_footer(); ?>

</body>
</html>
