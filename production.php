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
			          $production = $model->getAllProduction();

			        ?>
			        <div class="row">
			        	<div class="col-sm message">
			        		
			        	</div>
			        </div>
					<div class="row">
						<div class="col-sm-4">
							<h5>Production Information</h5>
							<form method="post" class="form">
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
									<input type="text" class="form-control" id="batchnumber" value="<?= isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '';?>" required name="batchnumber" placeholder="Batch #..."/>
								</div>
								<div class="form-group">
									<label>Quantity:</label>
									<input type="number" class="form-control" id="quantity" value="<?= isset($_POST['qty']) ? $_POST['qty'] : '';?>" required name="qty" placeholder="Quantity..."/>
								</div>
								<div class="form-group">
									<label>Date Produced:</label>
									<input type="date" required class="form-control" id="date_produced" value="<?= isset($_POST['date_produced']) ? $_POST['date_produced'] : '';?>"" name="date_produced" placeholder="Date..."/>
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
										<th>Date Produced</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4">
											<a href="" class="btn btn-success submit">Submit</a>
										</td>
									</tr>
								</tfoot>
            					<!-- <?php foreach($production as $idx => $p): ?>
            						<tr>
										<td><?= $p['name']; ?></td>
										<td><?= $p['batchnumber']; ?></td>
										<td><?= $p['quantity']; ?></td>
										<td><?= $p['date_produced']; ?></td>
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
			<td class="batchnumber">[BATCHNUMBER]</td>
			<td  class="quantity">[QUANTITY]</td>
			<td class="date_produced">[DATE_PRODUCED]</td>
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
    					var batchNumber = tr.find(".batchnumber").html();
    					var dateProduced = tr.find(".date_produced").html();

    					var production = Array(name,quantity,batchNumber,dateProduced);

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
								tr.html("");

								$(".message").append($("#success").html());
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
    				var dateProduced = $("#date_produced").val();
    				var productName = $("#slcProduct :selected").html();
    				tpl = tpl.replace("[NAME]", productName).
    					replace("[ID]", productId).
    					replace("[BATCHNUMBER]", batchNumber).
    					replace("[QUANTITY]", quantity).
    					replace("[DATE_PRODUCED]", dateProduced);

    				$("tbody").append(tpl);

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