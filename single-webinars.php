<?php 
get_header();

while (have_posts()) {
    the_post(); ?>

<section class="pt-5 bg-light border-bottom">
    <div class="container post-head mt-5">
      <div class="row row-cols-1">
        
        <div class="col single-post--title">
          <h1 class="text-center"><?php the_title(); ?></h1>
        </div>

        <div class="col single-post--info d-flex align-items-center my-4">
            <div class="webinar-short-desc">
                <p class=""><?php if(has_excerpt()){
                    echo get_the_excerpt();
                } else {
                    echo wp_trim_words(get_the_content(), 25);
                } ?></p>
            </div>
        </div>

      </div>
    </div>
</section>

<section class="py-5 container">
  <div class="row justify-content-center">
    <div class="col post-body">
    <article>
      <?php the_content(); ?>
    </article>
    </div>
  </div>
</section>

<?php }
get_footer();
?>