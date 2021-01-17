<?php include_once "./headchosen.php"; ?>
<?php $model->checkAccess(); ?>
<body>
	<?php include_once "./spinner.php"; ?>
	<div class="container-fluid">
		<div class="row">
			<br>
			<div class="col-sm-2 sidenav">
				<?php $active = "purchaseOrder"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-10">
				<?php include_once "./dashboardnav.php"; ?>
				<?php include_once "./error.php"; ?>
				<br>
				<div class="col-sm">
				  	<?php
						$materials = $model->getAllMaterialInventory();
						$units = $model->getStoreUnitsOfMeasurement();
						$vendors = $model->getAllVendors();
						$purchasedOrders = $model->getPurchaseOrders();
			        ?>
			        <div class="row">
			        	<div class="col-sm message">
			        		
			        	</div>
			        </div>
					<div class="row">
						<div class="col-sm-4">
							<h5>Raw Materials Inventory Information</h5>
							<form method="post" class="form">
								<input type="hidden" name="addPurchase" value="true">
								<div class="form-group">
									<label>Supplier Name:</label>
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
								<div class="form-group cDate hidden">
									<label for="type">Credit Date</label>
									<input type="date" class="form-control" id="creditDate" placeholder="Credit Date..." name="">
								</div>
								<div class="form-group">
									<label>Quantity:</label>
									<input type="number" class="form-control" value="" min="1" required  id="quantity" name="qty" placeholder="Quantity..."/>
								</div>
								<div class="form-group">
									<label>Unit:</label>
									<select id="unit"  class="form-control" name="unit">
		            					<?php foreach($units as $idx => $v): ?>
										<option value="<?= $v['unit'];?>"><?= $v['unit'];?></option>
		            					<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Price:</label>
									<input type="text" class="form-control" value="" required  id="price" name="price" placeholder="Price..."/>
								</div>
								<div class="form-group">
									<label>Date of purchase:</label>
									<input type="date" required class="form-control" value="" id="date_purchased" name="date_purchased" placeholder="Date..."/>
								</div>
								<div class="form-group">
									<label>Expiry Date:</label>
									<input type="date" required class="form-control" value="" id="expiry_date" name="expiry_date" placeholder="Date..."/>
								</div>
								<input type="submit" value="Add" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-8">
							<h5>Raw Materials Inventory List</h5>
							<table class="table">
								<thead>
									<tr>
										<th>Supplier</th>
										<th>Material</th>
										<th>Type</th>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Price</th>
										<th>Date Purchased</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="tbody">
									
								</tbody>
								<tfoot>
									<tr>
										<td colspan="6">
											<a href="" class="btn btn-success submit">Submit</a>
										</td>
									</tr>
								</tfoot>
            					<!-- <?php foreach($purchasedOrders as $idx => $p): ?>
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
			<td class="vendorname" data-id="[VENDORID]">[VENDORNAME]</td>
			<td class="materialname" data-id="[MATERIALID]">[MATERIALNAME]</td>
			<td class="type" data-credit=[CREDIT_DATE] data-id="[TYPEID]">[TYPE]</td>
			<td  data-unit="[UNIT]" class="quantity">[QUANTITY]</td>
			<td  class="unit">[UNIT]</td>
			<td  class="price">[PRICE]</td>
			<td data-expiry_date=[EXPIRY_DATE] class="date_purchased">[DATE_PURCHASED]</td>
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

	<script type="text/html" id="error">
	      <div class="alert alert-danger alert-dismissible fade show" role="alert">
	        <strong>Error!!</strong> [ERROR]
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
    			$("#slcProduct").chosen();
    			$("#slctMaterial").chosen();
    			$("#type").chosen();

    			$("#unit").chosen();
    			

    			$("#type").on("change", function(){
    				var val = $(this).val();

    				console.log(val);
    				if(val == "credit"){
    					$(".cDate").removeClass("hidden");
    				} else {
    					$(".cDate").addClass("hidden");
    				}
    			});

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
    				var tr = $("#tbody tr");

    				tr.each(function(x, y){
    					var tr = $(y);

    					if(tr.find(".vendorname").length >0){
    						var vendorName = tr.find(".vendorname").data("id");
	    					var materialName = tr.find(".materialname").data("id");
	    					var type = tr.find(".type").data("id");
	    					var quantity = tr.find(".quantity").html();
	    					var expiryDate = tr.find(".date_purchased").data("expiry_date");
	    					var unit = tr.find(".quantity").data("unit");
	    					var price = parseFloat(tr.find(".price").html());
	    					var dateProduced = tr.find(".date_purchased").html();
	    					var creditDate = tr.find(".type").data("credit");
	    					var production = Array(vendorName,materialName,type,quantity,dateProduced, creditDate, expiryDate, unit, price);

	    					data.push(production);
    					}
    					

    				});

    				if(data.length == 0){
    					return;
    				} 

    				$(".message").html("");
    				if(tr.length){
    					$.ajax({
							url : "ajax.php"
							, data : { addPurchase : true , data : data}
							, type : 'post'
							, dataType : 'json'
							, success : function(response){
								$("#tbody").html("");

								$(".message").append($("#success").html());
							}
						});	
    				}
    			});

    			$(".form").on("submit", function(e){
    				e.preventDefault();

    				var vendorId = $("#slcProduct").val();
    				var vendorName = $("#slcProduct :selected").html();
    				var materialId = $("#slctMaterial").val();
    				var materialName = $("#slctMaterial :selected").html();
    				var typeId = $("#type").val();
    				var typeName = $("#type :selected").html();
    				var creditDate = $("#creditDate").val();

    				var quantity = $("#quantity").val();
    				var dateProduced = $("#date_purchased").val();
    				var expiryDate = $("#expiry_date").val();
    				var unit = $("#unit").val();
    				var price = $("#price").val();

    				var errCount = 0;

    				if(materialId == null){
    					var tpl = $("#error").html();

    					tpl = tpl.replace("[ERROR]", "Please add material first");

						$(".message").append(tpl);
						errCount++;
    				}
    				if(typeId == null){
    					var tpl = $("#error").html();

    					tpl = tpl.replace("[ERROR]", "Please add type first");

						$(".message").append(tpl);

						errCount++;
    				}
    				if(vendorId == null){
    					var tpl = $("#error").html();

    					tpl = tpl.replace("[ERROR]", "Please add Supplier first");

						$(".message").append(tpl);

						errCount++;
    				}

    				if(errCount == 0){
						var tpl = $("#tpl").html();
						tpl = tpl.replace("[MATERIALID]", materialId).
							replace("[MATERIALNAME]", materialName).
							replace("[TYPEID]", typeId).
							replace("[VENDORNAME]", vendorName).
							replace("[VENDORID]", vendorId).
							replace("[CREDIT_DATE]", creditDate).
							replace("[TYPE]", typeName).
							replace("[QUANTITY]", quantity).
							replace("[UNIT]", unit).
							replace("[UNIT]", unit).
							replace("[PRICE]", price).
							replace("[EXPIRY_DATE]", expiryDate).
							replace("[DATE_PURCHASED]", dateProduced);

						$("tbody").append(tpl);

						__listen();
    				}
    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>