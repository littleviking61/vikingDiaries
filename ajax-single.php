<div class="ajax-content">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<?php 
			  $content = get_the_content( __('Lire la suite &rarr;', 'dw-timeline') );
			  $type = get_post_format();
			?>
			
			<article <?php post_class(); ?>>
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

			  <footer>
			    <!-- <?php get_template_part('templates/map'); ?> -->
			  </footer>

			  <div class="quick-comment-box form-group">
			    <?php 
			      global $current_user;
			      get_currentuserinfo();
			      echo get_avatar( $current_user->ID, 16); 
			      echo '<strong class="quick-comment-user-name">'.$current_user->display_name.'</strong>';
			    ?>
			    <textarea class="form-control" name="quick-comment-content" id="quick-comment-content" rows="1" placeholder="<?php _e('Leave a note','dw-timeline') ?>"></textarea>
			    <input type="button" class="btn btn-link" value="<?php _e('Save','dw-timeline') ?>">
			    <input type="button" class="btn btn-link" value="<?php _e('Cancel', 'dw-timeline'); ?>">
			  </div>
	
				<?php comments_template('/templates/comments.php'); ?>
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
</div>