<?php
if ( post_password_required() ) {
    return;
}
?>
<div class="d-flex justify-content-center border-top py-5 row">
<div id="comments" class="comments-area col col-sm-8">

    <?php if ( have_comments() ) : ?>
        <h5 class="comments-title border-bottom pb-2">
            <?php
            printf(
                _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title' ),
                number_format_i18n( get_comments_number() )
            );
            ?>
        </h5>

        <ol class="comment-list list-unstyled">
    <?php
    
    wp_list_comments( array(
        'style'       => 'ol',
        'short_ping'  => true,
        'avatar_size' => 48, // small avatar
        'callback'    => function($comment, $args, $depth) {
            ?>
            <li <?php comment_class( 'mb-3' ); ?> id="comment-<?php comment_ID(); ?>">
                <div class="d-flex">
                    <div class="me-3">
                        <?php echo get_avatar( 
                            $comment, 
                            $args['avatar_size'], 
                            '',
                            '',
                            array('class' => 'rounded-circle')
                        ); ?>
                    </div>
                    <div>
                        <div class="comment-meta">
                            <strong><?php comment_author(); ?></strong>
                            <span class="text-muted small"><?php comment_date(); ?></span>
                        </div>
                        <div class="comment-text">
                            <?php comment_text(); ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php
        }
    ) );
    ?>
</ol>

            
        <?php the_comments_navigation();
        
    endif;


    // If comments are closed but there are comments, show a message
    if ( ! comments_open() && get_comments_number() ) :
    ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.' ); ?></p>
    <?php endif;

$comments_args = array(
    'class_form'   => 'comment-form',
    'class_submit' => 'btn-subscribe py-1 mt-3',
    'label_submit' => 'Post Comment',
    'must_log_in' => '
        <p class="alert bg-light border p-3 rounded">
            You must 
            <a href="' . wp_login_url(get_permalink()) . '" class="btn btn-dark-to-light mx-1">Login</a> 
            or 
            <a href="' . wp_registration_url() . '" class="btn btn-subscribe mx-1">Register</a> 
            to post a comment.
        </p>
    ',

    'comment_field' => '
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea id="comment" name="comment" class="form-control" rows="5" required></textarea>
        </div>
    ',

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

    'comment_notes_before' => '',
    'comment_notes_after'  => ''
);

if(is_user_logged_in()){
    comment_form($comments_args);   
} else { ?>
    <div>
    <p class="alert bg-light border p-3 rounded">
        You must 
        <a href="' . wp_login_url(get_permalink()) . '" class="btn btn-dark-to-light mx-1">Login</a> 
        or 
        <a href="' . wp_registration_url() . '" class="btn btn-subscribe mx-1">Register</a> 
        to post a comment.
    </p>
    </div>
<?php }
?>


</div>
</div>
