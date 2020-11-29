<?php include_once "./headchosen.php"; ?>
<?php $model->checkAccess(); ?>
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
			          $sales = $model->getAllSales();

			        ?>
					<div class="row">
						<div class="col-sm-4">
							<h5>Sales Information</h5>
							<form method="post">
								<input type="hidden" name="addSale" value="true">
								<div class="form-group">
									<label>Product Name:</label>
									<select id="slcProduct"  name="productid" class="form-control">
		            					<?php foreach($products as $idx => $product): ?>

										<option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
		            					<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Quantity:</label>
									<input type="number" class="form-control" value="<?= isset($_POST['qty']) ? $_POST['qty'] : '';?>" required name="qty" placeholder="Quantity..."/>
								</div>
								<div class="form-group">
									<label>Date of purchase:</label>
									<input type="date" required class="form-control" value="<?= isset($_POST['date_purchased']) ? $_POST['date_purchased'] : '';?>"" name="date_purchased" placeholder="Date..."/>
								</div>
								<input type="submit" value="Submit" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-8">
							<h5>Sales List</h5>
							<table class="table">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>Date Purchased</th>
										<th>Action</th>
									</tr>
								</thead>

            					<?php foreach($sales as $idx => $p): ?>
            						<tr>
										<td><?= $p['name']; ?></td>
										<td><?= $p['qty']; ?></td>
										<td><?= $p['date_purchased']; ?></td>
										<td>
											<a href="" class="delete btn btn-danger" data-id="<?= $p['id']; ?>"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
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


    			$("#slcProduct").on("change", function(){
    				var me = $(this);

    				console.log(me.val());
    			});

    			$(".delete").on("click", function(e){
    				e.preventDefault();

    				var me = $(this);
    				console.log(me.data("id"));

    				$.ajax({
    					url : "ajax.php"
    					, data : { deleteSale : true , id : me.data("id")}
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