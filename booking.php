
<!DOCTYPE html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="shortcut icon" href="assets/favicon/favicon_Grogger">

   <title>Reservation | Neo Kenya Mpya </title>

   <!-- CSS Plugins -->
   <link href="assets/plugins/lightbox/dist/css/lightbox.css" rel="stylesheet">
   <link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css">

   <!-- CSS Global -->
   <link href="assets/css/styles.css" rel="stylesheet">


  <body data-spy="scroll" data-target=".navbar" data-offset="70">



    <!--  NAVBAR
  ================================================== -->

  <!-- navbar -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar__collapse" aria-expanded="false">
          <span class="sr-only">Menu</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index_default.html">Neo Kenya Mpya</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar__collapse">
        <ul class="nav navbar-nav navbar-right">

          <!-- General links -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Home <i class="icon ion-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="index_default.html">Home Image</a></li>
              <li><a href="index_imageParallax.html">Home Parallax</a></li>
              <li><a href="index_slider.html">Home Slider</a></li>
              <li><a href="index_video.html">Home Video</a></li>
            </ul>
          </li>
          <li><a href="about.html">About</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <i class="icon ion-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="menu_image.html">Image Menu</a></li>
              <li><a href="menu_text.html">Text Menu</a></li>
            </ul>
          </li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="events.html">Events</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog <i class="icon ion-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="blog.html">Blog Page</a></li>
              <li><a href="blog_post.html">Blog Post Page</a></li>
            </ul>
          </li>
          <li class="active"><a href="reservation.html">Reservation</a></li>
          <li><a href="contacts.html">Contacts</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>

      <!-- CONTENT
      ================================================== -->

      <!-- HEADER
      ================================================== -->
      <section class="section section_header section_header__reservation">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">

              <!-- Heading -->
              <h1 class="section__heading section_header__heading text-center">
                Reservation
              </h1>

              <!-- Breadcrumbs -->
              <ol class="breadcrumb">
                <li><a href="index_default.html">Home</a></li>
                <li class="active">Reservation</li>
              </ol>

            </div>
          </div> <!-- .row -->
        </div> <!-- .container -->
        <div class="section_header__bg reservation_bg"></div>
      </section>

      <!-- section reservation -->
      <section class="section_reservation" id="section_reservation">
        <div class="section_row">
          <div class="col-md-5">
            <div class="reservation_img"></div>
          </div>
          <div class="col-md-7">
            <div class="reservation_form_body">
              <h3 class="reservation_form_title">Online reservation</h3>
              <hr class="section_title_line">
              <p class="section_caption">Book one of our buses for your transit needs</p>
              <form class="reservation_form" id="reservation__form">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="sr-only" for="reservation__name">Full Name</label>
                      <input type="text" class="form-control" id="reservation__name" name="reservation__name" placeholder="Full Name">
                      <div class="help-block"></div>
                    </div>
                    <div class="form-group">
                      <label class="sr-only" for="reservation__phone">Phone Number</label>
                      <input type="tel" class="form-control" id="reservation__phone" name="reservation__phone" placeholder="Phone Number">
                      <div class="help-block"></div>
                    </div>
                    <div class="form-group">
                      <label class="sr-only" for="reservation__phone">Your e-mail</label>
                      <input type="email" class="form-control" name="reservation__email" id="reservation__email" placeholder="Your e-mail">
                      <div class="help-block"></div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="sr-only" for="reservation__people">Number of buses</label>
                      <select class="form-control" id="reservation__people" name="reservation__people">
                        <option value="1" selected="">1 bus</option>
                        <option value="2">2 buses</option>
                        <option value="3">3 buses</option>
                        <option value="4">4 buses</option>
                        <option value="5">5 buses</option>
                        <option value="6">6 buses</option>
                      </select>
                      <div class="help-block"></div>
                    </div>
                    <div class="form-group">
                      <label class="sr-only" for="reservation__date">Date</label>
                      <input type="date" class="form-control" name="reservation__date" id="reservation__date" value="2017-10-09">
                      <div class="help-block"></div>
                    </div>
                    <div class="form-group">
                      <label class="sr-only" for="reservation__time">Time</label>
                      <input type="time" class="form-control" id="reservation__time" value="19:00" name="reservation__time">
                      <div class="help-block"></div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-default">Reserve a bus</button>
                  </div>
                </div> <!-- .row -->
              </form>
            </div> <!-- .reservation_form_body -->
          </div>
        </div> <!-- .section_row -->
      </section>

      <!-- section newsletter -->
      <section class="section_newsletter">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <p class="section_newsletter_title-sm">Subscribe for our</p>
              <h2 class="section_newsletter_title-lg">Newsletter</h2>
            </div>
            <div class="col-sm-8">
              <!-- Newsletter form -->
              <div id="mc_embed_signup">
                <form class="newsletter__form validate" action="//themeforest.us16.list-manage.com/subscribe/post-json?u=3c9679e26b601e1a87122b12f&id=e4b9351526&c=?" method="get" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate="">
                  <div id="mc_embed_signup_scroll" class="row">
                    <div class="mc-field-group form-group col-sm-7 col-md-9">
                      <label for="mce-EMAIL" class="sr-only">E-mail address</label>
                      <input type="email" value="" name="EMAIL" class="required email form-control newsletter_input" id="mce-EMAIL" placeholder="Email address">
                    </div>
                    <div id="mce-responses" class="clear">
                      <div class="response"></div>
                      <div class="response" id="mce-success-response"></div>
                    </div>
                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div aria-hidden="true" id="mce-hidden-input">
                      <input type="text" name="b_507744bbfd1cc2879036c7780_4523d25e1b" tabindex="-1" value="">
                    </div>
                    <div class="clear col-sm-5 col-md-3">
                      <button type="submit" class="btn btn-default" id="mc-embedded-subscribe">
                        Subscribe
                      </button>
                    </div>
                  </div>
                </form>
              </div> <!-- #mc_embed_signup -->
            </div>
          </div> <!-- .row -->
        </div> <!-- .container -->
      </section>

      <!-- section map -->
      <div class="section_map">
        <div class="section_row">
          <div id="map"></div>
        </div> <!-- / .section_row -->
      </div> <!-- / .section_map -->

      <!-- section footer -->
      <footer class="section_footer">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-lg-3">
              <h3 class="section_footer_heading">Contacts</h3>
              <p><i class="icon ion-ios-location-outline"></i> Thika, Nairobi</p>
              <p><i class="icon ion-ios-telephone-outline"></i> +254 798000000</p>
              <p><i class="icon ion-ios-email-outline"></i> management@neokenya.co.ke</p>
            </div>
            <div class="col-sm-6 col-lg-3">
              <h3 class="section_footer_heading">Follow us</h3>
              <p><b>Download our app:</b></p>
              <ul>
                <li class="app_icon"><a href="#"><i class="icon ion-social-apple-outline"></i></a></li>
                <li class="app_icon"><a href="#"><i class="icon ion-social-android-outline"></i></a></li>
                <li class="app_icon"><a href="#"><i class="icon ion-social-windows-outline"></i></a></li>
              </ul>
              <div class="social">
                <ul>
                  <li><p><b>Social: </b></p></li>
                  <li class="social_icon"><a href="#"><i class="icon ion-social-facebook-outline"></i></a></li>
                  <li class="social_icon"><a href="#"><i class="icon ion-social-twitter-outline"></i></a></li>
                  <li class="social_icon"><a href="#"><i class="icon ion-social-instagram-outline"></i></a></li>
                  <li class="social_icon"><a href="#"><i class="ion-social-foursquare"></i></a></li>
                </ul>
              </div> <!-- .social -->
            </div>
            <div class="col-sm-6 col-lg-3">
              <h3 class="section_footer_heading">Opening hours</h3>
              <p><b>Mon: </b>3PM - 9PM</p>
              <p><b>Tue-Fri: </b>11AM - 12PM</p>
              <p><b>Sat-Sun: </b>9AM - 12PM</p>
            </div>
            <div class="col-sm-6 col-lg-3">
              <h3 class="section_footer_heading">Support</h3>
              <p><a href="#">Help & Support</a></p>
              <p><a href="#">Privacy Policy</a></p>
              <p><a href="#">Terms & Conditions</a></p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <hr>
              <p class="footer_info">&#169; 2021 NeoKenyaMpyaOfficial. All rights reserved.</p>
            </div>
          </div> <!-- .row -->
        </div> <!-- .container -->
      </footer>

    <!-- JS
    ================================================== -->

    <!-- JS Global -->
    <script src="assets/plugins/jquery/jquery-1.12.4.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- JS Plugins -->
    <script src="assets/plugins/lightbox/dist/js/lightbox.min.js"></script>
    <script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>

    <!-- JS Custom -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/google_maps.js"></script>

    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTGnDWmYKPhKslCvPfkrcZDpgT_QMHT0s&callback=initMap" async defer></script>

  </body>
</html>
