<?php get_header(); ?>

	<main role="main">
		<!-- section -->

		<?php if (!empty(get_search_query())): ?>
			
			<section class="search-results">

				<h2><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo ": ".get_search_query(); ?></h2>

				<?php if (have_posts()): while (have_posts()) : the_post();
					get_template_part('templates/content', 'search');
				endwhile; ?>
		
				<?php else: ?>
					<article>
						<h2><?php __( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
					</article>
				<?php endif; ?>

				<?php get_template_part('pagination'); ?>

			</section>
		<?php endif ?>

		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
