<?php 
	load_the_template( 'ajax-header.php' );

	global $wp_query;
	$args = array_merge( $wp_query->query_vars, array( 'category__not_in' => array( 165 )  ) );
	query_posts( $args ); ?>

<?php get_template_part('loop'); ?>
</html>