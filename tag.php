<?php get_header(); ?>

	<main role="main">

		<?php if (is_front_page()): ?>
			
			<?php get_template_part('content','home' ); ?>

		<?php else: ?>
			<!-- section -->
			<section>

				<h1><?php the_title(); ?></h1>

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php the_content(); ?>

					<?php comments_template( '', true ); // Remove if you don't want comments ?>

					<br class="clear">

					<?php edit_post_link(); ?>

				</article>
				<!-- /article -->

			<?php endwhile; ?>

			<?php else: ?>

				<!-- article -->
				<article>

					<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

				</article>
				<!-- /article -->

			<?php endif; ?>
			
      <?php echo get_scp_widget(); ?>
			
			</section>
			<!-- /section -->
		<?php endif ?>
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
