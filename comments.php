<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="d-flex justify-content-center comments-area border-top py-5">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            printf(
                _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title' ),
                number_format_i18n( get_comments_number() )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php
    // If comments are closed but there are comments, show a message
    if ( ! comments_open() && get_comments_number() ) :
    ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.' ); ?></p>
    <?php endif; ?>

    <?php
$comments_args = array(
    'class_form'   => 'comment-form', // Form wrapper class
    'class_submit' => 'btn-subscribe py-1 mt-3', // Submit button classes
    'label_submit' => 'Post Comment',

    // Comment textarea
    'comment_field' => '
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea id="comment" name="comment" class="form-control" rows="5" required></textarea>
        </div>
    ',

    // Other fields
    'fields' => array(
        'author' =>
            '<div class="mb-3">
                <label for="author" class="form-label">Name</label>
                <input id="author" name="author" type="text" class="form-control" required />
            </div>',
        'email' =>
            '<div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" class="form-control" required />
            </div>',
        'url' =>
            '<div class="mb-3">
                <label for="url" class="form-label">Website</label>
                <input id="url" name="url" type="url" class="form-control" />
            </div>',
    ),

    // Remove default notes
    'comment_notes_before' => '',
    'comment_notes_after'  => '',
);

comment_form($comments_args);
?>


</div>
