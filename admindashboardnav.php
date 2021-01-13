<nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="dashboard.php">BakedPH</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="admindashboard.php">Dashboard </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<?php
	//restrict acccess to page if not logged in
	if(!isset($_SESSION['id'])){
    header("Location:logout.php");
  }
  if($_SESSION['usertype'] != "admin"){
    header("Location:logout.php");
  }
?>