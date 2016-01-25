<?php while (have_posts()) : the_post(); ?>
	<div class="page-content">
  	<?php the_content(); ?>
  	<?php wp_link_pages(array('before' => '<nav class="pagination" role="seealso">', 'after' => '</nav>')); ?>
  </div>
<?php endwhile; ?>
