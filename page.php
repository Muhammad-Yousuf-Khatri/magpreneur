<?php 
get_header();

while (have_posts()) {
    the_post(); ?>

<section class="py-5">
    <div class="container mt-5">
        <h1><?php the_title();?></h1>
        <div class="page-content-area mt-5">
        <div><?php the_content();?></div>
        </div>
    </div>
</section>

<?php }
get_footer();
?>