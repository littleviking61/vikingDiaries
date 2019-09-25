<?php
  if (post_password_required()) {
    return;
  } ?>

<div class="entry-comments" id="comments">

  <?php if (have_comments() || count($comments) > 0) : ?>
    <section class="comments">
      <h3>
        <i class="fa fa-comments"></i>&nbsp;
        <?php 
          printf( __('Une réponse pour &ldquo; %2$s &rdquo;', '%1$s réponses pour &ldquo; %2$s &rdquo;', 
            get_comments_number(), 'html5blank'), 
            number_format_i18n(get_comments_number()), 
            get_the_title()); 
        ?>
      </h3>

      <ol class="comment-list">
        <?php wp_list_comments(array('walker' => new DW_Timeline_Walker_Comment), $comments); ?>
      </ol>

      <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav>
        <ul class="pager">
          <?php if (get_previous_comments_link()) : ?>
            <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'html5blank')); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'html5blank')); ?></li>
          <?php endif; ?>
        </ul>
      </nav>
      <?php endif; ?>

      <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
        <div class="alert alert-warning">
          <?php __('Comments are closed.', 'html5blank'); ?>
        </div>
      <?php endif; ?>
    </section><!-- /#comments -->
  <?php else: ?>
    
  <?php endif; ?>

  <?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <section class="comments">
      <div class="alert alert-warning">
        <?php __('Comments are closed.', 'html5blank'); ?>
      </div>
    </section><!-- /#comments -->
  <?php endif; ?>
  <?php
    $comments_args = array(
      'logged_in_as' => '',
      'title_reply'  => __('And you, what to you think ?', 'html5blank'),
      'label_submit' => __('Send a comment', 'html5blank'),
      'comment_notes_before' => '',
      'comment_notes_after' => '',
      'fields' => apply_filters( 'comment_form_default_fields', array(
        'author' =>
          '<div class="form-group '. ( $req ? 'required' : '' ) .' ">' .
          '<label for="author">' . __( 'Name', 'html5blank' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
          '<input placeholder="' . __( 'Name', 'html5blank' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
          '" class="form-control" /></div>',

        'email' =>
          '<div class="form-group '. ( $req ? 'required' : '' ) .' "><label for="email">' . __( 'Email', 'html5blank' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
          '<input placeholder="' . __( 'Email', 'html5blank' ) . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
          '" class="form-control" /></div>',

        'url' =>
          '<div class="form-group"><label for="url">' .
          __( 'Website', 'html5blank' ) . '</label>' .
          '<input placeholder="' . __( 'Website', 'html5blank' ) . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
          '" class="form-control" /></div>'
        )
      ),
      'comment_field' => '<div class="form-group"><label for="comment">' . __( 'Comment', 'html5blank' ) . '</label><textarea placeholder="' . __( 'Looking forward to reading you !', 'html5blank' ) . '" name="comment" id="comment" class="form-control" rows="5" aria-required="true"></textarea></div>',
    );

    comment_form($comments_args); ?>
    
</div>
