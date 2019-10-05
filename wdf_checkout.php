<?php
// return home if not form as been complete
if (!isset($_POST['wdf_pledge'])) {
	header('Status: 301 Moved Permanently', false, 301);
	header('Location: /contribuer/du-film-au-livre/');
}
// check selected reward
global $wdf;
if(isset($_SESSION['wdf_reward']) && $_SESSION['wdf_reward'] < 3) {
		do_action('wdf_gateway_pre_process_'.$_SESSION['wdf_gateway']);
		do_action('wdf_gateway_process_'.$_SESSION['wdf_type'].'_'.$_SESSION['wdf_gateway']);
}else{ ?>

<?php get_header(); ?>

	<main role="main">

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
					<!-- article -->
					<header class="banner">
						<div class="thumbnail circle">
							<?php 
							$image = get_field('photo_auteur');
							if( !empty($image) ): ?>
								<img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
							<?php endif; ?>
						</div>
						<h1>
							<?= __('I just need your adress','html5blank') ?>
						</h1>
						<h2><?= __('Thanks') ?></h2>
					</header>

					<section class="fundraising">
						<div class="content-fundraising">
							<?php the_content(); ?>
						</div>
						<div class="pannel-fundraising wdf-no-checkout">
							<?php wdf_fundraiser_panel() ?>
						</div>
					</section>

			</article>
			<!-- /section -->

			<?php endwhile; ?>
		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php __( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
<?php } ?>