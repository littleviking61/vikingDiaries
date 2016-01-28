<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' : '; } ?><?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<?php 
		global $excludePosts;
		// get cat terms
		if(is_single()){
			$cat = wp_get_post_terms($post->ID, 'category', array("fields" => "all"))[0];
		}elseif(is_category()){
			$cat = get_queried_object();
		}
		// check file and add bg
		if(file_exists(get_template_directory()."/img/bg-".$cat->slug.".jpg")) {
			$background = 'style="background-image: url('.get_template_directory_uri().'/img/bg-'.$cat->slug.'.jpg);background-position:bottom center;"';
		}elseif(is_category()){
			$background = 'style="background-image: url('.get_template_directory_uri().'/img/bg-default.jpg);background-position:bottom center;"';
		}
		/* todo ajouter image par defaut pour categorie */
	?>
	<body <?php body_class(); ?> <?= $background ?>>
		<!-- header -->
		<header class="header clear skew" role="banner">
				<!-- logo -->
				<!-- 	<div class="logo">
					<a href="<?php echo home_url(); ?>">
						svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Logo" class="logo-img">
					</a>
				</div> -->
				<!-- /logo -->

				<!-- nav -->
				<nav class="nav" role="navigation">
					<?php html5blank_nav(); ?>
					<?php if ( current_user_can('manage_options') ): 
						edit_post_link('edit', '<div class="edit"><ul><li>', '</li></ul></div>'); 
					endif; ?>
					<div class="social right">
						<?php html5blank_nav('social-menu'); ?>
					</div>
				</nav>
    </div>
				<!-- /nav -->

		</header>
		<!-- /header -->

		<!-- wrapper -->
		<div class="wrapper">
