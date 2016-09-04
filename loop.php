<?php if (have_posts()): while (have_posts()) : the_post();
	get_template_part('templates/content', get_post_format());
endwhile; ?>

<?php else: ?>
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
<?php endif; ?>
