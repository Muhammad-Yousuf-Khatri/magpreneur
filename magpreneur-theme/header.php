<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <?php wp_head();?>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body <?php body_class();?>>
    <header class="navbar navbar-expand-lg">
    <div class="expend-animate-container"></div>
    <div class="container d-block header-section">
      <div class="main-header">
        <div class="row align-items-center">

          <div class="col-2 d-lg-none">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
          <!-- Left side: Logo -->
          <div class="col logo-column text-center">
            <a href="<?php echo site_url();?>" class="navbar-brand">
              <img src="your-logo.png" alt="Logo" width="150">
            </a>
          </div>

          <!-- Middle: Navigation -->
          <div class="col-6 header-nav-column d-none d-lg-block">
            <nav>

            <?php wp_nav_menu(array(
              'theme_location' => 'headerMenuLocation',
              'menu_class' => 'nav header-nav',
              'walker' => new Theme_Nav_Walker()
            )); ?>

              <!-- <ul class="nav header-nav">
                <li class="nav-item">
                  <a class="nav-link active" href="<?php echo site_url();?>">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="single.html">single post</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="author.html">author</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Link
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo site_url('/contact-us');?>">Contact Us</a>
                </li>
              </ul> -->
            </nav>
          </div>

          <!-- Right side: Search bar -->
          <div class="col header-btns-column">
            <div class="d-flex justify-content-start me-auto my-search-box d-none" aria-hidden="true">
              <form class="d-flex w-100" method="get" action="<?php echo esc_url(site_url('/'));?>">
                <input class="form-control me-2 my-search-field" name="s" id="search-term" type="search" placeholder="Search" aria-label="Search">
                <button class="btn my-submit-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
              </form>
              <!--this is search result div-->
              <div class="search-suggestion-field w-100 d-none"></div>
            </div>
            <button class="my-search-btn" onclick="toggleSearchIcon(this.firstElementChild)"><i
                class="fa-solid fa-magnifying-glass"></i></button>
                <?php 
                if(is_user_logged_in()){ ?>
                  <a href="<?php echo wp_logout_url(); ?>" class="btn-login"><i class="fa-solid fa-circle-user"></i><small class="d-none d-md-block">Sign Out</small></a>
                <?php
                } else { ?>
                  <a href="<?php echo wp_login_url(); ?>" class="btn-login"><i class="fa-regular fa-circle-user"></i><small class="d-none d-md-block">Sign In</small></a>
                <?php }
                ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="offcanvasNavbar"
      aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-lg-none">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="single.html">single post</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="author.html">author</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </header>