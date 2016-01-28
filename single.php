<?php get_header(); ?>

	<main role="main">
		
		<?php get_template_part('header', 'projet'); ?>
		
			<?php
			
			$args = array( 'posts_per_page' => 100, 'category' => $cat->term_id );
			$myposts = get_posts( $args ); $positionArticle = 0; $actifPostId = $post->ID;
			foreach ( $myposts as $post ) : 
				setup_postdata( $post );
				if($post->ID === $actifPostId) break;
				$positionArticle++; 
			endforeach; 

			wp_reset_postdata();
			$perPage = get_option( 'posts_per_page' ); ?>

			<div class="pagination top">
				<a class="more-link" href="<?= get_category_link($cat). 'page/'. ceil($positionArticle / $perPage).'/' ?>">
					<?= __('Retourner sur le journal') ?>
				</a>
			</div>

			<!-- section -->
			<section class="dairies middle-line">
			

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<!-- article -->
				<?php 
				  $content = get_the_content( __('Lire la suite &rarr;', 'dw-timeline') );
				  $type = get_post_format();
				?>
				<article <?php post_class('open'); ?>>
					<div class="short">
						
						<?php if ( has_shortcode( $content, 'gallery' ) && $type == "gallery" ) :
						  $pattern = get_shortcode_regex();
						  preg_match('/'.$pattern.'/s', $post->post_content, $matches);
						  if (is_array($matches) && $matches[2] == 'gallery') { ?>
						    <div class="thumbnail gallerie">
						      <?= do_shortcode( $matches[0] ); ?>
						  </div>
					  	<?php };

						elseif(get_field('video') && $type == "video") : ?>

						  <div class="thumbnail oEmbed">
						    <?= get_field('video') ?>
						  </div>
						<?php elseif(has_post_thumbnail()) : ?>
						  <div class="thumbnail image">
						    <a href="<?php the_permalink(); ?>" class="ajax-go"><?php the_post_thumbnail('large', ['class'=> 'lazy']); ?></a>
						    <!--<div class="overlay">    
						      <span class="entry-date"><a href="<?php the_permalink(); ?>"><time class="published" datetime="<?= get_the_time('c'); ?>"><?= get_the_date('F Y'); ?></time></a></span>
						    </div>-->
						  </div>

						<?php endif; ?>
					</div>
					<div class="complete">
						<header>
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<?php get_template_part('templates/entry-meta'); ?>
						</header>
						<hr>
						<div class="entry-content">
							<?php if ( has_shortcode( $content, 'gallery' ) && $type == "gallery" ) :
							$pattern = get_shortcode_regex();
							preg_match('/'.$pattern.'/s', $post->post_content, $matches);
							if (is_array($matches) && $matches[2] == 'gallery') {

								echo do_shortcode( $matches[0] );
							};
							$content = strip_shortcodes($content, 'gallery');
							elseif(get_field('video') && $type == "video") :
								echo get_field('video');
							endif; ?>
							<p><?= apply_filters('the_content', $content) ?></p>
							<?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'dw- timeline'), 'after' => '</p></nav>')); ?>
						</div>

						<?php comments_template('/templates/comments.php'); ?>
					</div>
				</article>
				<!-- /article -->

			<?php endwhile; ?>

			<?php else: ?>

			<!-- article -->
			<article>

				<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>

		<div class="pagination">
			<a class="more-link" href="<?= get_category_link($cat). 'page/'. ceil($positionArticle / $perPage).'/' ?>">
				<?= __('Retourner sur le journal') ?>
			</a>
		</div>
	<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
