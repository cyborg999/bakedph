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
										<th>Materials</th>
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
										<td colspan="9">
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
 <style type="text/css">
  .chosen-container-single .chosen-single,
  .chosen-container {
    width: 200px!important;
  }
</style>



<!-- Modal -->
<div class="modal fade" id="editProductModal" data-id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row  ">
          <div class="col-sm msg hidden"></div>
        </div>
        <div class="row">
          <div class="col-sm-5">
            <h5>Product Information</h5>
            <form method="post" id="editform">
              <input type="hidden" name="editproduct2" id="editid" value="">
              <div class="form-group">
                <label>Product Name:</label>
                <input type="text" id="editname" required readonly class="form-control" name="name" value="" placeholder="Product Name..."/>
              </div>
           <!--    <div class="form-group">
                <label>Price:</label>
                <input type="text" id="editprice" required class="form-control" name="price" placeholder="Price..."/>
              </div> -->
              <div class="form-group">
                <label>Quantity:</label>
                <input type="number" readonly id="editqty" required class="form-control" name="qty" placeholder="Quantity..."/>

              </div>
              <!-- <div class="form-group">
                <label>Expiry Date:</label>
                <input type="date" id="editexpiry" required class="form-control" name="expiry" placeholder="Expiry Date..."/>
              </div> -->
              <!-- <input type="submit" class="btn btn-lg btn-success" value="Update"> -->

            </form>
          </div>
          <div class="col-sm-7">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#raw" role="tab" aria-controls="home" aria-selected="true">Raw Materials Used</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="profile" aria-selected="false">Expenses</a>
              </li> -->
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="raw" role="raw" aria-labelledby="home-tab">
                <table class="table table-hover table-sm" id="material">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <!-- <th scope="col">Price</th> -->
                      <th scope="col">Unit</th>
                      <th scope="col">Quantity</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <td style="width: 200px;">
                        <style type="text/css">
                          .chosen-container-single .chosen-single,
                          .chosen-container {
                            width: 200px!important;
                          }
                        </style>
                        <select  id="materialName" class="form-control" >
                         
                        </select>

                      </td>
                     <!--  <td>
                        <input type="text" id="materialSrp" readonly class="form-control" name="price" placeholder="SRP..." required />
                      </td> -->
                      <td>
                        <select id="unit"  class="form-control" name="unit">
                          <option value="millilitre">Millilitre</option>
                          <option value="gram">Gram</option>
                          <option value="piece">Piece</option>
                        </select>
                      </td>
                      <td>
                        <input type="number" id="materialQty" class="form-control" name="qty" placeholder="Quantity..." min="1" required/>
                      </td>
                      <td>
                        <button id="addMaterial" class="btn btn-sm btn-primary" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#plus"/></svg></button>
                      </td>
                    </tr>
                  </tfoot> 
                </table>
                <!-- <h4 >Total Material Cost/<small>product quantity</small> : P<span id="total">0.00</span></h4> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

	<!-- tpl script -->
	<script type="text/html" id="tpl">
		<tr>
			<td>
			 	<a href="" data-qty="[QTY]" data-expiry="[EXPIRY]" data-srp="[SRP]" data-id="[ID]" data-name="[NAME]" class="btn btn-sm btn-link edit"  data-toggle="modal" data-target="#editProductModal" alt="Edit product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg> </a>
			</td>
			<td class="name" data-id="[ID]">
				<p>[NAME]</p>
			</td>
			<td class="batchnumber">[BATCHNUMBER]</td>
			<td data-unit="[UNIT]" data-rejects="[REJECTS]" class="quantity">
				[QUANTITY]
			</td>
			<td class="unit">[UNIT]</td>
			<td class="price">[PRICE]</td>
			<td class="reject">[REJECTS]</td>
			<td data-expiry="[EXPIRY]" class="date_produced">[DATE_PRODUCED]</td>
			<td>
				<a href="" class="delete btn btn-sm btn-danger" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
				
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

	<script type="text/html" id="mats">
	  <tr>
	    <td class="name">[NAME]</td>
	    <td>[UNIT]</td>
	    <td>
	    	<span class="qtyValue">[QTY]</span>
			<input type="text" class="qtyedit hidden" value="1">
	    </td>
	    <td>
	      <button  class="btn btn-sm btn-danger deleteMaterial" data-mid="[MID]" data-id="[ID]" data-price="[PRICE]" data-qty="[QTY]" data-unit="[UNIT]"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></button>
	      <a href="" class="editMaterial btn btn-sm btn-warning" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg></a>
	      <a href="" data-mid="[MID]" data-id="[ID]" class="saveEdit hidden btn btn-sm btn-success" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#check"/></svg></a>
	      <a href="" class="cancelEdit hidden btn btn-sm btn-danger" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#x"/></svg></a>
	    </td>
	  </tr>
	</script>

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

				// var dateToday = new Date();
				// var dates = $("#from, #to").datepicker({
				//     defaultDate: "+1w",
				//     changeMonth: true,
				//     numberOfMonths: 2,
				//     // minDate: dateToday,
				//     // maxDate: dateToday
				//     onSelect: function(selectedDate) {
				//         var option = this.id == "from" ? "minDate" : "maxDate",
				//             instance = $(this).data("datepicker"),
				//             date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
				//         dates.not(this).datepicker("option", option, date);
				//     }
				// });
				var currentDate = new Date();

				var dates = $("#from").datepicker({
					defaultDate: "+1w",
					endDate: "currentDate",
					maxDate: currentDate,
					 onSelect: function(selectedDate) {
					 	$("#to").datepicker({
					 		defaultDate: "+1w",
					 		changeMonth: true,
					 		numberOfMonths: 2
					 	});
				        $("#to").datepicker("option","minDate", selectedDate);
				    }
				});

				$("#addMaterial").on("click", function(e){
		          e.preventDefault();

		          var material = $("#materialName option:selected").data();
		          var srp = $("#materialSrp").val();
		          var qty = $("#materialQty").val();
		          var unit = $("#unit").val();
		          var id = $(this).data("id");
		          var max = $("#materialQty option:selected").data();

		          if(qty == ""){
		            alert("Please Input Quantity");
		            
		          } else if(qty > material.max) {
		            alert("Not enough stocks");

		          } else {
		            $.ajax({
		              url : "ajax.php",
		              data : { 
		                addMaterial : true, 
		                materialId : $("#materialName").val(),
		                id : id,
		                unit : unit,
		                qty : qty
		              },
		              type : "post",
		              dataType : "json",
		              success :  function(response){
		                if(response.added){
		                  var tpl = $("#mats").html(); 

		                  tpl = tpl.replace("[NAME]", material.name).
		                    replace("[ID]", response.id).
		                    replace("[ID]", response.id).
		                    replace("[MID]", $("#materialName").val()).
		                    replace("[UNIT]", unit).
		                    replace("[PRICE]", material.price).replace("[QTY]", qty).replace("[QTY]", qty).replace("[PRICE]", material.price).replace("[MID]", $("#materialName").val());

		                  $("#material tbody").append(tpl);
		                  var total = $("#total").html();

		                  $("#total").html(parseFloat(total) + (qty*material.price));
		                  __listen();
		                } else {
		                  alert("You already added this material to this product.");
		                }
		                
		                $(".preloader").addClass("hidden");
		                
		              }
		            });

		          }
		      
		        });

    			function __listen(){
    				$(".cancelEdit").off().on("click", function(e){
    					e.preventDefault();

    					var me = $(this);
    					var tr = me.parents("tr");
    					var qtyValue = tr.find(".qtyValue");
    					var qtyEdit = tr.find(".qtyedit");
    					var save = tr.find(".saveEdit");

    					qtyEdit.addClass("hidden");
    					qtyValue.removeClass("hidden");

    					tr.find(".deleteMaterial").removeClass("hidden");
    					tr.find(".editMaterial").removeClass("hidden");
    					tr.find(".saveEdit").addClass("hidden");
    					me.addClass("hidden");
    				});

    				$(".saveEdit").off().on("click", function(e){
    					e.preventDefault();

    					var me = $(this);
    					var tr = me.parents("tr");
    					var qtyValue = tr.find(".qtyValue");
    					var qtyEdit = tr.find(".qtyedit");
    					var save = tr.find(".saveEdit");


    					$.ajax({
    						url  : "ajax.php",
    						data : { saveMaterialEdit : true, qty : qtyEdit.val(), id : me.data("id"), materialId : me.data("mid")},
    						type : "post",
    						dataType : "json",
    						success : function(response){
		    					qtyValue.html(qtyEdit.val());
		    					qtyEdit.addClass("hidden");
		    					qtyValue.removeClass("hidden");
		    					tr.find(".editMaterial").removeClass("hidden");
		    					tr.find(".cancelEdit").addClass("hidden");
		    					$(".deleteMaterial").removeClass("hidden");
		    					me.addClass("hidden");
    						}
    					});
    				});

    				$(".editMaterial").off().on("click", function(e){
    					e.preventDefault();

    					var me = $(this);
    					var tr = me.parents("tr");
    					var qtyValue = tr.find(".qtyValue");
    					var qtyEdit = tr.find(".qtyedit");
    					var save = tr.find(".saveEdit");

    					qtyEdit.val(qtyValue.html());
    					qtyEdit.removeClass("hidden");
    					qtyValue.addClass("hidden");
    					save.removeClass("hidden");
    					me.addClass("hidden");
    					$(".deleteMaterial").addClass("hidden");
    					$(".cancelEdit").removeClass("hidden");
    				});

    				$(".deleteMaterial").off().on("click", function(e){
			            e.preventDefault();

			            var me = $(this);
			            var qty = me.data("qty");
			            var price = me.data("price");
			            var total = $("#total").html();


			            $(".preloader").removeClass("hidden");

			            $.ajax({
			              url : "ajax.php",
			              data : { deleteMaterial : true, qty : me.data("qty") ,id : me.data("mid")},
			              type : "post",
			              dataType : "json",
			              success : function(response){
			                $(".preloader").addClass("hidden");

			                me.parents("tr").remove();

			                $("#total").html(parseFloat(total) - (qty*price));
			              }
			            });

			          });


    				 $(".edit").off().on("click", function(e){
			            e.preventDefault();
			            
			            var me = $(this);
			            var data = me.data();

			            $("#editname").attr("value", data.name);
			            $("#editqty").attr("value", data.qty);
			            $("#editprice").attr("value", data.srp);
			            $("#editid").attr("value", data.id);
			            $("#addMaterial").data("id", data.id);
			            $("#addExpenses").data("id", data.id);
			            $("#editexpiry").attr("value", data.expiry);
			            $(".msg").addClass("hidden");
			            $(".preloader").removeClass("hidden");
			            $("#material").find("tbody").html("");
			            $("#total").html("");
			            $("#expensesTbl tbody").html("");
			            
			        
			            //get materials
			            $.ajax({
			              url : "ajax.php",
			              data : { materialSelect :true, getMaterials : true, id : data.id},
			              type : "post",
			              dataType : 'json',
			              success : function(res){
			                var total = 0;
			                var response = res.records;
			                var materials = res.materials;
			                var options = "";

			                for(var i in materials){
			                	console.log(i);
			                	if(i == 0){
			                		options = "<option selected>Select</option>";
			                		options += '<option data-price="'+materials[i].price+'"  data-max="'+materials[i].qty+'"  data-name="'+materials[i].name+'" value="'+materials[i].id+'">'+materials[i].name+'</option>';
			                	} else {
			                		options += '<option data-price="'+materials[i].price+'"  data-max="'+materials[i].qty+'"  data-name="'+materials[i].name+'" value="'+materials[i].id+'">'+materials[i].name+'</option>';
			                	}
			                }

			                $("#materialName").html(options);

			                for(var i in response){
			                  var tpl = $("#mats").html();

			                  tpl = tpl.replace("[NAME]", response[i].name).
			                    replace("[ID]", response[i].id).
			                    replace("[ID]", response[i].id).
			                    replace("[UNIT]", response[i].unit).
			                    replace("[PRICE]", response[i].price).replace("[QTY]", response[i].qty).replace("[QTY]", response[i].qty).replace("[PRICE]", response[i].price).
			                    replace("[MID]", response[i].materialid).
			                    replace("[MID]", response[i].materialid);

			                  total += response[i].price * response[i].qty;

			                  $("#material tbody").append(tpl);
			                }

			                __listen();
			                $("#total").html(total);
			                $(".preloader").addClass("hidden");

			              }
			            });
			          });

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
    					replace("[ID]", productId).
    					replace("[ID]", productId).
    					replace("[BATCHNUMBER]", batchNumber).
    					replace("[QUANTITY]", quantity).
    					replace("[QTY]", quantity).
    					replace("[NAME]", productName).
    					replace("[UNIT]", unit).
    					replace("[UNIT]", unit).
    					replace("[PRICE]", price).
    					replace("[SRP]", price).
    					replace("[REJECTS]", reject).
    					replace("[REJECTS]", reject).
    					replace("[EXPIRY]", expiryDate).
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