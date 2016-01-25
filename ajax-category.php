<?php 
	load_the_template( 'ajax-header.php' );
	
	global $excludePosts;
	$cat = get_queried_object();
	$excludePosts[] = get_field('presentation', $cat);
	$excludePosts[] = get_field('carte', $cat);

	global $wp_query;
	$args = array_merge( $wp_query->query_vars, array( 'post__not_in' => $excludePosts  ) );
	query_posts( $args ); ?>

<?php get_template_part('loop'); ?>
</html>