<?php 
	global $cat;

	if(is_category()) {
		$cat = get_queried_object();
	}else{
		$cat = wp_get_post_terms($post->ID, 'category', array("fields" => "all"));

		// to deal with double cat
		if(count($cat) > 1) {
			foreach ($cat as $categ) {
				if($categ->term_id !== 153) {
					$cat = $categ;
					break;
				}
			}
		}else{
			$cat = $cat[0];
		}
	}
	$thumbnail = get_field('thumbnail', $cat);
	$presentation = get_field('presentation', $cat);
	$journal = get_field('journal', $cat);
	$grand = get_field('en_grand', $cat);
	$avenir = get_field('a_venir', $cat);
	$icone = get_field('icone', $cat);
	$carte = get_field('carte', $cat);
	$autre_page = get_field('autre_page', $cat);
	$lien_autre_page = get_field('lien_autre_page', $cat);
	$titre_autre_page = get_field('titre_autre_page', $cat);
?>
<?php if ($cat->term_id !== 153 && ($post->ID === $presentation || $post->ID === $carte || is_category())): ?> 
	<header class="banner <?= $post->ID === $presentation ? 'presentation' : ($post->ID === $carte ? 'carte' : '') ?>">
		<div class="thumbnail">
			<?php 
			$image = get_field('photo_auteur');
			if( !empty($icone) ): ?>
				<img src="<?= $icone['url']; ?>" alt="<?= $icone['alt']; ?>" />
			<?php else: ?>
				<img src="/wp-content/uploads/2016/01/viking-first.svg" />
			<?php endif; ?>
		</div>
		<h1><?= __('Diaries', 'html5blank');?></h1>
		<h2><?= apply_filters('the_title', $cat->name); ?></h2>
		<nav>
			<ul>
				<?php if ($presentation): ?>
					<li <?= $post->ID === $presentation && !is_category() ? 'class="current"' : ''; ?>>
						<a href="<?= the_permalink($presentation) ?>"><?= __('Presentation') ?></a>
					</li>
				<?php endif ?>
				<?php if ($journal): ?>
					<li <?= is_category() ? 'class="current"' : '' ?>>
						<a href="/<?= $cat->slug; ?>"><?= __('Diaries', 'html5blank') ?></a>
					</li>
				<?php endif ?>
				<?php if (!empty($avenir)): ?>
					<li><a href="<?= the_permalink($presentation) ?>"><?= $avenir ?></a></li>
				<?php endif ?>
				<?php if ($autre_page): ?>
					<li><a href="<?= the_permalink($lien_autre_page) ?>"><?=  __($titre_autre_page, 'html5blank') ?></a></li>
				<?php endif ?>
				<?php if ($carte): ?>
					<li <?= $post->ID === $carte && !is_category() ? 'class="current"' : ''; ?>>
						<a href="<?= the_permalink($carte) ?>"><?= __('Map', 'html5blank') ?></a>
					</li>
				<?php endif ?>
			</ul>
		</nav>
	</header>

<?php elseif(is_single() && $cat->term_id !== 153): ?>

	<header class="banner short">
		<h1><?= __('Diaries', 'html5blank');?></h1>
		<h2><?= apply_filters('the_title', $cat->name) ?></h2>
	</header>

<?php elseif($cat->term_id === 153): ?>

	<header class="banner short">
		<h1><?= __('News', 'html5blank');?></h1>
		<h2><?= apply_filters('the_title', $cat->name) ?></h2>
	</header>

<?php endif; ?>