<?php 
get_header();

while (have_posts()) {
    the_post(); ?>

<section class="py-5">
    <div class="container mt-5">
        <h3 class="text-center">Let's find out something important for you!</h3>
        <div class="page-content-area mt-5">
            <?php get_search_form(); ?>
        </div>
    </div>
</section>

<?php }
get_footer();
?>