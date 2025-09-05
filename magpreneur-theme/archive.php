<?php 
get_header(); ?>

<section class="py-5">
    <div class="container mt-5">
    <div class="row">
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-black"><?php single_cat_title(); ?></h2>
        </div>
      </div>
      <hr class="hr-style border-black">
      <div class="row gy-4 gx-sm-5 mt-2">

      <?php
      while (have_posts()){
        the_post();
        $blog_posts_cat = get_the_category(); 
        get_template_part('templates/card',);
      }
      wp_reset_postdata(); 
      ?>
      </div>
    </div>
</section>

<?php 
get_footer();
?>