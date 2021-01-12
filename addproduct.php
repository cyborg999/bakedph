<?php include_once "./head.php"; ?>
<body>
	<div class="container-fluid">
		<div class="row">
			<br>
			<div class="col-sm-2 sidenav">
				<?php $active = "product"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-10">
				<?php include_once "./dashboardnav.php"; ?>
				<?php include_once "./error.php"; ?>
				<br>
				<h5>Product Information</h5>
				<form method="post">
					<input type="hidden" name="addproduct" value="true">
					<div class="form-group">
						<label>Product Name:
							<input type="text" required class="form-control" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '';?>" placeholder="Product Name..."/>
						</label>
					</div>
					<div class="form-group hidden">
						<label>Price:
							<input type="text"  class="form-control" name="price" placeholder="Price..."/>
						</label>
					</div>
					<div class="form-group hidden">
						<label>Quantity:
							<input type="number"  class="form-control" name="qty" placeholder="Quantity..." value="0" />
						</label>
					</div>
					<div class="form-group hidden">
						<label>Expiry Date:
							<input type="date"  class="form-control" name="expiry" placeholder="Expiry Date..."/>
						</label>
					</div>
					<input type="submit" class="btn btn-lg btn-primary" value="submit">
				</form>

			</div>
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
</body>
</html>