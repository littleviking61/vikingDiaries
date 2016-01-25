<?php if (have_posts()): while (have_posts()) : the_post(); ?><!-- 
	article 
	--><?php get_template_part('templates/content', get_post_format()); ?>
	<!-- 
	/article 
--><?php endwhile; ?>

<?php else: ?><!-- 
	article 
	--><article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article><!-- 
	/article 
--><?php endif; ?>
