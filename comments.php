<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
        <?php
        $count = get_comments_number();
        echo $count === '1'
            ? '1 Comment'
            : $count . ' Comments';
        ?>
    </h2>

    <ol class="comment-list">
        <?php
        wp_list_comments( array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 44,
        ));
        ?>
    </ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    <nav class="comment-navigation">
        <div><?php previous_comments_link( '← Older Comments' ); ?></div>
        <div><?php next_comments_link( 'Newer Comments →' ); ?></div>
    </nav>
    <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply'         => 'Leave a Comment',
        'title_reply_before'  => '<h3 class="comment-reply-title">',
        'title_reply_after'   => '</h3>',
        'label_submit'        => 'Post Comment',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'fields' => array(
            'author' => '<div class="comment-form-field">
                <label for="author">Name <span class="required">*</span></label>
                <input id="author" name="author" type="text" required>
            </div>',
            'email'  => '<div class="comment-form-field">
                <label for="email">Email <span class="required">*</span></label>
                <input id="email" name="email" type="email" required>
            </div>',
            'url'    => '',
        ),
        'comment_field' => '<div class="comment-form-field">
            <label for="comment">Comment <span class="required">*</span></label>
            <textarea id="comment" name="comment" rows="5" required></textarea>
        </div>',
    ));
    ?>

</div>