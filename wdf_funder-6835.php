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
							<?php if (get_field('titre')): ?>
								<?php the_field('titre') ?>
							<?php else: ?>
								<?= bloginfo('name' );?>
							<?php endif ?>
						</h1>
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

					<section class="fundraising">
						<div class="content-fundraising">
							<?php the_content(); ?>
							<?php comments_template('/templates/comments.php'); ?>
						</div>
						<div class="pannel-fundraising ">
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
