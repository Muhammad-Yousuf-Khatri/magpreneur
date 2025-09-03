<?php 
get_header(); ?>

<section class="py-5">
    <div class="container mt-5">
    <div class="row">
      <?php get_search_form(); ?>
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-black">You searched for &ldquo; <?php echo esc_html(get_search_query(false)); ?> &rdquo;</h2>
        </div>
      </div>
      <hr class="hr-style border-black">
      <div class="row gy-4 gx-sm-5 mt-2">
        <?php 
    if(have_posts()){
      while (have_posts()){
        the_post();
        $blog_posts_cat = get_the_category(); ?>
        <div class="col-lg-4 col-sm-6">
          <div class="card mob-card-view card-max-width">
            <div class="col-4 col-sm-12 py-0 card-img-box">
              <img src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" class="card-img-top rounded card-img--resp"
                alt="Card image 1">
            </div>
            <div class="col-8 col-sm-12">
              <div class="card-body">
                  <small class="card-category">
                    <?php
                    if(get_post_type() == 'webinars'){
                        ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link('webinars')); ?>">Webinars</a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo esc_url(get_category_link($blog_posts_cat[0]->term_id)); ?>">
                        <?php echo esc_html($blog_posts_cat[0]->name); ?>
                        </a>
                        <?php
                    }
                    ?>
              </small>
                <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p class="card-text"><?php if(has_excerpt()){
                    echo get_the_excerpt();
                } else {
                    echo wp_trim_words(get_the_content(), 25);
                } ?></p>
                <div class="card--meta d-flex align-items-center">
                  <div class="card--meta__author">
                    <a class="d-flex align-items-center" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                      <div class="me-2"><img class="card--meta__author--img"
                          src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" alt=""></div>
                      <div class="card--meta__author--name"><?php echo esc_html(get_the_author()); ?></div>
                    </a>
                  </div>
                  <span class="card--meta__separator mx-2">-</span>
                  <time class="card--meta__time"><?php the_time('j-M-y') ?></time>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php }
      echo paginate_links();
    } else {?>
        <p class="mb-0">No results match that search</p>
    <?php }
        ?>
      </div>
    </div>
</section>

<?php 
get_footer();
?>