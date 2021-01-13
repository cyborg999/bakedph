<!-- <nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="dashboard.php">BakedPH</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav> -->

<?php
	//restrict acccess to page if not logged in
	if(!isset($_SESSION['id'])){
		header("Location:logout.php");
	}
    if($_SESSION['usertype'] != "basic"){
    header("Location:logout.php");
  }

  // if(isset($_SESSION['firstlogin'])){
  //   $model->getStoreNotifications();

  //   unset()
  // }

?>

 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Search -->
  <form
      class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
      <div class="input-group">
         <!--  <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
              aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
              </button>
          </div> -->
      </div>
  </form>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-search fa-fw"></i>
          </a>
          <!-- Dropdown - Messages -->
          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
              aria-labelledby="searchDropdown">
              <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small"
                          placeholder="Search for..." aria-label="Search"
                          aria-describedby="basic-addon2">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="button">
                              <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </li>
      <?php
        $notif = $model->getUnreadNotifications();
      ?>
      <!-- Nav Item - Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="dashboard.php"  aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-home fa-fw"></i>
          </a>
      </li>

      <li class="nav-item dropdown no-arrow mx-1">

          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-bell fa-fw"></i>
              <!-- Counter - Alerts -->
              <span class="badge badge-danger badge-counter"><?= count($notif); ?>+</span>
          </a>
          <!-- Dropdown - Alerts -->
          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
              aria-labelledby="alertsDropdown">
              <h6 class="dropdown-header">
                  Notifications
              </h6>
             <!--  <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                      <div class="icon-circle bg-primary">
                          <i class="fas fa-file-alt text-white"></i>
                      </div>
                  </div>
                  <div>
                      <div class="small text-gray-500">December 12, 2019</div>
                      <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
              </a>
              <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                      <div class="icon-circle bg-success">
                          <i class="fas fa-donate text-white"></i>
                      </div>
                  </div>
                  <div>
                      <div class="small text-gray-500">December 7, 2019</div>
                      $290.29 has been deposited into your account!
                  </div>
              </a> -->
              <?php foreach($notif as $idx => $n): ?>
                <?php if($idx < 8): ?>
                  <a class="dropdown-item d-flex align-items-center" href="notifications.php">
                          <?= $n['title'];?>
                  </a>
                <?php endif ?>
            <?php endforeach ?>
              <a class="dropdown-item text-center small text-gray-500" href="notifications.php">Show All Notifications</a>
          </div>
      </li>


      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <style type="text/css">
        .img-profile {
          background: #5a5a5a url(./node_modules/bootstrap-icons/icons/file-person-fill.svg) no-repeat;
          width: 30px!important;
          height: 30px!important;
          background-size: cover;
          border-radius: 100%;
          margin-top: 14px;
        }
        .profile-pic {
          color: white!important;
        }
        #photos {
            width: 30px;
            height: 30px;
            background: url(<?= $photos; ?>) center no-repeat;
            background-size: cover;
            border-radius: 100%!important;
            display: block;
            margin: 0 auto;
          }
      </style>
       <?php
              $profile = $model->getUserProfile();
              $photos = ($profile) ? $profile['profilePicture'] : './node_modules/bootstrap-icons/bootstrap-icons.svg#file-person-fill';

            ?>
      <li class="nav-item dropdown no-arrow">
          <a class="nav-link profile-pic dropdown-toggle" href="#" id="userDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['name'];?></span>
             <figure id="photos" class="rounded-circle"></figure>
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
              aria-labelledby="userDropdown">
              <a class="dropdown-item" href="profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
              </a>
             <!--  <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Business
              </a> -->
             <!--  <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
              </a> -->
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
              </a>
          </div>
      </li>

  </ul>

</nav>