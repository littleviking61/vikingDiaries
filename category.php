
<?php get_header(); ?>

	<main role="main">
		<!-- section -->
			
		<?php get_template_part('header', 'projet'); ?>
		<?php $statut = get_field('statut', $cat) == "passed" ? "ASC" : "DESC"; ?>

		<?php if (get_query_var( 'paged' ) !== 0): ?>
			
			<div class="pagination top">
				<span class="more pref">
					<?= __('Load recent posts', 'html5blank') ?>
				</span>
			</div>
		<?php endif ?>
		
		<section class="dairies middle-line <?= $statut ?>">
			<?php 
				global $wp_query;
				// changer l'ordre des articles si le voyage est passé
				$args = array_merge( $wp_query->query_vars, array( 'category__not_in' => array( 165 ), 'order' => $statut) );
				query_posts( $args ); ?>

			<?php get_template_part('loop'); ?>
			
		</section>
		
		<?php get_template_part('pagination'); ?>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
