<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo ": ".get_search_query(); ?></h1>

			<?php if (have_posts()): while (have_posts()) : the_post();
				get_template_part('templates/content', 'search');
			endwhile; ?>

			<?php else: ?>
				<article>
					<h2><?php __( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
				</article>
			<?php endif; ?>

			<?php //get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
