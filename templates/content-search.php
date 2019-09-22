<?php 
$content = get_the_content( __('Read more &rarr;', 'html5blank') );
$type = get_post_format();
?>

<article <?php post_class(); ?> data-date="<?= get_the_time('U'); ?>" id="post-<?= $post->ID ?>">
  <?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title); ?>
    
     	<?php if(has_post_thumbnail()) : ?>
	      <div class="thumbnail image">
	        <a href="<?php the_permalink(); ?>" class="ajax-go"><?php the_post_thumbnail('medium', ['class'=> 'lazy']); ?></a>
	        <!--<div class="overlay">    
	          <span class="entry-date"><a href="<?php the_permalink(); ?>"><time class="published" datetime="<?= get_the_time('c'); ?>"><?= get_the_date('F Y'); ?></time></a></span>
	        </div>-->
	      </div>
    	<?php endif; ?>

     <div class="content">

     	<h2><a href="<?php the_permalink(); ?>" class="ajax-go"><?php the_title(); ?></a></h2>
     	<p><?php the_excerpt() ?></p>
      <?php get_template_part('templates/entry-meta'); ?>
     </div>

</article>