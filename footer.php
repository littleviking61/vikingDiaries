			<!-- footer -->
			<footer class="footer" role="contentinfo">
				
				<section class="search-form">
					<h1><?= __( 'Looking for something ?', 'html5blank' ) ?></h1>
					<p><?php get_search_form(); ?></p>
				</section>
				
				<section class="more-content-footer">
					<?php the_field('pied_de_page', 'option'); ?>
				</section>

				<!-- copyright -->
				<p class="copyright">
					<?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?>
					 - <?php __('Design by', 'html5blank'); ?>
					<a href="http://nuagegraphik.fr" target="new" title="Nuagegaphik">Nuagegraphik</a>
					 - <a href="http://wordpress.org" target="new" title="WordPress">WordPress</a>
				</p>
				<!-- /copyright -->

				<?php html5blank_nav('extra-menu'); ?>

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
