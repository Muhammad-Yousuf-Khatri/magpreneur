<?php get_header(); ?>

<?php
$author_id = get_queried_object_id(); // Get the current author ID
$headline = get_user_meta($author_id, 'author_headline', true);
$social_links = get_user_meta(get_the_author_meta('ID'), 'author_social_links', true);
?>

<section class="py-5 bg-light">
    <div class="container mt-5">
      <div class="row author--detail">
        <div class="col-lg-3 col-12 d-flex justify-content-center mt-lg-5 mt-0">
          <!-- this get_avatar_url($author_id) working here because I updated avatar globally in function.php  -->
          <img class="author--detail__pic" src="<?php echo esc_url(get_avatar_url($author_id)); ?>" alt="" width="240"
            height="240">
        </div>
        <div class="col-lg-9 col-12 mt-3 mt-lg-0">
          <h1 class="mb-2 author--detail__name"><?php
          $fname = get_the_author_meta('first_name');
          $lname = get_the_author_meta('last_name');
          $full_name = '';
          
          if (empty($fname) && empty($lname)) {
            // Fallback to display name if both first and last names are empty
            $full_name = get_the_author();
        } elseif (empty($fname)) {
            $full_name = $lname;
        } elseif (empty($lname)) {
            $full_name = $fname;
        } else {
            $full_name = trim("$fname $lname");
        }
          
          echo esc_html($full_name);
          ?></h1>
          <?php if (!empty($headline)) : ?>
          <p class="author--detail__prof"><strong><?php echo esc_html($headline); ?></strong></p>
          <?php endif; ?>

          <?php

if (!empty($social_links) && is_array($social_links)) : ?>
    <div class="author--detail__social-link my-4 my-lg-5">
        <?php foreach ($social_links as $link) : ?>
            <?php
            // Extract platform and URL
            $platform = !empty($link['platform']) ? $link['platform'] : '';
            $url = !empty($link['url']) ? esc_url($link['url']) : '';

            // Map platform names to Font Awesome icons
            $platform_icons = array(
                'facebook'  => 'facebook-f',
                'twitter'   => 'twitter',
                'instagram' => 'instagram',
                'linkedin'  => 'linkedin-in',
                'youtube'   => 'youtube'
            );

            // Get the appropriate icon class
            $icon_class = !empty($platform_icons[$platform]) ? $platform_icons[$platform] : '';
            ?>
            <?php if (!empty($url)) : ?>
                <a href="<?php echo $url; ?>" class="footer-icon" target="_blank">
                    <i class="fa-brands fa-<?php echo $icon_class; ?> fa-lg"></i>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

          <h2 class="author--detail__bio">BIO</h2>
          <p><?php echo esc_textarea(get_user_meta($author_id, 'description', true)); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Latest Posts -->
  <section class="py-4">
    <div id="author-post" class="container author-post-container">
      <div class="row">
        <div class="col d-flex align-items-end justify-content-between">
          <h2 class="text-black">Latest</h2>
        </div>
      </div>
      <hr class="hr-style border-black">
      <div class="row gy-4 gx-sm-5 mt-2">

        <!-- <div class="col-lg-4 col-sm-6">
          <div class="card mob-card-view card-max-width">
            <div class="col-4 col-sm-12 py-0 card-img-box">
              <img src="assets/img/ai-generated-7818579_1280.jpg" class="card-img-top rounded card-img--resp"
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
                          src="assets/img/ai-generated-7818579_1280.jpg" alt=""></div>
                      <div class="card--meta__author--name">Author Name</div>
                    </a>
                  </div>
                  <span class="card--meta__separator mx-2">-</span>
                  <time class="card--meta__time">date</time>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        
        <?php
      while (have_posts()){
        the_post();
        $author_blog_posts_cat = get_the_category(); 
        $author_post_featured_pic_id = get_post_thumbnail_id(get_the_ID());
        ?>
        <div class="col-lg-4 col-sm-6">
          <div class="card mob-card-view card-max-width">
            <div class="col-4 col-sm-12 py-0 card-img-box">
            <?php 
            if($author_post_featured_pic_id){
            echo wp_get_attachment_image($author_post_featured_pic_id, 'largeCard', false, [
              'class' => 'card-img-top rounded card-img--resp',
              'sizes' => '(max-width: 576px) 150px, 400px',
            ]);
            } else {?>
            <img src="<?php echo esc_url(get_theme_file_uri('assets/icon/landscape-placeholder-svgrepo-com.svg'));?>" class="card-img-top rounded card-img--resp" alt="Card image 1">
            <?php }
            ?>
            </div>
            <div class="col-8 col-sm-12">
              <div class="card-body">
                  <small class="card-category">
                  <a href="<?php echo esc_url(get_category_link($author_blog_posts_cat[0]->term_id)); ?>">
                      <?php echo esc_html($author_blog_posts_cat[0]->name); ?>
                  </a>
              </small>
                <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p class="card-text"><?php if(has_excerpt()){
                    echo get_the_excerpt();
                } else {
                    echo wp_trim_words(get_the_content(), 25);
                } ?></p>
              </div>
            </div>
          </div>
        </div>
      <?php }
      wp_reset_postdata(); 
      ?>


      </div>
    </div>
  </section>


<?php get_footer(); ?>