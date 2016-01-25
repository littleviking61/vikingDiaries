

<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		
		<?php get_template_part('header', 'projet'); ?>

		<section class="dairies">

			<?php 
				global $wp_query;
				$args = array_merge( $wp_query->query_vars, array( 'post__not_in' => $excludePosts  ) );
				query_posts( $args ); ?>

			<?php get_template_part('loop'); ?>
			
			<?php get_template_part('pagination'); ?>
		</section>


		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
