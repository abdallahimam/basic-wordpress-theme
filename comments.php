<?php

if (comments_open()) {
    $comments_args = array(
        'max_depth'     => 3,
        'type'          => 'comment',
        'avatar_size'   => 50,
    );
    echo '<h6 class="comments-number">';
    comments_number('0 comment', '1 comment', '% comments');
    echo '</h6>';
    if (count($comments)) {
        echo '
            <div class="card">
                <div class="card-body p-2">
                    <ul class="list-unstyled my-post-comments-list">';
                        wp_list_comments($comments_args);
        echo        '</ul>
                </div>
            </div>';
    }
    echo '<hr class="comments-separator" />';
    $comment_form_args = array(
        /*
        'fields'        => array(
            'author'        => '<div class="form-group"><label for"autho">Your name</label><input class="form-control" type="text" required /></div>',
            'email'         => '<div class="form-group"><label for"email">Your email<small>(Your email address will not be published.)</small></label><input class="form-control" type="email" required /></div>',
            'url'           => '<div class="form-group"><label for"url">Your website<small>(Your website address will not be published.)</small></label><input class="form-control" type="url" /></div>'
        ),
        'comment_field' => '<div class="form-group"><label for"comment">Your Comment.</label><textarea class="form-control" required></textarea></div>',
        */
        'comment_notes_before' => '',
        'title_reply' => 'Add your comment',
        'title_reply_to' => 'Add reply to [ %s ]',
    );
    comment_form($comment_form_args);
} else {
    echo '
    <div class="card">
        <div class="card-body">Comments disabled.</div>
    </div>
    ';
}