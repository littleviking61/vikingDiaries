<div class="complete">
  <button title="Close (ESC)" type="button" class="mfp-close">×</button>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<?php 
			$content = get_the_content( __('Lire la suite &rarr;', 'dw-timeline') );
			$type = get_post_format();
		?>

		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php get_template_part('templates/entry-meta'); ?>
		</header>

		<share-button data-url="<?php the_permalink(); ?>" data-title="<?php the_title() ?>"></share-button>

		<hr>
		<div class="entry-content">
			<?php //$content = strip_shortcodes($content, 'gallery'); ?>		
			<p><?= apply_filters('the_content', $content) ?></p>
			<?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'dw- timeline'), 'after' => '</p></nav>')); ?>
		</div>
		<?php comments_template('/templates/comments.php'); ?>
		<!-- /article -->

	<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>

		<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

	</article>
	<!-- /article -->

<?php endif; ?>
</div>