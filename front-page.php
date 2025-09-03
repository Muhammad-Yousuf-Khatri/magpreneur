<?php get_header();?>

  <!-- Banner Section -->
  <section class="pt-5 mt-5">
    <?php
    $banner_images = wp_is_mobile()? 'smallBanner' : 'largeBanner';
    $carousel_posts = new WP_Query(array(
    'posts_per_page' => 3,
    'post_type' => 'post',
    'orderby' => 'ID',
    'order' => 'DESC'
    ));

    $first = true;
    // print_r($carousel_posts);
    ?>
    <div class="container">
      <div id="bannerCarousel" class="carousel slide rounded" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <?php while($carousel_posts->have_posts()){
            $carousel_posts->the_post(); 
            $banner_pic_id = get_post_thumbnail_id(get_the_ID());
            ?>
          <div class="carousel-item <?php echo $first? 'active' : ''; ?>">
            <?php 
            echo wp_get_attachment_image($banner_pic_id, 'largeBanner', false, [
              'class' => 'd-block w-100',
              'sizes' => '(min-width: 576px) 1280px, 350px',
            ]);
            ?>
            <div class="carousel-caption">
              <h2 class="banner-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
            </div>
          </div>

          <?php
          $first = false;
        }
        wp_reset_postdata();  
        ?>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon my-control" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon my-control" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>


  <!-- Editor's Choice -->
  <section class="py-5">
    <div class="container editor-container">
      <div class="row row-cols-1 row-cols-lg-2 gx-lg-5">
        <div id="editor-choice" class="col-lg-8">
          <div class="row-cols-1">
            <h2>Editor's Choice</h2>
            <hr class="hr-style">
          </div>
          <div class="row row-cols-1 row-cols-sm-2 gy-4 pt-3 gx-sm-5">
            <div class="col">
              <div class="card mob-card-view card-max-width">
                <div class="col-4 col-sm-12 py-0 card-img-box">
                  <img src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" class="card-img-top rounded card-img--resp"
                    alt="Card image 1">
                </div>
                <div class="col-8 col-sm-12">
                  <div class="card-body">
                    <small class="card-category"><a href="">Category</a></small>
                    <h5 class="card-title"><a href="">Card title</a></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                    <div class="card--meta d-flex align-items-center">
                      <div class="card--meta__author">
                        <a class="d-flex align-items-center" href="">
                          <div class="me-2"><img class="card--meta__author--img"
                              src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" alt=""></div>
                          <div class="card--meta__author--name">Author Name</div>
                        </a>
                      </div>
                      <span class="card--meta__separator mx-2">-</span>
                      <time class="card--meta__time">date</time>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card mob-card-view card-max-width">
                <div class="col-4 col-sm-12 py-0 card-img-box">
                  <img src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" class="card-img-top rounded card-img--resp"
                    alt="Card image 1">
                </div>
                <div class="col-8 col-sm-12">
                  <div class="card-body">
                    <small class="card-category"><a href="">Category</a></small>
                    <h5 class="card-title"><a href="">Card title</a></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                    <div class="card--meta d-flex align-items-center">
                      <div class="card--meta__author">
                        <a class="d-flex align-items-center" href="">
                          <div class="me-2"><img class="card--meta__author--img"
                              src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" alt=""></div>
                          <div class="card--meta__author--name">Author Name</div>
                        </a>
                      </div>
                      <span class="card--meta__separator mx-2">-</span>
                      <time class="card--meta__time">date</time>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card mob-card-view card-max-width">
                <div class="col-4 col-sm-12 py-0 card-img-box">
                  <img src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" class="card-img-top rounded card-img--resp"
                    alt="Card image 1">
                </div>
                <div class="col-8 col-sm-12">
                  <div class="card-body">
                    <small class="card-category"><a href="">Category</a></small>
                    <h5 class="card-title"><a href="">Card title</a></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                    <div class="card--meta d-flex align-items-center">
                      <div class="card--meta__author">
                        <a class="d-flex align-items-center" href="">
                          <div class="me-2"><img class="card--meta__author--img"
                              src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" alt=""></div>
                          <div class="card--meta__author--name">Author Name</div>
                        </a>
                      </div>
                      <span class="card--meta__separator mx-2">-</span>
                      <time class="card--meta__time">date</time>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="popular-now" class="col-lg-4">
          <?php 
          $popular_posts = new WP_Query(array(
            'posts_per_page' => 6,
            'post_type' => 'post',
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
          ));
          ?>
          <div class="row-cols-1">
            <h2>Popular Now</h2>
            <hr class="hr-style">
          </div>
          <ol class="group-num-list px-0">
            <div class="row row-cols-1 pt-3 gy-4">
              <?php 
              while($popular_posts->have_posts()){
               $popular_posts->the_post();
              ?>
                <div class="col">
                <div class="card mb-2">
                  <div class="row g-0">
                    <div class="col-md-2 col-lg-4 col-xl-3 card-img-box">
                      <img src="<?php the_post_thumbnail_url('circularCard');?>"
                        class="img-fluid rounded-circle card-img--resp__vertical" alt="...">
                    </div>
                    <div class="col-md-10 col-lg-8 col-xl-9">
                      <div class="card-body mob-list">
                        <li class="item-num"></li>
                        <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              <?php 
              }
              wp_reset_postdata();
              ?>

            </div>
          </ol>
        </div>

      </div>
      <div class="home-featured-banner image-fluid p-4 mt-3 rounded" style="background-image: url(<?php echo get_theme_file_uri('assets/img/2.jpg');?>);">
        <div class="home-featured-banner__content">
          <small class="card-category"><a href="">Category</a></small>
          <h2 class="home-featured-banner__title mb-2"><a href="">Title of The Article</a></h2>
          <hr>
          <div class="home-featured-banner__info d-flex mb-2">
            <time class="me-3">date</time>
            <div class="me-3">
              <i class="fa-solid fa-heart"></i>
              <small>10</small>
            </div>
            <div class="me-3">
              <i class="fa-solid fa-comment"></i>
              <small>3</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Startups -->
  <section class="py-4">
    <?php 
          $startupsPosts = new WP_Query(array(
            'posts_per_page' => 6,
            'category_name' => 'startups'
          ));
          $startups_category = get_category_by_slug('startups');
          if ($startups_category) {
            $startups_category_link = get_category_link($startups_category->term_id);
          } else {
            $startups_category_link = NULL;
          }
    ?>
    <div id="startups" class="container startups-container">
      <div class="row">
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-black">Startups</h2>
          <div class="mb-2 text-black"><a class="btn-see-more" href="<?php echo esc_url($startups_category_link); ?>">See More<img
                src="<?php echo esc_url(get_theme_file_uri('assets/icon/up-right rounded black.svg'));?>" alt=""></a></div>
        </div>
      </div>
      <hr class="hr-style border-black">
      <div class="row gy-4 gx-sm-5 mt-2">

      <?php
      while ($startupsPosts->have_posts()){
        $startupsPosts->the_post(); 
        get_template_part('templates/card',);
      }
      wp_reset_postdata(); 
      ?>
      </div>
    </div>
  </section>

  <!-- Webinars -->
  <section id="webinars" class="py-5 my-4 overflow-hidden">

  <?php
  $todayDate = date('Ymd');
  $homepageWebinars = new WP_Query(array(
    'posts_per_page' => 6,
    'post_type' => 'webinars',
    'meta_key' => 'webinar_date_time',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'webinar_date_time',
        'compare' => '>=',
        'value' => $todayDate,
        'type' => 'datetime'
      )
    )
  ));
  
  $webinars_page_link = get_post_type_archive_link('webinars');
  ?>

    <div class="container card-container pb-5">
      <div class="row">
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-white">Webinars</h2>
          <div class="mb-2 text-white"><a class="btn-see-more" href="<?php echo esc_url($webinars_page_link); ?>">See More<img
                src="<?php echo esc_url(get_theme_file_uri('assets/icon/up-right rounded black.svg'));?>" alt=""></a></div>
        </div>
      </div>
      <hr class="hr-style border-white">
      <div id="cardCarousel" class="carousel slide">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row row-gap-2 gx-md-4 gx-3 gy-4 flex-sm-nowrap px-sm-2">
              <?php 
              while($homepageWebinars->have_posts()){
                $homepageWebinars->the_post();
                $webinars_posts_cat = get_the_category(); ?>
              <div class="col-6 col-md-6 col-lg-4 card-width">
                <div class="card card-max-width">
                  <div class="card-img-box__carousel">
                    <img src="<?php echo get_theme_file_uri('assets/img/ai-generated-7818579_1280.jpg');?>" class="card-img-top card-img--resp__carousel"
                      alt="Card image 2">
                  </div>
                  <div class="card-body py-3">
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
              wp_reset_postdata();
              ?>
            </div>
          </div>
        </div>

        <!-- Carousel controls (arrows) -->
        <div class="hide-on-mob">
          <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon my-control" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon my-control" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
        
      </div>
    </div>
  </section>

  <!-- Marketing -->
  <section class="py-4">
  <?php 
          $marketingPosts = new WP_Query(array(
            'posts_per_page' => 6,
            'category_name' => 'marketing'
          ));
          $marketing_category = get_category_by_slug('marketing');
          if ($marketing_category) {
            $marketing_category_link = get_category_link($marketing_category->term_id);
          } else {
            $marketing_category_link = NULL;
          }
    ?>
    <div id="marketing" class="container marketing-container">
      <div class="row">
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-black">Marketing</h2>
          <div class="mb-2 text-black"><a class="btn-see-more" href="<?php echo esc_url($marketing_category_link); ?>">See More<img
                src="<?php echo esc_url(get_theme_file_uri('assets/icon/up-right rounded black.svg'));?>" alt=""></a></div>
        </div>
      </div>
      <hr class="hr-style border-black">
      <div class="row gy-4 gx-sm-5 mt-2">
      <?php
      while ($marketingPosts->have_posts()){
        $marketingPosts->the_post();
        get_template_part('templates/card',);
      }
      wp_reset_postdata(); 
      ?>
      </div>
    </div>
  </section>

  <!-- Strategy -->
  <section class="py-4">
  <?php 
          $strategyPosts = new WP_Query(array(
            'posts_per_page' => 6,
            'category_name' => 'strategy'
          ));
          $strategy_category = get_category_by_slug('strategy');
          if ($strategy_category) {
            $strategy_category_link = get_category_link($strategy_category->term_id);
          } else {
            $strategy_category_link = NULL;
          }
    ?>
    <div id="strategy" class="container strategy-container">
      <div class="row">
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-black">Strategy</h2>
          <div class="mb-2 text-black"><a class="btn-see-more" href="<?php echo esc_url($strategy_category_link); ?>">See More<img
                src="<?php echo esc_url(get_theme_file_uri('assets/icon/up-right rounded black.svg'));?>" alt=""></a></div>
        </div>
      </div>
      <hr class="hr-style border-black">
      <div class="row gy-4 gx-sm-5 mt-2">
      <?php
      while ($strategyPosts->have_posts()){
        $strategyPosts->the_post();
        get_template_part('templates/card',);
      }
      wp_reset_postdata(); 
      ?>
      </div>
    </div>
  </section>

<?php get_footer();?>