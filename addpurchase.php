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
			          $materials = $model->getAllMaterialInventory();

			          $vendors = $model->getAllVendors();
			          $purchasedOrders = $model->getPurchaseOrders();
			        ?>
					<div class="row">
						<div class="col-sm-4">
							<h5>Purchase Information</h5>
							<form method="post">
								<input type="hidden" name="addPurchase" value="true">
								<div class="form-group">
									<label>Vendor Name:</label>
									<select id="slcProduct"  name="vendorid" class="form-control">
		            					<?php foreach($vendors as $idx => $v): ?>

										<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
		            					<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Material Name:</label>
									<select id="slctMaterial"  name="materialid" class="form-control">
		            					<?php foreach($materials as $idx => $m): ?>

										<option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
		            					<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="type">Purchase Type</label>
									<select class="form-control" id="type" name="type">
										<option value="cash">Cash</option>
										<option value="credit">Credit</option>
									</select>
								</div>
								<div class="form-group">
									<label>Quantity:</label>
									<input type="number" class="form-control" value="" required name="qty" placeholder="Quantity..."/>
								</div>
								<div class="form-group">
									<label>Date of purchase:</label>
									<input type="date" required class="form-control" value="" name="date_purchased" placeholder="Date..."/>
								</div>
								<input type="submit" value="Submit" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-8">
							<h5>Purchase Order List</h5>
							<table class="table">
								<thead>
									<tr>
										<th>Vendor</th>
										<th>Material</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Date Purchased</th>
										<th>Action</th>
									</tr>
								</thead>

            					<?php foreach($purchasedOrders as $idx => $p): ?>
            						<tr>
										<td><?= $p['vendorname']; ?></td>
										<td><?= $p['materialname']; ?></td>
										<td><?= $p['type']; ?></td>
										<td><?= $p['qty']; ?></td>
										<td><?= $p['date_purchased']; ?></td>
										<td>
											<a href="" class="delete btn btn-danger" data-qty="<?= $p['qty']; ?>"  data-id="<?= $p['id']; ?>" data-mid="<?= $p['materialid']; ?>"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
										</td>
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
    			$("#slctMaterial").chosen();
    			$("#type").chosen();

    			$(".delete").on("click", function(e){
    				e.preventDefault();

    				var me = $(this);
    				console.log(me.data("id"));

    				$.ajax({
    					url : "ajax.php"
    					, data : { 
    						deletePurchase : true , 
    						id : me.data("id"),
    						qty : me.data("qty"),
    						materialid : me.data("mid")
    					}
    					, type : 'post'
    					, dataType : 'json'
    					, success : function(response){
    						me.parents("tr").remove();
    					}
    				});

    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>