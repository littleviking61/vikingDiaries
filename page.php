<?php get_header(); ?>

	<main role="main">

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if (is_front_page()): ?>
					<?php get_template_part('content','home' ); ?>
				<?php else: ?>
					<!-- section -->

					<!-- article -->
					<header class="banner">
						<div class="thumbnail">
							<?php 
							$image = get_field('photo_auteur');
							if( !empty($image) ): ?>
								<img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
							<?php endif; ?>
						</div>
						<h1><?= bloginfo('name' );?></h1>
						<h2><?php the_field('texte_daccueil'); ?></h2>
						<!-- <button class="quickJournal"><?php the_field('acces_rapide'); ?></button> -->
					</header>

					<?php 
						if( have_rows('autres_blocs') ):

						 	// loop through the rows of data
						    while ( have_rows('autres_blocs') ) : the_row(); ?>
									
									<section class="bloc">
										<?php if (get_sub_field('titre')): ?>
											<h3><?php the_sub_field('titre'); ?></h3>
										<?php endif ?>

										<?php if (get_sub_field('video')): ?>
											<div class="video oEmbed">
											<div class="video oEmbed">
												<?php the_sub_field('video'); ?>
											</div>
										<?php endif ?>
										
										<div class="content">
											<?php the_sub_field('contenu'); ?>
										</div>

									</section>

						    <?php endwhile;

						endif;
					?>
				
				<?php endif ?>

				<section class="content-normal">

					<?php the_content(); ?>

				</section>

			</article>
			<!-- /section -->

			<?php endwhile; ?>
		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
