<div class="mb-5 d-flex justify-content-center">
  <form class="d-inline-flex w-75" method="get" action="<?php echo esc_url(site_url('/'));?>">
    <input class="form-control form-control-lg me-2 page-search-field" id="search-term" name="s" type="search" placeholder="Search" aria-label="Search" value="<?php echo esc_attr( get_search_query() ); ?>">
    <button class="btn my-submit-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
  </form>
</div>