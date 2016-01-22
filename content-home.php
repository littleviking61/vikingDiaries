
<section class="banner">
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
</section>

<section class="highlight video">
	<?php if (get_field('titre_a_lhonneur')): ?>
		<h3><?php the_field('titre_a_lhonneur'); ?></h3>
	<?php endif ?>

	<?php if (get_field('video_a_lhonneur')): ?>
		<div class="video">
			<?php the_field('video_a_lhonneur'); ?>
		</div>
	<?php else: ?>
		<div class="image">
			<?php the_field('image_a_lhonneur'); ?>
		</div>
	<?php endif ?>
	
	<div class="content">
		<?php the_field('contenu_a_lhonneur'); ?>
	</div>

</section>

<section class="adventures">
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
			?>

			<li class="adventure <?= $grand ? 'full' : 'medium' ?> projet">
				<div class="thumbnail"> 
					<?php if( !empty($thumbnail) ): ?>
						<a href="<?= get_category_link( $cat ); ?>">
							<img src="<?= $thumbnail['sizes']['large']; ?>" alt="<?= $thumbnail['alt']; ?>" />
						</a>
					<?php endif; ?>
				</div>
				<div class="details">
					<a href="<?= get_category_link( $cat ); ?>">
						<h4><?= $cat->name; ?></h4>
					</a>
					<nav>
					    <ul>
						    <?php if ($presentation): ?>
						    	<li><a href="<?= $presentation ?>"><?= __('Presentation') ?></a></li>
						    <?php endif ?>
						    <?php if ($journal): ?>
						    	<li><a href="/adventures/<?= $cat->slug; ?>"><?= __('Journal') ?></a></li>
						    <?php endif ?>
						    <?php if ($carte): ?>
						    	<li><a href="<?= $carte ?>"><?= __('Carte') ?></a></li>
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

<section class="actus">
	<h3><?php the_field('titre_actu'); ?></h3>
	<div class="content">
		<ul>
			<?php $actus = get_posts(['posts_per_page' => get_field('nombre_dactu')]) ;
			foreach ( $actus as $post ) : setup_postdata( $post ); ?>
				<li>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
			<?php endforeach; 
			wp_reset_postdata();?>
		</ul>
	</div>
</section>

