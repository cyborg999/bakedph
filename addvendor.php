<?php include_once "./head.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "vendor"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php include_once "./error.php"; ?>
				<br>
				<div class="col-sm">
					<h5>Vendor Information</h5>
					<form method="post">
						<input type="hidden" name="addVendor" value="true">
						<div class="form-group">
							<label>Name:
								<input type="text" class="form-control" value="<?= isset($_POST['name']) ? $_POST['name'] : '';?>" name="name" placeholder="Name..." required />
							</label>
						</div>
						<div class="form-group">
							<label>Contact Number:
								<input type="number" class="form-control" value="<?= isset($_POST['contact']) ? $_POST['contact'] : '';?>" name="contact" placeholder="Mobile..."/>
							</label>
						</div>
						<div class="form-group">
							<label>Address:
								<input type="text" class="form-control" value="<?= isset($_POST['address']) ? $_POST['address'] : '';?>" name="address" placeholder="Address..."/>
							</label>
						</div>
						<input type="submit" value="Submit" class="btn btn-lg btn-primary">
					</form>
				</div>
		

			</div>
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
</body>
</html>