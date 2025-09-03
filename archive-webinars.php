<?php 
get_header(); ?>

<section class="py-5">
  <div class="container mt-5">
    <div class="row">
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-black">Webinars</h2>
          <div class="mb-2 text-black"><a class="btn-see-more" href="<?php echo site_url('/past-webinars'); ?>">Past Webinars<img class="up-left-icon"
                src="<?php echo esc_url(get_theme_file_uri('assets/icon/up-left rounded black.svg'));?>" alt=""></a></div>
        </div>
    </div>
      <hr class="hr-style border-black">
    <div class="row gy-4 gx-sm-5 mt-2">

      <?php
      while (have_posts()){
        the_post();
        $webinars_posts_cat = get_the_category(); ?>
        <div class="col-6 col-md-6 col-lg-4 card-width">
                <div class="card card-max-width border-1">
                  <div class="card-img-box__carousel">
                    <img src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" class="card-img-top card-img--resp__carousel"
                      alt="Card image 2">
                  </div>
                  <div class="card-body px-3 py-3">
                  <?php 
                if (!empty($webinars_posts_cat)) { ?>
                  <!-- // Find the first subcategory (parent != 0) -->
                  <small class="card-category">
                      <?php echo esc_html($webinars_posts_cat[0]->name); ?>
                  </small>
              <?php }
                ?>
                    <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <p class="card-text"><?php if(has_excerpt()){
                    echo get_the_excerpt();
                } else {
                    echo wp_trim_words(get_the_content(), 25);
                } ?></p>
                  </div>
                  <div class="card-footer"><?php the_field('webinar_date_time'); ?></div>
                </div>
              </div>
      <?php }
      echo paginate_links();
      ?>
      </div>
    </div>
</section>

<?php 
get_footer();
?>