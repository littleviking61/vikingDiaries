<?php 
	global $excludePosts;

	if(is_category()) {
		$cat = get_queried_object();
	}else{
		$cat = wp_get_post_terms($post->ID, 'category', array("fields" => "all"))[0];
	}

	$thumbnail = get_field('thumbnail', $cat);
	$presentation = get_field('presentation', $cat);
	$journal = get_field('journal', $cat);
	$grand = get_field('en_grand', $cat);
	$avenir = get_field('a_venir', $cat);
	$icone = get_field('icone', $cat);
	$carte = get_field('carte', $cat);
?>

<?php if (get_the_id() === $presentation || get_the_id() === $carte || is_category()): ?> 

	<header class="banner">
		<div class="thumbnail">
			<?php 
			$image = get_field('photo_auteur');
			if( !empty($icone) ): ?>
				<img src="<?= $icone['url']; ?>" alt="<?= $icone['alt']; ?>" />
			<?php else: ?>
				<img src="/wp-content/uploads/2016/01/viking-first.svg" />
			<?php endif; ?>
		</div>
		<h1><?= __('Journal de bord');?></h1>
		<h2><?= $cat->name; ?></h2>
		<nav>
			<ul>
				<?php if ($presentation): ?>
					<?php $excludePosts[] = $presentation; ?>
					<li <?= $post->ID === $presentation ? 'class="current"' : ''; ?>>
						<a href="<?= the_permalink($presentation) ?>"><?= __('Presentation') ?></a>
					</li>
				<?php endif ?>
				<?php if ($journal): ?>
					<li <?= is_category() ? 'class="current"' : '' ?>>
						<a href="/<?= $cat->slug; ?>"><?= __('Journal') ?></a>
					</li>
				<?php else: ?>
					<li><a href="<?= the_permalink($presentation) ?>"><?= $avenir ?></a></li>
				<?php endif ?>
				<?php if ($carte): ?>
					<?php $excludePosts[] = $carte; ?>
					<li <?= $post->ID === $carte ? 'class="current"' : ''; ?>>
						<a href="<?= the_permalink($carte) ?>"><?= __('Carte') ?></a>
					</li>
				<?php endif ?>
			</ul>
		</nav>
	</header>

<?php endif; ?>