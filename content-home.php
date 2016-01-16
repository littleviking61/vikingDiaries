<section class="home">

	<div class="banner">
		<div class="thumbnail">
			<?php 
			$image = get_field('image_entete');
			if( !empty($image) ): ?>
				<img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
			<?php endif; ?>
		</div>
		<h2><?php the_field('texte_daccueil'); ?></h2>
		<button class="quickJournal"><?php the_field('acces_rapide'); ?></button>
	</div>

	<div class="highlight-video"><?php the_field('video_a_lhonneur'); ?></div>
	
	<div class="incoming">
		<h3><?php the_field('titre_a_venir'); ?></h3>
		<?php the_field('a_venir'); ?>
	</div>
	
	<div class="actus">
		<h3><?php the_field('titre_actu'); ?></h3>
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

	<div class="follow-me">
		<h3><?php the_field('titre_me_suivre'); ?></h3>
		<ul class="social">
			<li>
				<a href="<?php the_field('lien_newsletter') ?>">
					<div class="thumbnail">
						<?php 
						$image = get_field('image_newsletter');
						if( !empty($image) ): ?>
							<img src="<?= $image['sizes']['thumbnail'] ?>" alt="<?= $image['alt']; ?>" />
						<?php endif; ?>
					</div>
				</a>
			</li>
			<li>
				<a title="L’aventurier viking sur facebook" target="_blank" href="http://facebook.com/laventurierviking"><i class="fa fa-facebook"></i> </a>
			</li>
			<li>
				<a title="Le twitter du viking" target="_blank" href="http://twitter.com/VikingDiaries"><i class="fa fa-twitter"></i></a>
			</li>
			<li>
				<a title="Les vidéos de l’aventurier viking" target="_blank" href="http://youtube.com/laventurierviking"><i class="fa fa-youtube"></i></a>
			</li>
		</ul>
	</div>
	
	<div class="my-adventures">
		<h3><?php the_field('titre_aventures'); ?></h3>
		<?php 

		if( get_field('aventures') ): ?>

			<ul>

			<?php while( has_sub_field('aventures') ): ?>

				<li>
					<?php $cat = get_sub_field('projet'); ?>
					<a href="<?= get_category_link( $cat ); ?>">
						<div class="thumbnail"><?php 
							$image = get_sub_field('image'); 
							if( !empty($image) ): ?>
								<img src="<?= $image['sizes']['medium']; ?>" alt="<?= $image['alt']; ?>" />
							<?php endif; ?>
						</div>
						<h4><?= get_cat_name( $cat ) ?></h4>
					</a>
				</li>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>