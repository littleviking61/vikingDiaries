<header class="banner">
	<div class="thumbnail <?= get_field('photo_round') ? 'circle' : '';?>">
		<?php 
		$image = get_field('photo_auteur');
		if( !empty($image) ): ?>
			<img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
		<?php endif; ?>
	</div>
	<?php if (get_field('titre')): ?>
		<h1><?php the_field('titre'); ?></h1>
	<?php else: ?>
		<h1><?= bloginfo('name' );?></h1>
	<?php endif ?>
	<h2><?php the_field('texte_daccueil'); ?></h2>
	<!-- <button class="quickJournal"><?php the_field('acces_rapide'); ?></button> -->
</header>

<?php if (get_field('has_honneur')): ?>
	<section class="highlight video">

		<?php if (get_field('video_a_lhonneur')): ?>
			<div class="video oEmbed">
				<?php the_field('video_a_lhonneur'); ?>
			</div>
		<?php else: ?>
			<div class="image">
				<?php $thumbnail = get_sub_field('image_a_lhonneur'); ?>
				<img src="<?= $thumbnail['sizes']['large']; ?>" alt="<?= $thumbnail['alt']; ?>" />
			</div>
		<?php endif ?>
		
		<div class="content">
			<?php the_field('contenu_a_lhonneur'); ?>
		</div>

	</section>
<?php endif ?>

<?php if (get_field('afficher_projet_lhonneur')): ?>
	<section class="projets highlight">
		<h3><?php the_field('titre_projet_lhonneur'); ?></h3>
		<ul>
	    <?php 
	    	$cat_honneur = get_field('projet_lhonneur');
	    	$thumbnail = get_field('thumbnail', $cat_honneur);
	    	$presentation = get_field('presentation', $cat_honneur);
	    	$journal = get_field('journal', $cat_honneur);
	    	$carte = get_field('carte', $cat_honneur);
				// position
				global $wpdb;
				$lastPoint = $wpdb->get_results( 'SELECT * FROM wp_messagespot ORDER BY ID DESC LIMIT 1', OBJECT )[0];
				// derniere actu
				$recentPosts = wp_get_recent_posts( array( 'numberposts' => '1', 'category' => $cat_honneur->term_id) );
	    ?>
	    <li class="projet full projet">
	    	<div class="thumbnail circle"> 
	    		<?php if( !empty($thumbnail) ): ?>
						<img src="<?= $lastPoint->showCustomMsg ?>" alt="">
	    		<?php endif; ?>
	    	</div><!--
	    	--><div class="details">
	    		<h4>
	    			<a href="<?= $journal ? get_category_link( $cat_honneur ) : the_permalink($presentation); ?>">
	    				<?= $cat_honneur->name; ?>
	    			</a>
	    		</h4>
	    		<div class="content">
	    			<?=  apply_filters('the_content', $cat_honneur->description); ?>
	    		</div>
					<div class="position">
						<div class="info">
							<p><strong>Statut :</strong> <?= $lastPoint->messageType === 'OK' ? 'Tout va bien' : 'J\'ai des petits soucis' ?></p>
					    <p><strong>Localisation :</strong> <?= $lastPoint->messageDetail ?></p>
					    <p><strong>Latitude :</strong> <?= $lastPoint->latitude ?></p>
					    <p><strong>Longitude :</strong> <?= $lastPoint->longitude ?></p>
					    <p><strong>Nombre de jours depuis le départ :</strong> <?= round(abs(1473266802 - time())/60/60/24);  ?></p>
					    <p><strong>Dernières actualitées :</strong><a href="<?= get_permalink($recentPosts[0]['ID'] ); ?>"><?= $recentPosts[0]['post_title'] ?></a></p>
						</div>
					</div>
	    	</div>
	    </li>
		</ul>
	</section>

<?php endif ?>

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

				if($cat->term_id === $cat_honneur->term_id) continue;
			?>
			<li class="projet <?= $grand ? 'full' : 'medium' ?> projet">
				<div class="thumbnail"> 
					<?php if( !empty($thumbnail) ): ?>
						<a href="<?= $journal ? get_category_link( $cat ) : the_permalink($presentation); ?>">
							<img src="<?= $thumbnail['sizes']['medium']; ?>" alt="<?= $thumbnail['alt']; ?>" />
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
							    	<li><a href="<?= the_permalink($presentation) ?>"><?= __('Presentation', 'html5blank') ?></a></li>
							    <?php endif ?>
							    <?php if ($journal): ?>
							    	<li><a href="/<?= $cat->slug; ?>"><?= __('Journal', 'html5blank') ?></a></li>
							    <?php else: ?>
							    	<li><a href="<?= the_permalink($presentation) ?>"><?= $avenir ?></a></li>
							    <?php endif ?>
							    <?php if ($carte): ?>
							    	<li><a href="<?= the_permalink($carte) ?>"><?= __('Carte', 'html5blank') ?></a></li>
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

<?php if (get_field('has_actu')): ?>
	<section class="actus">
		<?php $categorie_actu = get_field('categorie_des_actus') === "" ? 153 : get_field('categorie_des_actus'); ?>	
		<h3><a href="<?= get_category_link($categorie_actu); ?>"><?php the_field('titre_actu'); ?></a></h3>
		<ul class="list">
			<?php $actus = get_posts(['posts_per_page' => get_field('nombre_dactu'), 'cat' => $categorie_actu, 'date_query' => ['after' => ['year' => 2015, 'month' => 5]]]) ;
			foreach ( $actus as $post ) : setup_postdata( $post ); ?>
				<li class="actu">
					<a href="<?php the_permalink(); ?>" class="simple-ajax-popup">
						<div class="thumbnail">
							<?php the_post_thumbnail('medium'); ?>
						</div>
						<h4><?php the_title(); ?></h4>
					</a>
				</li>
			<?php endforeach; 
			wp_reset_postdata();?>
		</ul>
	</section>
<?php endif ?>

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

