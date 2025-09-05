<?php
get_header();

while (have_posts()) {
    the_post();
    $wordCount = str_word_count(strip_tags(get_the_content()));
    set_post_views(get_the_ID()); 
              $content = apply_filters('the_content', get_the_content());
              libxml_use_internal_errors(true);
              $doc = new DOMDocument();
              $doc->loadHTML(mb_convert_encoding($content,'HTML-ENTITIES', 'UTF-8'));

              $headings = $doc->getElementsByTagName('h2');
              $toc_items = [];

              foreach ($headings as $heading) {
                $text = trim($heading->textContent);
                $id = preg_replace('/[^a-z0-9]+/', '-', strtolower($text));
                $id = trim($id, '-');

                $toc_items[] = [
                  'text' => $text,
                  'id' => $id,
                ];
              }
?>
<!-- single post head -->
<section class="pt-5 bg-light border-bottom">
    <div class="container post-head mt-5">
      <div class="row row-cols-1">
        <div class="col single-post--title">
          <h1 class="text-center"><?php the_title(); ?></h1>
        </div>
        <div class="col single-post--info d-flex align-items-center my-4">
          <div class="col">
            <a class="d-flex align-items-center justify-content-center" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
              <div class="me-2"><img class="card--meta__author--img" src="<?php echo get_author_thumb_url(); ?>"
                  alt=""></div>
                  <div class="card--meta__author--name"><?php echo esc_html(get_the_author()); ?></div>
            </a>
          </div>
          <div class="col d-flex justify-content-center">
            <span><?php echo round($wordCount/255); ?> min read</span>
          </div>
          <div class="col d-flex justify-content-center">
            <time class="card--meta__time"><?php the_time('j-M-y');?></time>
          </div>
        </div>

        <?php
        
        $likeCount = new WP_Query(array(
          'post_type' => 'liked',
          'meta_query' => array(
            array(
              'key' => 'liked_posts',
              'compare' => '=',
              'value' => get_the_ID()
            )
          )
        ));

        $userLikeStatus = 'regular';
        $dataExists = 'no';

        if(is_user_logged_in()){
          $userLikeCheck = new WP_Query(array(
          'author' => get_current_user_id(),
          'post_type' => 'liked',
          'meta_query' => array(
            array(
              'key' => 'liked_posts',
              'compare' => '=',
              'value' => get_the_ID()
            )
          )
        ));

        if ($userLikeCheck->found_posts > 0){
         $userLikeStatus = 'solid';
         $dataExists = 'yes';
         $likePostID = $userLikeCheck->posts[0]->ID;
        }
        }

        ?>

        <div class="col single-post--meta d-flex align-items-center justify-content-between py-3 border-top">
          <div class="col d-flex justify-content-start">
            <button class="me-3 like-btn" data-likeID="<?php echo (is_user_logged_in() && $dataExists == 'yes')? esc_attr($likePostID) : "" ;?>" data-postID="<?php echo esc_attr(get_the_ID()); ?>" data-exists="<?php echo esc_attr($dataExists); ?>">
              <i class="fa-<?php echo esc_attr($userLikeStatus); ?> fa-heart"></i>
              <small class="like-count"><?php echo esc_html($likeCount->found_posts); ?></small>
            </button>
            <button class="me-3">
              <i class="fa-solid fa-comment"></i>
              <small>3</small>
            </button>
          </div>
          <div class="col d-flex justify-content-end">
            <button class="me-3 bookmark-button"><i class="fa-solid fa-bookmark"></i></button>
            <button><i class="fa-solid fa-share"></i></button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Post Body -->
  <section>
    <!-- table of contents offcanvas -->
     <?php if (!empty($toc_items)): ?>
    <div class="toc-offcanvas d-lg-none">
      <button class="btn-offcanvas bg-light" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#table-of-contents__menu" aria-controls="table-of-contents__menu"><i
          class="fa-solid fa-list-ul fa-lg"></i></button>
      <span class="d-lg-none toc-heading"><small><i class="fa-solid fa-caret-left mx-1"></i>Table of
          Contents</small></span>
      <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="table-of-contents__menu"
        aria-labelledby="table-of-contents">
        <button type="button" class="btn-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
            class="fa-solid fa-chevron-left fa-lg"></i></button>
        <div class="offcanvas-body scroll--simple">
          <aside class="table-of-contents">
            <nav aria-label="Table of Contents">
              <p><strong>Table of Contents</strong></p>
              <hr>
              <?php 
                echo '<ul id="list-of-contents-offcanvas" class="list-group">';

                foreach ($toc_items as $item) {
                  echo '<li><a class="toc-item" href="#'  . esc_attr($item['id']) . '">' . esc_html($item['text']) . '</a></li>';
                }
                echo '</ul>';
              endif;
              ?>
            </nav>
          </aside>
        </div>
      </div>
    </div>

    <div class="container pt-lg-5 pb-5">
      <div class="row">
        <div class="col-3 d-none d-lg-block">
          <?php if (!empty($toc_items)) : ?>
          <aside class="table-of-contents">
            <nav aria-label="Table of Contents" class="scroll--simple">
              <p><strong>Table of Contents</strong></p>
              <hr>
              <?php 
                echo '<ul id="list-of-contents" class="list-group">';

                foreach ($toc_items as $item) {
                  echo '<li><a class="toc-item" href="#'  . esc_attr($item['id']) . '">' . esc_html($item['text']) . '</a></li>';
                }
                echo '</ul>';
              endif;
              ?>
            </nav>
          </aside>
        </div>

        <div class="col-12 col-lg-9">
          <article data-bs-spy="scroll" data-bs-target="#list-of-contents" data-bs-smooth-scroll="true"
            class="content-width" id="article" tabindex="0">
            <?php the_content(); ?>
          </article>
        </div>
      </div>
    </div>
  </section>

<?php }
wp_reset_postdata();

// Display comments template if comments are open or at least one comment exists

if ( comments_open() || get_comments_number() ) {
    comments_template();
}



get_footer();
?>