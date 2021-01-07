<?php include_once "./head.php"; ?>
<body>
	<div class="container-fluid">
		<div class="row">
			<br>
			<div class="col-sm-2 sidenav">
				<?php $active = "material"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-10">
				<?php include_once "./dashboardnav.php"; ?>
				<?php include_once "./error.php"; ?>
				
				<br>
				<h5>Material Information</h5>
				<div class="row">
					<div class="col-sm-3">
						<form method="post">
							<input type="hidden" name="addMaterialInventory" value="true">
							<div class="form-group">
								<label>Name:
									<input type="text" class="form-control"  value="<?= isset($_POST['name']) ? $_POST['name'] : '';?>" name="name" placeholder="Name..." required />
								</label>
							</div>
							<div class="form-group">
								<label>Unit:
									<input type="text" class="form-control"  value="<?= isset($_POST['unit']) ? $_POST['unit'] : '';?>" name="unit" placeholder="Unit..." required />
								</label>
							</div>
							
							<input type="submit" value="Submit" class="btn btn-lg btn-primary">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
	<script type="text/javascript">
    	(function($){
    	
    	})(jQuery);
    </script>
</body>
</html>