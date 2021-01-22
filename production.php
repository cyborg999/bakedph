<?php include_once "./headui.php"; ?>
<?php $model->checkAccess(); ?>
<body>
	<div class="container-fluid">
		<div class="row">
			<br>
			<div class="col-sm-2 sidenav">
				<?php $active = "production"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-10">
					<?php include_once "./dashboardnav.php"; ?>
					<?php include_once "./error.php"; ?>
				<br>
				<div class="col-sm">
				  	<?php
			          $products = $model->getAllProducts();
			          $production = $model->getAllProduction();
			          $nextBatch = $model->getNextBatch();
			        ?>
			        <div class="row">
			        	<div class="message col-sm"></div>
			        </div>
			        <style type="text/css">
			        	#failedContent b {
			        		font-weight: normal;
			        	}
			        	#failedContent .insufficient b {
			        		font-weight: 700;
			        		color: red;
			        	}
			        </style>
					<div class="row">
						<div class="col-sm-4">
							<h5>Production Information</h5>
							<form method="post" class="form">
								<input type="hidden" name="addProduction" value="true">
								<div class="form-group">
									<label>Product Name:</label>
									<select id="slcProduct"  name="productid" class="form-control">
		            					<?php foreach($products as $idx => $product): ?>

										<option data-max="<?= $product['qty'];?>"  value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
		            					<?php endforeach ?>
									</select>
									<i><small>Current Stock: <span id="maxQty"><?= (count($products)) ? $products[0]['qty'] : 0; ?></span></small></i>
								</div>
								<div class="form-group">
									<label>Batch Number:</label>
									<input type="text" class="form-control" readonly id="batchnumber" value="<?= $nextBatch;?>" required name="batchnumber" placeholder="Batch #..."/>
								</div>
								<div class="form-group">
									<label>Price :</label>
									<input type="text" class="form-control"  id="price" value="<?= isset($_POST['price']) ? $_POST['price'] : '';?>" required name="price" placeholder="Price..."/>
								</div>
								<div class="form-group">
									<label>Quantity:</label>
									<input type="number" class="form-control" id="quantity" value="<?= isset($_POST['qty']) ? $_POST['qty'] : '1';?>" required min="1" name="qty" placeholder="Quantity..."/>
								</div>
								<div class="form-group">
									<label>Unit:</label>
									<input type="text" readonly="" class="form-control" id="unit" value="pcs" required name="unit" placeholder="Unit..."/>
								</div>
								<div class="form-group">
									<label># of Rejects:</label>
									<input type="number" class="form-control" id="rejects" value="<?= isset($_POST['rejects']) ? $_POST['rejects'] : '0';?>" required name="reject" min="0" placeholder="Rejects..."/>
								</div>
								<div class="form-group">
									<label>Date Produced:</label>
									<input type="text" readonly="readonly"  required class="from form-control" id="from" value="<?= date("m/d/Y");?>" name="date_produced" placeholder="Date..."/>
								</div>
								<div class="form-group">
									<label>Expiry Date:</label>
									<input type="text" readonly="readonly"  required class="to form-control" id="to"  name="expiry_date" placeholder="Date..."/>
								</div>
								<input type="submit" value="Add" class="btn btn-lg btn-primary">
							</form>
						</div>
						<div class="col-sm-8">
							<table class="table">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Batch #</th>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Price</th>
										<th>Reject</th>
										<th>Date Produced</th>
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
			<td class="batchnumber">[BATCHNUMBER]</td>
			<td data-unit="[UNIT]" data-rejects="[REJECTS]" class="quantity">[QUANTITY]</td>
			<td class="unit">[UNIT]</td>
			<td class="price">[PRICE]</td>
			<td class="reject">[REJECTS]</td>
			<td data-expiry="[EXPIRY]" class="date_produced">[DATE_PRODUCED]</td>
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
	<script type="text/html" id="failed">
	      <div class="alert alert-danger alert-dismissible fade show" role="alert">
	        <p><strong>Failed!!</strong> You dont have sufficient stock for some materials</p>
	        <div id="failedContent">[FAILED]</div>
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	</script>
	<!-- end alert script -->
	<?php include_once "./foot.php"; ?>
    <script src="./node_modules/chosen-js/chosen.jquery.min.js" ></script>
    <script src="./js/jquery-ui-1.12.1.custom/jquery-ui.min.js" ></script>
    <script type="text/javascript">
    	(function($){
    		$(document).ready(function(){
    			$("#slcProduct").on("change", function(){
    				var me = $(this);
    				var maxQty = me.find(":selected").data("max");

    				$("#maxQty").html(maxQty);
    			});

				var dateToday = new Date();
				var dates = $("#from, #to").datepicker({
				    defaultDate: "+1w",
				    changeMonth: true,
				    numberOfMonths: 2,
				    // minDate: dateToday,
				    onSelect: function(selectedDate) {
				        var option = this.id == "from" ? "minDate" : "maxDate",
				            instance = $(this).data("datepicker"),
				            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
				        dates.not(this).datepicker("option", option, date);
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
    					var name = tr.find(".name").data("id");
    					var quantity = tr.find(".quantity").html();
    					var unit = tr.find(".quantity").data("unit");
    					var batchNumber = tr.find(".batchnumber").html();
    					var dateProduced = tr.find(".date_produced").html();
    					var dateExpiry = tr.find(".date_produced").data("expiry");
    					var rejects = tr.find(".quantity").data("rejects");
    					var price = tr.find(".price").html();

    					var production = Array(name,quantity,batchNumber,dateProduced,unit,dateExpiry, tr.find(".name").html(), price, rejects);

    					data.push(production);

    				});

    				$(".message").html("");

    				if(tr.length){
    					$.ajax({
							url : "ajax.php"
							, data : { addProduction : true , data : data}
							, type : 'post'
							, dataType : 'json'
							, success : function(response){
								if(response.added){
									$("#tbody").html("");

									$(".message").append($("#success").html());
									
									window.location.href = "allproducts.php?id="+response.ids;
								} else {
									var tpl = $("#failed").html();

									tpl = tpl.replace("[FAILED]", response.msg);

									$(".message").append(tpl);
								}
							}
							, complete : function(){
								// window.location.href = "production.php";
							}
						});	
    				}
    			});

    			$("#slcProduct").chosen();

    			$(".form").on("submit", function(e){
    				e.preventDefault();

    				var tpl = $("#tpl").html();
    				var productId = $("#slcProduct").val();
    				var batchNumber = $("#batchnumber").val();
    				var quantity = $("#quantity").val();
    				var reject = $("#rejects").val();
    				var unit = $("#unit").val();
    				var dateProduced = $("#from").val();
    				var expiryDate = $("#to").val();
    				var productName = $("#slcProduct :selected").html();
    				var price = $("#price").val();

    				tpl = tpl.replace("[NAME]", productName).
    					replace("[ID]", productId).
    					replace("[BATCHNUMBER]", batchNumber).
    					replace("[QUANTITY]", quantity).
    					replace("[UNIT]", unit).
    					replace("[UNIT]", unit).
    					replace("[PRICE]", price).
    					replace("[REJECTS]", reject).
    					replace("[REJECTS]", reject).
    					replace("[EXPIRY]", expiryDate).
    					replace("[DATE_PRODUCED]", dateProduced);

    				if(dateProduced == ""){
    					alert("Please select Date Produced");
    					return;
    				}

    				if(expiryDate == ""){
    					alert("Please select Expiry Date");
    					return;
    				}
    				
    				$("#tbody").append(tpl);

    				__listen();

    			});

    			$("#slcProduct").on("change", function(){
    				var me = $(this);

    				console.log(me.val());
    			});

    			
    		});
    	})(jQuery);
    </script>
</body>
</html>