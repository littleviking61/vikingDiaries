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

					<section class="fundraising quickbuy">
						<button class="button buy" data-pledge="1"><?= __('Give 3.4€ </br>to see</br>the movie','html5blank') ?></button>
						<button class="button buy" data-pledge="2"><?= __('Give 8.5€ </br>to support</br>the book and the movie','html5blank') ?></button>
					</section>
					<p align="center"><?= __('&darr; OR discover the other pledges','html5blank') ?></p>

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
