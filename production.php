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
				  	<?php
			          $products = $model->getAllProducts();
			          $production = $model->getAllProduction();
			        ?>
					<div class="row">
						<div class="col-sm-4">
							<h5>Production Information</h5>
							<form method="post">
								<input type="hidden" name="addProduction" value="true">
								<div class="form-group">
									<label>Product Name:</label>
									<select id="slcProduct"  name="productid" class="form-control">
		            					<?php foreach($products as $idx => $product): ?>

										<option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
		            					<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Batch Number:</label>
									<input type="text" class="form-control" value="<?= isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '';?>" required name="batchnumber" placeholder="Batch #..."/>
								</div>
								<div class="form-group">
									<label>Quantity:</label>
									<input type="number" class="form-control" value="<?= isset($_POST['qty']) ? $_POST['qty'] : '';?>" required name="qty" placeholder="Quantity..."/>
								</div>
								<div class="form-group">
									<label>Date Produced:</label>
									<input type="date" required class="form-control" value="<?= isset($_POST['date_produced']) ? $_POST['date_produced'] : '';?>"" name="date_produced" placeholder="Date..."/>
								</div>
								<input type="submit" value="Submit" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-8">
							<table class="table">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Batch #</th>
										<th>Quantity</th>
										<th>Date Produced</th>
									</tr>
								</thead>

            					<?php foreach($production as $idx => $p): ?>
            						<tr>
										<td><?= $product['name']; ?></td>
									</tr>
            					<?php endforeach ?>

								
							</table>
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


    			$("#slcProduct").on("change", function(){
    				var me = $(this);

    				console.log(me.val());
    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>