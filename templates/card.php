<?php 
$this_post_cat = get_the_category();
$featured_pic_id = get_post_thumbnail_id(get_the_ID());
$author_thumb_url = get_author_thumb_url();
?>

<div class="col-lg-4 col-sm-6">
  <div class="card mob-card-view card-max-width">
    <div class="col-4 col-sm-12 py-0 card-img-box">
      <?php 
            if($featured_pic_id){
            echo wp_get_attachment_image($featured_pic_id, 'largeCard', false, [
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
        <?php
        if (!empty($this_post_cat)) { ?>
          <!-- // Find the first subcategory (parent != 0) -->
          <small class="card-category">
          <a href="<?php echo esc_url(get_category_link($this_post_cat[0]->term_id)); ?>">
              <?php echo esc_html($this_post_cat[0]->name); ?>
          </a>
      </small>
      <?php }
        ?>
        <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p class="card-text"><?php if(has_excerpt()){
            echo get_the_excerpt();
        } else {
            echo wp_trim_words(get_the_content(), 15);
        } ?></p>
        <div class="card--meta d-flex align-items-center">
          <div class="card--meta__author">
            <a class="d-flex align-items-center" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
              <div class="me-2"><img class="card--meta__author--img"
                  src="<?php echo get_author_thumb_url();?>" alt=""></div>
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