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
			          $sales = $model->getStoreSalesReturn();
			        ?>
			        <div class="row">
			        	<div class="col-sm message">
			        		
			        	</div>
			        </div>
					<div class="row">
						<div class="col-sm-4">
							<h5>Sale Return Information</h5>
							<form method="post" class="form">
								<input type="hidden" name="addSalesReturn" value="true">
								<div class="form-group">
									<label>Product</label>
									<select id="product" class="form-control">
										<?php foreach($sales as $idx => $s): ?>
											<option value="<?= $s['productid'];?>"><?= $s['name'];?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Quantity</label>
									<input type="number" required class="form-control" id="qty" placeholder="Qty...">
									</select>
								</div>
								<div class="form-group">
									<label>Unit</label>
									<input type="text" readonly value="pcs" class="form-control" id="unit" placeholder="Unit...">
								</div>
								<div class="form-group">
									<label>Amount</label>
									<input type="number" required class="form-control" id="amount" placeholder="Amount...">
									</select>
								</div>
								<div class="form-group">
									<label>Date Purchased</label>
									<input type="date" required class="form-control" id="date_purchased" placeholder="Date Purchased...">
									</select>
								</div>
								<input type="submit" value="Add" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-8">
							<h5>Sales Return List</h5>
							<table class="table">
								<thead>
									<tr>
										<th>Product</th>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Price</th>
										<th>Date Purchased</th>
									</tr>
								</thead>
								<tbody id="tbody">
									
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5">
											<a href="" class="btn btn-success submit">Submit</a>
										</td>
									</tr>
								</tfoot>
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
			<td  class="product" data-productid="[PRODUCTID]">[PRODUCT]</td>
			<td class="qty">[QUANTITY]</td>
			<td class="unit">[UNIT]</td>
			<td class="amount">[AMOUNT]</td>
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


    					var product = tr.find(".product").html();
    					var amount = tr.find(".amount").html();
    					var qty = tr.find(".qty").html();
    					var unit = tr.find(".unit").html();
    					var productId = tr.find(".product").data("productid");
    					var datePurchased = tr.find(".date_purchased").html();

    					var production = Array(productId,product,amount,qty,unit,datePurchased);

    					data.push(production);
    				});

    				$(".message").html("");
    				
    				if(tr.length){
    					$.ajax({
							url : "ajax.php"
							, data : { addSalesReturn : true , data : data}
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

    				var tpl = $("#tpl").html();
    				var product = $("#product :selected").html();
    				var qty = $("#qty").val();
    				qty = parseInt(qty);

    				var unit = $("#unit").val();
    				var amount = $("#amount").val();
    				var datePurchased = $("#date_purchased").val();

    				tpl = tpl.replace("[PRODUCT]", product).
    					replace("[AMOUNT]", amount).
    					replace("[PRODUCTID]", $("#product :selected").val()).
    					replace("[QUANTITY]", qty).
    					replace("[UNIT]", unit).
    					replace("[DATE_PURCHASED]", datePurchased);

    				$("tbody").append(tpl);

    				__listen();

    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>