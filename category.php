<?php 
	$cat = get_queried_object();
	$thumbnail = get_field('thumbnail', $cat);
	$presentation = get_field('presentation', $cat);
	$journal = get_field('journal', $cat);
	$carte = get_field('carte', $cat);
	$grand = get_field('en_grand', $cat);
	$avenir = get_field('a_venir', $cat);
?>

<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<header>


		</header>

		<section class="dairies">
			<?php get_template_part('loop'); ?>
			
			<?php get_template_part('pagination'); ?>
		</section>


		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
