jQuery(document).ready(function ($) {
    $('.star-toggle').on('click', function () {
        var $icon = $(this);
        var postId = $icon.data('post');

        $.post(FeaturedPostsAjax.ajax_url, {
            action: 'toggle_featured_post',
            post_id: postId,
            nonce: FeaturedPostsAjax.nonce
        }, function (response) {
            if (response.success) {
                if (response.data.status === 'added') {
                    $icon.removeClass('dashicons-star-empty').addClass('dashicons-star-filled');
                } else {
                    $icon.removeClass('dashicons-star-filled').addClass('dashicons-star-empty');
                }
            } else {
                alert(response.data.message);
            }
        });
    });
});
