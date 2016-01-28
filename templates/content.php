<?php 
$content = get_the_content( __('Lire la suite &rarr;', 'dw-timeline') );
$type = get_post_format();
?>
<article <?php post_class(); ?> data-date="<?= get_the_time('U'); ?>" id="post-<?= $post->ID ?>">
  
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
        <div class="social">
          <span class="entry-comments"><a class="ajax-go" title="Commentaire : <?php the_title(); ?>" href="<?php the_permalink(); ?>#comments"><i class="fa fa-comments"></i> <?php comments_number( '0', '1', '%' ); ?></a></span>
          <?= getPostLikeLink( get_the_ID() ) ?>

          <?php if (!is_null($icon)) : ?>
           <i class="glyphicon glyphicon-<?= $icon ?>"></i>
          <?php endif ?>
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