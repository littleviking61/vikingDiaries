<?php 
$content = get_the_content( __('Read more &rarr;', 'html5blank') );
$type = get_post_format();
?>

<li <?php post_class(); ?> data-date="<?= get_the_time('U'); ?>" id="post-<?= $post->ID ?>">
  <?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title); ?>
    
      <a href="<?php the_permalink(); ?>" class="ajax-go"><?php the_title(); ?></a>
      <p><?php the_excerpt() ?></p>

</li>