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
	<section class="projets lhonneur">
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
	    <li class="projet full">
    		<div class="thumbnail"> 
	    		<?php if( !empty($thumbnail) ): ?>
	    			<a href="<?= the_permalink($presentation); ?>"><img src="<?= $thumbnail['sizes']['medium']; ?>" alt="<?= $thumbnail['alt']; ?>" /></a>
	    		<?php endif; ?>
	    	</div><!--
	    	--><div class="details">
	    		<h4>
	    			<a href="<?= $journal ? get_category_link( $cat_honneur ) : the_permalink($presentation); ?>">
	    				<?= apply_filters('the_title', $cat_honneur->name) ?>
	    			</a>
	    		</h4>
	    		<div class="content">
	    			<?=  apply_filters('the_content', $cat_honneur->description); ?>
	    			<p><a href="<?php the_permalink($presentation) ?>"> <i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;<?= __('Read more about this project', 'html5blank') ?> </a></p>
	    		</div>
    		</div>
  		</li>
  		<li class="projet full statut">
				<div class="details">
					<h4>
	    			<a href="<?= get_category_link( $cat_honneur ); ?>">
	    				<?= __('From most recent information', 'html5blank') ?>
	    			</a>
	    		</h4>
					<div class="content ">
						<p><strong><?= $lastPoint->messageType === 'OK'|| $lastPoint->messageType === 'CUSTOM' ? __('All\'s fine', 'html5blank') : __('I have some trouble', 'html5blank') ?></strong></p>
				    <p><strong><?= __('I\'m at', 'html5blank') ?> :</strong> <?= $lastPoint->messageDetail ?></p>
				    <p><strong>Latitude :</strong> <?= $lastPoint->latitude ?> | Longitude :</strong> <?= $lastPoint->longitude ?></p>
				    <p><strong><?= __('Last chekup at', 'html5blank') ?> :</strong> <?= date('d/m/Y', $lastPoint->unixTime)  ?> </p>
				    <p><strong><?= __('And I travel since', 'html5blank') ?> :</strong> 240 <?= __('days', 'html5blank') ?></p>
				    <br><a href="<?= the_permalink($carte) ?>"> <i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;<?= __('Track the viking', 'html5blank') ?> </a>
					</div>
	    	</div><!--
	    	--><div class="image">
					<div class="thumbnail map"> 
						<a href="<?php the_permalink($carte) ?>"><img src="<?= $lastPoint->showCustomMsg ?>" alt=""></a>
					</div>
  			</div>
	    </li>
		</ul>

		<h3><?= __('Most recent news', 'html5blank'); ?></h3>
		<div class="single-dairies full">

				<?php $actus = get_posts(['posts_per_page' => 1, 'cat' => $cat_honneur->term_id]) ;
				foreach ( $actus as $post ) : setup_postdata( $post ); 
					get_template_part('templates/content', get_post_format());
				endforeach; 
				wp_reset_postdata();?>
			<?= get_field('contenu_a_lhonneur_fin') ?>
		</div>
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
				$autre_page = get_field('autre_page', $cat);
				$lien_autre_page = get_field('lien_autre_page', $cat);
				$titre_autre_page = get_field('titre_autre_page', $cat);

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
								<?= apply_filters('the_title', $cat->name) ?>
							</a>
						</h4>
						<nav>
						    <ul>
							    <?php if ($presentation): ?>
							    	<li><a href="<?= the_permalink($presentation) ?>"><?= __('Presentation', 'html5blank') ?></a></li>
							    <?php endif ?>
							    <?php if ($journal): ?>
							    	<li><a href="/<?= $cat->slug; ?>"><?= __('Dairy', 'html5blank') ?></a></li>
							    <?php else: ?>
							    	<li><a href="<?= the_permalink($presentation) ?>"><?= $avenir ?></a></li>
							    <?php endif ?>
							    <?php if ($autre_page): ?>
							    	<li><a href="<?= the_permalink($lien_autre_page) ?>"><?=  __($titre_autre_page, 'html5blank') ?></a></li>
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

<?php if (get_field('has_actu')): ?>
	<section class="actus">
		<?php $categorie_actu = get_field('categorie_des_actus') === "" ? 153 : get_field('categorie_des_actus'); ?>	

		<div class="content-normal">
			<h3><a href="<?= get_category_link($categorie_actu); ?>"><?php the_field('titre_actu'); ?></a></h3>
		</div>

		<div class="single-dairies full">
			<?php $actus = get_posts(['posts_per_page' => get_field('nombre_dactu'), 'cat' => $categorie_actu, 'date_query' => ['after' => ['year' => 2015, 'month' => 5]]]) ;
				foreach ( $actus as $post ) : setup_postdata( $post );
					get_template_part('templates/content', get_post_format());
				endforeach; 
				wp_reset_postdata();?>
		</div>
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

