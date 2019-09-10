<div class="complete">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<?php 
			$content = get_the_content( __('Read more &rarr;', 'html5blank') );
			$type = get_post_format();
		?>

		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php //get_template_part('content', 'tools') ?>
			<?php get_template_part('templates/entry-meta'); ?>
		</header>

		<hr>
		<div class="entry-content">
			<?php if ($type == "gallery"): ?>			
				<?php //$content = strip_shortcodes($content, 'gallery'); ?>		
			<?php endif ?>
			<p><?= apply_filters('the_content', $content) ?></p>

		</div>
		<?php comments_template('/templates/comments.php'); ?>
		<!-- /article -->

	<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>

		<h1><?php __( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

	</article>
	<!-- /article -->

<?php endif; ?>
</div>