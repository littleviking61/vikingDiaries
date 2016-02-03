<?php /* Template Name: Page Voyages */ get_header(); ?>

	<main role="main">
		<!-- section -->
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<header class="banner">
				<div class="thumbnail circle">
					<?php 
					$image = get_field('photo_auteur');
					if( !empty($image) ): ?>
						<img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
					<?php endif; ?>
				</div>
				<?php if (get_field('titre_daccueil')): ?>
					<h1><?= the_field('titre_daccueil');?></h1>
				<?php endif ?>
				<?php if (get_field('texte_daccueil')): ?>
					<h2><?php the_field('texte_daccueil'); ?></h2>
				<?php endif ?>
				<!-- <button class="quickJournal"><?php the_field('acces_rapide'); ?></button> -->
			</header>

			<section class="projets">
				<h3><?php the_field('titre_aventures'); ?></h3>
				<?php 

				if( get_field('aventures') ): ?>

					<ul>
					<?php while( has_sub_field('aventures') ): ?>
						<?php 
							$cat = get_sub_field('projet');
							$thumbnail = get_field('thumbnail', $cat);
							$presentation = get_field('presentation', $cat);
							$journal = get_field('journal', $cat);
							$carte = get_field('carte', $cat);
							$grand = get_field('en_grand', $cat);
							$avenir = get_field('a_venir', $cat);
						?>
						<li class="projet <?= $grand ? 'full' : 'medium' ?> projet">
							<div class="thumbnail"> 
								<?php if( !empty($thumbnail) ): ?>
									<a href="<?= $journal ? get_category_link( $cat ) : the_permalink($presentation); ?>">
										<img src="<?= $thumbnail['sizes']['large']; ?>" alt="<?= $thumbnail['alt']; ?>" />
									</a>
								<?php endif; ?>
							</div><!--
							--><div class="details">
								<h4>
									<a href="<?= $journal ? get_category_link( $cat ) : the_permalink($presentation); ?>">
										<?= $cat->name; ?>
									</a>
								</h4>
								<nav>
							    <ul>
								    <?php if ($presentation): ?>
								    	<li><a href="<?= the_permalink($presentation) ?>"><?=  __('Presentation', 'html5blank') ?></a></li>
								    <?php endif ?>
								    <?php if ($journal): ?>
								    	<li><a href="/<?= $cat->slug; ?>"><?= __('Diaries', 'html5blank') ?></a></li>
								    <?php else: ?>
								    	<li><a href="<?= the_permalink($presentation) ?>"><?= $avenir ?></a></li>
								    <?php endif ?>
								    <?php if ($carte): ?>
								    	<li><a href="<?= the_permalink($carte) ?>"><?= __('Map', 'html5blank') ?></a></li>
								    <?php endif ?>
							    </ul>
								</nav>
								<div class="content">
									<?=  apply_filters('the_content', $cat->description); ?>
								</div>
							</div>
						</li>
					<?php endwhile; ?>

				<?php endif; ?>

			</section>

			<?php 
				if( have_rows('autres_blocs') ):

				 	// loop through the rows of data
				    while ( have_rows('autres_blocs') ) : the_row(); ?>
							
							<section class="bloc">
								<?php if (get_sub_field('titre')): ?>
									<h3><?php the_sub_field('titre'); ?></h3>
								<?php endif ?>

								<?php if (get_sub_field('video')): ?>
									<div class="video">
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

			<section class="content-normal">

				<?php the_content(); ?>

			</section>
			
			<?php endwhile; ?>
		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
