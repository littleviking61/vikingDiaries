<?php 
$content = get_the_content( __('Read more &rarr;', 'html5blank') );
$type = get_post_format();
?>
<article <?php post_class(); ?> data-date="<?= get_the_time('U'); ?>" id="post-<?= $post->ID ?>">
  
  <?php get_template_part('content', 'tools') ?>

  <div class="short">

    <?php if ( current_user_can('manage_options') ): 
      edit_post_link('edit', '<div class="edit-post">', '</div>'); 
    endif; ?>

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

    <div class="content">
      <header>
        <h2 class="entry-title">
          <a href="<?php the_permalink(); ?>" class="ajax-go"><?php the_title(); ?></a>
        </h2>
        <div class="tools-short">
          <ul>
            <li>
              <?= getPostLikeLink( get_the_ID() ) ?>
            </li>
            <li>
              <share-button data-url="<?php the_permalink(); ?>" data-title="<?php the_title() ?>" data-flyout="bottom left"></share-button></li>
            </li>
            <li>
              <a href="<?php the_permalink(); ?>" class="ajax-go comment" title="<?= __('Comment', 'html5blank') ?>" type="button" class="comment"><i class="fa fa-commenting"></i><span><?php comments_number( "", "&nbsp;%", "&nbsp;%" ); ?> </span></a>
            </li>
          </ul>
        </div>
      </header>
      <div class="entry-content">

        <?php if ( has_shortcode( $content, 'gallery' ) ) :
        $pattern = get_shortcode_regex();
        preg_match('/'.$pattern.'/s', $post->post_content, $matches);
        endif; 

        $content = strip_shortcodes($content, 'gallery'); 
        echo apply_filters('the_content', do_shortcode($content)); ?>

      </div>
      <hr>
      <?php get_template_part('templates/entry-meta'); ?>

    </div>

  </div>

</article>