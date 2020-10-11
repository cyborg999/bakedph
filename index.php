<?php include_once "./head.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./nav.php"; ?>
		<div class="jumbotron">
		  <h1 class="display-4">Hello, world!</h1>
		  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
		  <hr class="my-4">
		  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
		  <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
		</div>
		<div class="login">
			<h4>Sign In</h4>
		  	<div class="form-group">
			<form method="post">
				<input type="hidden" name="login" value="true">
				  <div class="form-group">
				    <label for="exampleInputEmail1">Username</label>
						<input type="text" value="<?= isset($_POST['username']) ? $_POST['username'] : '';?>" required class="form-control" name="username" placeholder="Username..."/>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
						<input type="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '';?>" required class="form-control" name="password" placeholder="Password..."/>
				  </div>
			<!-- 	  <div class="form-group form-check">
				    <input type="checkbox" class="form-check-input" id="exampleCheck1">
				    <label class="form-check-label" for="exampleCheck1">Check me out</label>
				  </div> -->
				  <button type="submit" class="btn btn-primary">Submit </button>
				</form>
			</div>
		<!-- errors -->
		<hr>
		<?php if(count($err)): ?>
			<?php foreach($err as $idx => $error): ?>
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>

	<?php include_once "./foot.php"; ?>
</body>
</html>