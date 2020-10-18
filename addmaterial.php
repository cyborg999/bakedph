<?php include_once "./headchosen.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "material"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php include_once "./error.php"; ?>
				<br>
				<h5>Material Information</h5>
				<div class="row">
					<div class="col-sm-3">
						<?php
				          $vendors = $model->getAllVendors();

				        ?>
						<form method="post">
							<input type="hidden" name="addMaterialInventory" value="true">
							<div class="form-group">
								<label>Name:
									<input type="text" class="form-control"  value="<?= isset($_POST['name']) ? $_POST['name'] : '';?>" name="name" placeholder="Name..." required />
								</label>
							</div>
							<div class="form-group">
								<label for="vendors">Vendor:</label>
								<br>
								<select  id="vendors" class="form-control" name="vendorid">
									<?php foreach($vendors as $idx => $v): ?>
										<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
	            					<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label>Quantity:
									<input type="number" class="form-control" value="<?= isset($_POST['qty']) ? $_POST['qty'] : '';?>" required name="qty" placeholder="Quantity..."/>
								</label>
							</div>
							<div class="form-group">
								<label>Price:
									<input type="text" class="form-control" value="<?= isset($_POST['price']) ? $_POST['price'] : '';?>" required name="price" placeholder="Price..."/>
								</label>
							</div>
							<div class="form-group">
								<label>Expiry Date:
									<input type="date" required class="form-control" value="<?= isset($_POST['expiry_date']) ? $_POST['expiry_date'] : '';?>" name="expiry_date" placeholder="Expiry Date..."/>
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
    <script src="./node_modules/chosen-js/chosen.jquery.min.js" ></script>
	<script type="text/javascript">
    	(function($){
    		$(document).ready(function(){
    			$("#vendors").chosen();
    		});
    	})(jQuery);
    </script>
</body>
</html>