

<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		
		<?php get_template_part('header', 'projet'); ?>
		
		<?php if (get_query_var( 'paged' ) !== 0): ?>
			
			<div class="pagination top">
				<span class="more pref">
					<?= __('Charger les articles plus récents') ?>
				</span>
			</div>
		<?php endif ?>

		<section class="dairies">

			<?php 
				global $wp_query;
				$args = array_merge( $wp_query->query_vars, array( 'post__not_in' => $excludePosts  ) );
				query_posts( $args ); ?>

			<?php get_template_part('loop'); ?>
			
		</section>
		<?php get_template_part('pagination'); ?>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
