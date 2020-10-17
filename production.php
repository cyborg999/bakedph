<?php include_once "./headchosen.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "sales"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php include_once "./error.php"; ?>
				<br>
				<div class="col-sm">
					<div class="row">
						<div class="col-sm-4">
							<h5>Production Information</h5>
							<form method="post">
								<input type="hidden" name="addVendor" value="true">
								<div class="form-group">
									<label>Product Name:
										<input type="text" class="form-control" value="<?= isset($_POST['name']) ? $_POST['name'] : '';?>" name="name" placeholder="Name..." required />
									</label>
								</div>
								<div class="form-group">
									<label>Batch Number:
										<input type="number" class="form-control" value="<?= isset($_POST['contact']) ? $_POST['contact'] : '';?>" name="contact" placeholder="Mobile..."/>
									</label>
								</div>
								<div class="form-group">
									<label>Quantity:
										<input type="text" class="form-control" value="<?= isset($_POST['address']) ? $_POST['address'] : '';?>"" name="address" placeholder="Address..."/>
									</label>
								</div>
								<div class="form-group">
									<label>Date Produced:
										<input type="text" class="form-control" value="<?= isset($_POST['address']) ? $_POST['address'] : '';?>"" name="address" placeholder="Address..."/>
									</label>
								</div>
								<input type="submit" value="Submit" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-6">
							<select id="slcProduct" class="form-control">
								<option value="test">hello World</option>
								<option value="test">hello Mars</option>
								<option value="test">hello Earth</option>
								<option value="test">hello Sun</option>
							</select>
						</div>
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
    			$("#slcProduct").chosen();
    		});
    	})(jQuery);
    </script>
</body>
</html>