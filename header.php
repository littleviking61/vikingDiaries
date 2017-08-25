<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />
		<meta name="google-site-verification" content="tEaaQeh1K5Ii2WAFTrQhXc8HAv-8J5EwWM1dcYkBTc4" />
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
		// get cat terms
		if(is_single()){
			$cat = wp_get_post_terms($post->ID, 'category', array("fields" => "all"))[0];
		}elseif(is_category()){
			$cat = get_queried_object();
		}
		// check file and add bg
		if(file_exists(get_template_directory()."/img/bg-".$cat->slug.".jpg")) {
			$background = 'style="background-image: url('.get_template_directory_uri().'/img/bg-'.$cat->slug.'.jpg);background-position:bottom center;"';
		}
		/* todo ajouter image par defaut pour categorie */
	?>
	<body <?php body_class(); ?> <?= $background ?> >
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
					<div class="social right">
						<?php html5blank_nav('social-menu'); ?>
					</div>
					<li class="show-for-small show-menu"><span><?= __('Menu', 'html5blank') ?></span><span class="burger"><span></span></span></li>
					<?php if ( current_user_can('manage_options') ): 
						edit_post_link('<i class="fa fa-pencil"></i>', '<div class="edit">', '</div>'); 
					endif; ?>
				</nav>
    </div>
				<!-- /nav -->

		</header>
		<!-- /header -->

		<!-- wrapper -->
		<div class="wrapper">
