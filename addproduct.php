<?php include_once "./head.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php include_once "./error.php"; ?>
				<br>
				<h2>Product Information</h2>
				<form method="post">
					<input type="hidden" name="addproduct" value="true">
					<div class="form-group">
						<label>Product Name:
							<input type="text" required class="form-control" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '';?>" placeholder="Product Name..."/>
						</label>
					</div>
					<div class="form-group">
						<label>Price:
							<input type="text" required class="form-control" name="price" placeholder="Price..."/>
						</label>
					</div>
					<div class="form-group">
						<label>Quantity:
							<input type="number" required class="form-control" name="qty" placeholder="Quantity..."/>
						</label>
					</div>
					<div class="form-group">
						<label>Expiry Date:
							<input type="date" required class="form-control" name="expiry" placeholder="Expiry Date..."/>
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