<?php get_header(); ?>

	<main role="main">
			
		<?php if (get_option('page_for_posts')):
			global $post;
			$post = get_post(get_option('page_for_posts'));
			setup_postdata( $post );?>

			<!-- article -->
			<header class="banner">
				<div class="thumbnail circle">
					<?php 
					$image = get_field('photo_auteur');
					if( !empty($image) ): ?>
						<img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
					<?php endif; ?>
				</div>
				<h1>
					<?php if (get_field('titre')): ?>
						<?php the_field('titre') ?>
					<?php else: ?>
						<?= bloginfo('name' );?>
					<?php endif ?>
				</h1>
				<h2><?php the_field('texte_daccueil'); ?></h2>
				<!-- <button class="quickJournal"><?php the_field('acces_rapide'); ?></button> -->
			</header>

			<?php wp_reset_postdata(); ?>
			
			<?php if (get_query_var( 'paged' ) !== 0): ?>
				
				<div class="pagination top">
					<span class="more pref">
						<?= __('Load recent posts', 'html5blank') ?>
					</span>
				</div>
			<?php endif ?>

			<?php 
				global $wp_query;
				$args = array_merge( $wp_query->query_vars, array( 'category__not_in' => array( 165 )  ) );
				query_posts( $args ); ?>

			<section class="dairies middle-line">
				<?php get_template_part('loop'); ?>
			</section>

			<?php get_template_part('pagination'); ?>

			<!-- /section -->
		<?php endif ; ?>
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
