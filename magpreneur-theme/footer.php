<footer class="bg-light">
    <div class="container bg-body-tertiary">
      <div class="row">
        <div class="col py-4 border-top footer-nav">

          <?php wp_nav_menu(array(
            'theme_location' => 'footerLinks',
            'container' => false,
            'items_wrap' => '%3$s',
            'walker' => new FooterNoUlWalker()
          )); ?>

          <!-- <a href="#" class="footer-link">Terms of Use</a>
          <a href="#" class="footer-link">Privacy Policy</a>
          <a href="#" class="footer-link">Cookies Policy</a>
          <a href="#" class="footer-link">Contact Support</a>
          <a href="#" class="footer-link">Advertise</a> -->
        </div>
      </div>
      <div id="newsletter" class="row py-4 border-top">
        <div class="col-12 col-lg-7 mt-2">
          <h5>Sign up for our free Daily newsletter</h5>
          <p>You'll be notified every morning Monday-Saturday with all the day's top business news, webinar, best advice
            and exclusive reporting from Experts.</p>
        </div>
        <div class="col-12 col-lg-5 mt-2">
          <form class="d-flex">
            <input type="email" class="form-control form-control-lg me-2" placeholder="Email">
            <button type="submit" class="btn-subscribe">Subscribe</button>
          </form>
          <small class="d-block mt-3">I understand that the data I am submitting will be used to provide me with the
            above-described products and/or services and communications in connection therewith. Read our <a
              class="link-dark" href="#">privacy policy</a> for more information.</small>
        </div>
      </div>
      <div class="row py-4 border-top">
        <div class="col-7 d-flex align-items-center">
          <p class="m-0">Copyright © 2024</p>
        </div>
        <div class="col-5 my-auto">
          <a href="" class="footer-icon"><i class="fa-brands fa-facebook-f fa-lg"></i></a>
          <a href="" class="footer-icon"><i class="fa-brands fa-instagram fa-lg"></i></a>
          <a href="" class="footer-icon"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
        </div>
      </div>
    </div>
  </footer>

<?php wp_footer();?>
</body>
</html>