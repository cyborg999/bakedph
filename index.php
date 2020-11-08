<?php include "./head.php"; ?>
<body>
	<div class="container-fluid">
		<?php include_once "./nav.php"; ?>
		<div class="row">
      <style type="text/css">
        .carousel-item {
          height: 100vh;
        }
        .banner {
          background-size: 100%;
        }
        .container-fluid {
          margin: 0 auto;
          padding: 0;
          position: relative;
          overflow: hidden;
        }
        .carousel-caption {
          background: rgba(0,0,0,.1);
          padding: 100px 50px 20px;
          box-sizing: border-box;
          border-radius: 10px;
        }
        .navbar {
          position: absolute;
          width: 100%;
          top: 0;
          left: 0;
          z-index: 999;
          background: transparent!important;
        }
        .navbar:hover {
          background: rgba(0,0,0,.4)!important;
          transition: all 1s;
        }
        .navbar-dark .navbar-toggler {
          background: rgba(0,0,0,.1);
        }
        .marketing {
          padding: 50px 0 50px;
        }
        .marketing .col-lg-4 {
          text-align: center;
        }

        @media(max-width: 420px){
          .banner,
          .banner1,
          .banner2,
          .banner3 {
            background-size: cover;
          }
        }
      </style>
      <?php
        $slides = $model->getAllSlides();
        $news = $model->getAllSlides(true);
      ?>
			<div class="col-sm">
				 <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <?php foreach($slides as $idx => $s): ?>
            <li data-target="#myCarousel" data-slide-to="<?= $idx;?>" class="<?= ($idx==0) ? 'active' : '' ?>""></li>
            <?php endforeach ?>
          </ol>
          <div class="carousel-inner">
            <?php foreach($slides as $idx => $s): ?>
            <div class="carousel-item <?= ($idx==0) ? 'active' : '' ?> banner" style="background:url(<?= $s['photo'];?>) no-repeat;">
              <div class="container">
                <div class="carousel-caption text-left">
                  <h1><?= $s['title'];?></h1>
                  <p><?= $s['content'];?></p>
                  <p><a class="btn btn-lg btn-primary" href="signup.php" role="button">Sign up today</a></p>
                </div>
              </div>
            </div>
            <?php endforeach ?>
          </div>
          <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
      </div>


			</div>
		</div>
    <div class="row">
      <div class="col-sm">
        <div class="container marketing">
          <div class="row">

            <?php foreach($news as $idx => $s): ?>
            <div class="col-lg-4">
              <img  width="140" height="140" class="rounded-circle" src="<?= $s['photo'];?>">
              <h2><?= $s['title'];?></h2>
              <p><?= $s['content'];?></p>
              <p><a class="btn btn-secondary" href="signup.php" role="button">View details &raquo;</a></p>
            </div>
            <?php endforeach ?>
          </div>
      </div>
    </div>

	</div>
<!-- FOOTER -->
  <footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; All Rights Reserved. </p>
  </footer>
	<?php include_once "./foot.php"; ?>
  <script type="text/javascript">
    
  </script>
</body>
</html>