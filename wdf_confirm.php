<?php get_header(); ?>

	<main role="main">

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

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
							<?= __('Merci pour votre soutien','html5blank') ?>
						</h1>
						<h2><?= __('Bon visionnage') ?></h2>
					</header>

					<section class="fundraising">
						<div class="content-fundraising">
							<?php the_content(); ?>
						</div>
						<div class="pannel-fundraising wdf-no-checkout">
							<?php wdf_fundraiser_panel() ?>
						</div>
					</section>

				

			</article>
			<!-- /section -->

			<?php endwhile; ?>
		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php __( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
