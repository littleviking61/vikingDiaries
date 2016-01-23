<?php 
	$cat = get_queried_object();
	$thumbnail = get_field('thumbnail', $cat);
	$presentation = get_field('presentation', $cat);
	$journal = get_field('journal', $cat);
	$carte = get_field('carte', $cat);
	$grand = get_field('en_grand', $cat);
	$avenir = get_field('a_venir', $cat);
	$icone = get_field('icone', $cat);
?>

<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<header class="banner">
			<div class="thumbnail">
				<?php 
				$image = get_field('photo_auteur');
				if( !empty($icone) ): ?>
					<img src="<?= $icone['url']; ?>" alt="<?= $icone['alt']; ?>" />
				<?php endif; ?>
			</div>
			<h1><?= __('Journal de bord');?></h1>
			<h2><?php single_cat_title(); ?></h2>
			<nav>
			    <ul>
				    <?php if ($presentation): ?>
				    	<li><a href="<?= $presentation ?>"><?= __('Presentation') ?></a></li>
				    <?php endif ?>
				    <?php if ($journal): ?>
				    	<li><a href="/adventures/<?= $cat->slug; ?>"><?= __('Journal') ?></a></li>
				    <?php else: ?>
				    	<li><a href="<?= $presentation ?>"><?= $avenir ?></a></li>
				    <?php endif ?>
				    <?php if ($carte): ?>
				    	<li><a href="<?= $carte ?>"><?= __('Carte') ?></a></li>
				    <?php endif ?>
			    </ul>
			</nav>
		</header>

		<section class="dairies">
			<?php get_template_part('loop'); ?>
			
			<?php get_template_part('pagination'); ?>
		</section>


		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
