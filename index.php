<?php 
  include_once "./model.php";

  $model = new Model();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>BakedPH</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon"> -->
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
 <?php
    $slides = $model->getAllSlides();

    // opd($slides);
  ?>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

      <div class="logo">
        <h1 class="text-light"><a href="index.php"><span>BakedPH</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu float-right d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <!-- <li><a href="">About Us</a></li> -->
          <li><a href="signup.php">Sign Up</a></li>
          <li><a href="login.php">Login</a></li>
         
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-cntent-center align-items-center">
    <div id="heroCarousel" class="container carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
     <style type="text/css">
       #hero::after {
        
       }
     </style>
     <?php foreach($slides as $idx => $s): ?>
      <!-- Slide 1 -->
      <div class="carousel-item <?= ($idx == 0) ? 'active' : '';?>">
        <div class="carousel-container">
          <h2 class="animate__animated animate__fadeInDown"><?= $s['title'];?></h2>
          <p class="animate__animated animate__fadeInUp"><?= $s['content'];?></p>
          <a href="signup.php" class="btn-get-started animate__animated animate__fadeInUp">Sign Up Now!</a>
        </div>
      </div>
      <?php endforeach ?>


      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bx bx-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bx bx-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Services Section ======= -->
    <section class="services">
      <div class="container">

        <div class="row">
          <?php
            $subscription = $model->getAllSubscription();
          ?>
     <?php foreach($subscription as $idx => $s): ?>
          <div class="col-sm" data-aos="fade-up">
            <div class="icon-box icon-box-pink">
              <div class="icon"><i class="bx bxl-dribbble"></i></div>
              <h4 class="title"><a href=""><?= $s['title'];?></a></h4>
              <p class="description"><?= $s['caption'];?></p>
            </div>
          </div>
      <?php endforeach ?>


        </div>

      </div>
    </section><!-- End Services Section -->



    <!-- ======= Features Section ======= -->
    <section class="features">
      <div class="container">

        <div class="section-title">
          <h2>Features</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>
        <?php
          $features = $model->getAllSlides(true);
        ?>
        <style type="text/css">
          .features:nth-of-type(odd) {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
          }
          .feature {
            display: block;
          }
        </style>
      <?php foreach($features as $idx => $s): ?>
        <div class="row features" data-aos="fade-up">
          <div class="col-md-5 feature">
            <img src="<?= $s['photo'];?>" class="img-fluid" alt="">
          </div>
          <div class="col-md-7 pt-4 feature">
            <h3><?= $s['title'];?></h3>
            <?= $s['content'];?>
          </div>
        </div>
        <?php endforeach ?>
     

      </div>
    </section><!-- End Features Section -->

  </main><!-- End #main -->

  <?php include "./footer2.php"; ?>


  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>