<?php include_once "./head.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "reports"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php include_once "./error.php"; ?>
				<br>
				<h5>Purchase Information</h5>
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
			        			<th>Vendor</th>
			        			<th>Date Purchased</th>
			        			<th>Quantity</th>
			        		</tr>
			        	</thead>
			        	<tbody>
			        		<tr>
			        			<td>
			        				<select id="type" class="form-control">
			        					<option value="cash">Cash</option>
			        					<option value="credit">Credit</option>
			        				</select>
			        			</td>
			        			<td></td>
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
	<script type="text/javascript">
    	(function($){
    		$(document).ready(function(){
    			$(".badge").on("click", function(){
    				var me = $(this);
    				var type = "";

    				if(me.hasClass("badge-success")){
    					me.removeClass("badge-success");
    					me.addClass("badge-danger");

    					type = "credit";
    				} else {
    					me.addClass("badge-success");
    					me.removeClass("badge-danger");
    					type =