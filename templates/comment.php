<?php echo get_avatar($comment, $size = '48'); ?>
<div class="comment-body">
  <div class="comment-header">
    <h4 class="comment-heading"><?php echo get_comment_author_link(); ?></h4>
    <time datetime="<?php echo comment_date('c'); ?>"><?php printf(__('%1$s à %2$s', 'html5blank'), get_comment_date(),  get_comment_time()); ?></time>
  </div>

  <div class="comment-content">
  <?php if ($comment->comment_approved == '0') : ?>
    <div class="alert alert-info">
      <?php _e('Your comment is awaiting moderation.', 'html5blank'); ?>
    </div>
  <?php endif; ?>
  <?php comment_text(); ?>
  </div>

  <div class="comment-action">
    <?php comment_reply_link(array_merge(
      array('reply_text'=> sprintf(__('%s Reply', 'html5blank'), '<i class="fa fa-reply"></i>')), 
      array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
    <?php edit_comment_link( sprintf(__('%s edit', 'html5blank'), '<i class="fa fa-pencil"></i>') ); ?>
  </div>