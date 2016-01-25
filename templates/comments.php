<?php
  if (post_password_required()) {
    return;
  } ?>

<div class="<?= $ajax_class ?: 'comments-single' ?>">

  <?php if (have_comments() || count($comments) > 0) : ?>
    <section class="comments">
      <h3>
        <?php 
          printf( _n('One Response to &ldquo; %2$s &rdquo;', '%1$s Responses to &ldquo; %2$s &rdquo;', 
            get_comments_number(), 'dw-timeline'), 
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
            <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'dw-timeline')); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'dw-timeline')); ?></li>
          <?php endif; ?>
        </ul>
      </nav>
      <?php endif; ?>

      <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
      <div class="alert alert-warning">
        <?php _e('Comments are closed.', 'dw-timeline'); ?>
      </div>
      <?php endif; ?>
    </section><!-- /#comments -->
  <?php else: ?>
    <section class="comments no-comments">
      <h3>Aucun commentaire pour le moment</h3>
    </section><!-- /#comments -->
  <?php endif; ?>

  <?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <section class="comments">
      <div class="alert alert-warning">
        <?php _e('Comments are closed.', 'dw-timeline'); ?>
      </div>
    </section><!-- /#comments -->
  <?php endif; ?>
  <?php
    $comments_args = array(
      'logged_in_as' => '',
      'comment_notes_before' => '',
      'comment_notes_after' => '',
      'fields' => apply_filters( 'comment_form_default_fields', array(
        'author' =>
          '<div class="form-group '. ( $req ? 'required' : '' ) .' ">' .
          '<label for="author">' . __( 'Name', 'dw-timeline' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
          '<input placeholder="' . __( 'Name', 'dw-timeline' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
          '" class="form-control" /></div>',

        'email' =>
          '<div class="form-group '. ( $req ? 'required' : '' ) .' "><label for="email">' . __( 'Email', 'dw-timeline' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
          '<input placeholder="' . __( 'Email', 'dw-timeline' ) . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
          '" class="form-control" /></div>',

        'url' =>
          '<div class="form-group"><label for="url">' .
          __( 'Website', 'dw-timeline' ) . '</label>' .
          '<input placeholder="' . __( 'Website', 'dw-timeline' ) . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
          '" class="form-control" /></div>'
        )
      ),
      'comment_field' => '<div class="form-group"><label for="comment">' . __( 'Comment', 'dw-timeline' ) . '</label><textarea placeholder="' . __( 'Write your comment', 'dw-timeline' ) . '" name="comment" id="comment" class="form-control" rows="5" aria-required="true"></textarea></div>',
    );
    comment_form($comments_args); ?>
    
</div>

<button title="Close (Esc)" type="button" class="mfp-close">×</button>

<script>
  $('document').ready(function(){
    var commentform=$('#commentform'); // find the comment form
    commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
    var statusdiv=$('#comment-status'); // define the infopanel

    commentform.submit(function(){
        //serialize and store form data in a variable
        var formdata=commentform.serialize();
        //Add a status message
        statusdiv.html('<p>Processing...</p>');
        //Extract action URL from commentform
        var formurl=commentform.attr('action');
        //Post Form with data
        $.ajax({
            type: 'post',
            url: formurl,
            data: formdata,
            error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
                },
            success: function(data, textStatus){
                if(data == "success" || textStatus == "success"){
                    statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
                }else{
                    statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
                    commentform.find('textarea[name=comment]').val('');
                }
            }
        });
        return false;
    });
});
</script>
