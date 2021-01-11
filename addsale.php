<?php include_once "./headchosen.php"; ?>
<?php $model->checkAccess(); ?>
<body>
	<div class="container-fluid">
		<div class="row">
			<br>
			<div class="col-sm-2 sidenav">
				<?php $active = "sales"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-10">
				<?php include_once "./dashboardnav.php"; ?>
				<?php include_once "./error.php"; ?>
				<br>
				<div class="col-sm">
				  	<?php
			          $products = $model->getInstockProducts();
			          $sales = $model->getAllSales();

			        ?>
			        <div class="row">
			        	<div class="col-sm message">
			        		
			        	</div>
			        </div>
					<div class="row">
						<div class="col-sm-4">
							<h5>Sales Information</h5>
							<form method="post" class="form">
								<input type="hidden" name="addSale" value="true">
								<div class="form-group">
									<label>Product Name:</label>
									<select id="slcProduct"  name="productid" class="form-control">
		            					<?php foreach($products as $idx => $product): ?>

										<option data-max="<?= $product['qty'];?>" value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
		            					<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Quantity:</label>
									<input type="number" class="form-control" value="<?= isset($_POST['qty']) ? $_POST['qty'] : '';?>" required name="qty" id="quantity" placeholder="Quantity..."/>
								</div>
								<div class="form-group">
									<label>Unit:</label>
									<input type="text" class="form-control" readonly="" value="pcs." required name="unit" id="unit" placeholder="Unit..."/>
								</div>
								<div class="form-group">
									<label>Date:</label>
									<input type="date" required class="form-control" value="<?= isset($_POST['date_purchased']) ? $_POST['date_purchased'] : '';?>"" name="date_purchased" id="date_purchased" placeholder="Date..."/>
								</div>
								<input type="submit" value="Add" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-8">
							<h5>Sales List</h5>
							<table class="table">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Date</th>
										<th>Quantity</th>
									</tr>
								</thead>
								<tbody id="tbody">
									
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4">
											<a href="" class="btn btn-success submit">Submit</a>
										</td>
									</tr>
								</tfoot>
<!-- 
            					<?php foreach($sales as $idx => $p): ?>
            						<tr>
										<td><?= $p['name']; ?></td>
										<td><?= $p['qty']; ?></td>
										<td><?= $p['date_purchased']; ?></td>
										<td>
											<a href="" class="delete btn btn-danger" data-id="<?= $p['id']; ?>"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
										</td>
									</tr>
            					<?php endforeach ?> -->

								
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- tpl script -->
	<script type="text/html" id="tpl">
		<tr>
			<td class="name" data-id="[ID]">[NAME]</td>
			<td  class="quantity">[QUANTITY]</td>
			<td  class="unit">[UNIT]</td>
			<td class="date_purchased">[DATE_PURCHASED]</td>
			<td>
				<a href="" class="delete btn btn-danger" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
			</td>
		</tr>
	</script>
	<!-- end tpl script -->
	<!-- alert script -->
	<script type="text/html" id="success">
	      <div class="alert alert-success alert-dismissible fade show" role="alert">
	        <strong>Success!!</strong> You have sucessfully added this record.
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	</script>
	<!-- end alert script -->
	<?php include_once "./foot.php"; ?>
    <script src="./node_modules/chosen-js/chosen.jquery.min.js" ></script>
    <script type="text/javascript">
    	(function($){
    		$(document).ready(function(){
    			function __listen(){
    				$(".delete").off().on("click", function(e){
    					e.preventDefault();

    					var me = $(this);

    					me.parents("tr").remove();
    				});
    			}

    			__listen();

    			$(".submit").on("click", function(e){
    				e.preventDefault();

    				var data = Array();
    				var tr = $("tbody tr");

    				tr.each(function(x, y){
    					var tr = $(y);
    					var name = tr.find(".name").data("id");
    					var quantity = tr.find(".quantity").html();
    					var dateProduced = tr.find(".date_purchased").html();

    					var production = Array(name,quantity,dateProduced);

    					data.push(production);

    				});

    				$(".message").html("");
    				
    				if(tr.length){
    					$.ajax({
							url : "ajax.php"
							, data : { addSale : true , data : data}
							, type : 'post'
							, dataType : 'json'
							, success : function(response){
								$("#tbody").html("");

								$(".message").append($("#success").html());
							}
						});	
    				}
    			});

    			$("#slcProduct").chosen();
    			$(".form").on("submit", function(e){
    				e.preventDefault();
    				var max = $("#slcProduct :selected").data("max");
    				var quantity = $("#quantity").val();

    				quantity = parseInt(quantity);

    				if(quantity>max){
    					alert("Maximum stock for this item is: " + max);
    					return;
    				}

    				var tpl = $("#tpl").html();
    				var productId = $("#slcProduct").val();
    				var productName = $("#slcProduct :selected").html();
    				var unit = $("#unit").val();
    				var datePurchased = $("#date_purchased").val();

    				tpl = tpl.replace("[NAME]", productName).
    					replace("[ID]", productId).
    					replace("[UNIT]", unit).
    					replace("[QUANTITY]", quantity).
    					replace("[DATE_PURCHASED]", datePurchased);

    				$("tbody").append(tpl);

    				__listen();

    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>