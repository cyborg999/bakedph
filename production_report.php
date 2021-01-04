<?php include_once "./head.php"; ?>
<?php $model->checkAccess(); ?>
<body>
	<div class="container-sm">
		<?php include_once "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "reports"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<br>
				<?php include_once "./error.php"; ?>
				<div class="row">
					<div class="col-sm">
						<h5>Purchase Information</h5>
					</div>
					<div class="col-sm">
						<a class="float-right" href="./ajax.php?purchase=true">Export File <svg class="bi" width="20" height="20" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#file-earmark-spreadsheet-fill"/></svg></a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
					<?php
			          $purchasedOrders = $model->getPurchaseOrders();
			        ?>
			        <style type="text/css">
			        	.badge {
			        		cursor: pointer;
			        	}
			        </style>
			        <table class="table">
			        	<thead>
			        		<tr>
			        			<th>Purchase Type</th>
			        			<th>Material</th>
			        			<th>Supplier</th>
			        			<th>Date Purchased</th>
			        			<th>Quantity</th>
			        		</tr>
			        	</thead>
			        	<tbody>
			        		<tr id="result">
			        			<td>
			        				<select id="type" class="form-control">
			        					<option value="cash">Cash</option>
			        					<option value="credit">Credit</option>
			        				</select>
			        			</td>
			        			<td>
			        				<button id="filter" class="btn btn-md btn-primary">Filter</button>
			        			</td>
			        			<td></td>
			        			<td></td>
			        			<td></td>
			        			
			        		</tr>
			        		<?php foreach($purchasedOrders as $idx => $p): ?>
							<tr>
			        			<td>
									<span data-id="<?= $p['id'];?>" class="badge <?=($p['type'] == 'cash') ? 'badge-success' : 'badge-danger'?>"><?= $p['type'];?></span>
			        			</td>
			        			<td><?= $p['materialname'];?></td>
			        			<td><?= $p['vendorname'];?></td>
			        			<td><?= $p['date_purchased'];?></td>
			        			<td><?= $p['qty'];?></td>
			        		</tr>
			        		<?php endforeach ?>
			        	</tbody>
			        </table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
	<script type="text/html" id="purchase">
		<tr>
			<td>
				<span data-id="[ID]?>" class="badge [BADGE]">[TYPE]</span>
			</td>
			<td>[MATERIALNAME]</td>
			<td>[VENDORNAME]</td>
			<td>[DATE]</td>
			<td>[QTY]</td>
		</tr>
	</script>
	<script type="text/javascript">
    	(function($){
    		$(document).ready(function(){
    			function __listen(){
    				$(".badge").off().on("click", function(){
	    				var me = $(this);
	    				var type = "";

	    				if(me.hasClass("badge-success")){
	    					me.removeClass("badge-success");
	    					me.addClass("badge-danger");

	    					type = "credit";
	    				} else {
	    					me.addClass("badge-success");
	    					me.removeClass("badge-danger");
	    					type = "cash";
	    				}

						me.html(type);

	    				$.ajax({
	    					url : "ajax.php",
	    					data : { updatePurchaseType : true, id : me.data("id"), type : type  },
	    					type : "post" ,
	    					dataType : "json",
	    					success : function(response){

	    					}
	    				});
	    			});
    			}

    			__listen();

    			$("#filter").on("click", function(){
    				var type = $("#type").val();

    				$("tbody tr:not('#result')").remove();
    				$.ajax({
    					url : "ajax.php", 
    					data : { filterPurchase : true, type : type},
    					type : "post",
    					dataType : "json",
    					success : function(response){
    						for(var i in response){
    							var r = response[i];
    							var tpl = $("#purchase").html();

    							tpl = tpl.replace("[ID]",r.id).
    							replace("[TYPE]",r.type).
    							replace("[MATERIALNAME]",r.materialname).
    							replace("[VENDORNAME]",r.vendorname).
    							replace("[DATE]",r.date_purchased).
    							replace("[BADGE]", (r.type == 'cash')  ? 'badge-success' : 'badge-danger' ).
    							replace("[QTY]",r.qty);


    							$("#result").after(tpl);
    						}

			    			__listen();
    					}
    				});
    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>