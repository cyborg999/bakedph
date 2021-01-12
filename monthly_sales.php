<?php include_once "./headchosen.php"; ?>
<?php $model->checkAccess(); ?>
<body>
	<div class="container-fluid">
		<?php include_once "./spinner.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-2 sidenav">
				<?php $active = "reports"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-10">
				<?php include_once "./dashboardnav.php"; ?>
				<br>
				<?php include_once "./error.php"; ?>
				<div class="row">
					<div class="col-sm">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Chart</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sales Record</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="exepenses" aria-selected="false">Expenses</a>
						  </li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
								<br>
								<div class="form-row">
							  		<?php  $products = $model->getAllProducts(); ?>
									<div class="form-group col-sm-3">
										<label>Year
											<input type="text" class="form-control" placeholder="Year" id="year">
										</label>
									</div>
									<div class="form-group col-sm-6">
										<label>Products
											<select id="products" placeholder="Products" class="form-control" multiple style="width: 400px;">
												<?php foreach($products as $idx => $product): ?>
												<option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
				            					<?php endforeach ?>
											</select>
										</label>
									</div>
									<div class="form-group col-sm-3">
										<br>
										<button id="filter" class="btn btn-md btn-primary">Filter <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#search"/></svg></button>
										<a href="" class="btn btn-info clear">Clear</a>
									</div>
							  	</div>
							  	<div class="row">
									<?php $monthlyData = $model->getMonthlyProductionReport(false,true); ?>
									<div class="col-sm">
										<figure class="highcharts-figure">
										    <div id="container"></div>
										</figure>
									</div>
								</div>

							</div>
							
							<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="home-tab">
								<div class="row">
									<div class="col-sm-4">
										<br>
										<label><b>Filter By:</b> </label>
										<br>
										<label> Day
											<input type="radio" class="filter" checked name="filter" value="day">
										</label>
										<label> Date Range
											<input type="radio" class="filter" name="filter" value="daterange">
										</label>
										<label> Year
											<input type="radio" class="filter" name="filter" value="year">
										</label>
										<br>
                						<a href="ajax.php?&export=true&salesMonthly=true" class="export">export csv</a>
										<br>
									</div>
									<div class="col-sm-5">
									
										<div class="row  onedate">
											<div class="col-sm">
												<br>
												<br>
												<input type="date" id="date" class="form-control" placeholder="Enter date">
											</div>
										</div>
										<div class="row  yearRow">
											<div class="col-sm">
												<br>
												<br>
												<input type="year" id="yeardate" class="form-control" placeholder="Enter date">
											</div>
										</div>
										<div class="row twodate">
											<div class="col-sm-6">
												<br>
												<label>Date Start:</label>
												<input type="date" id="datestart" class="form-control" placeholder="Enter date">
											</div>
											<div class="col-sm-6">
												<br>
												<label>Date End:</label>
												<input type="date" id="dateend" class="form-control" placeholder="Enter date">
											</div>
											
										</div>
										<br>
									</div>
									<div class="col-sm-3">
										<br>
										<br>
										<button id="salesFilter" class="btn btn-md btn-primary">Filter <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#search"/></svg></button>
										<a href="" class="btn btn-info clear">Clear</a>
									</div>
								</div>
								<?php 
									$sales = $model->getAllSales(); 
									$total = 0;
									$storeExpenses = $model->getExpensesTotal();

								?>
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Product Name</th>
											<th>Quantity</th>
											<th>Price</th>
											<th>Unit</th>
											<th>Amount</th>
											<th>Date Purchased</th>
										</tr>
									</thead>
									<tbody id="saleTbody">
										<?php foreach($sales as $idx => $p): ?>
											<?php $total += $p['revenue']; ?>
		            						<tr>
												<td><?= $p['name']; ?></td>
												<td><?= $p['qty']; ?></td>
												<td><?= $p['srp']; ?></td>
												<td><?= $p['unit']; ?></td>
												<td><?= $p['revenue']; ?></td>
												<td><?= $p['date_purchased']; ?></td>
											</tr>
		            					<?php endforeach ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6">
												<br>
												<p>Sales Total: <span id="salestotal"><?= $total;?></span></p>
												<p>Expenses Total: <span id="eeTotal"><?= $storeExpenses['total'];?></span></p>
											</td>
										</tr>
										<tr>
											<td colspan="6">
												<b>Net Total: <span id="NetTotal"><?= $storeExpenses['total']+ $total;?></span></b>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>

							<div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="expenses-tab">
								<div class="row">
									<div class="col-sm-4">
										<br>
										<label><b>Filter By:</b> </label>
										<br>
										<label> Day
											<input type="radio" class="filter" checked name="filter" value="day">
										</label>
										<label> Date Range
											<input type="radio" class="filter" name="filter" value="daterange">
										</label>
										<label> Year
											<input type="radio" class="filter" name="filter" value="year">
										</label>
										<br>
                						<a href="ajax.php?&export=true&expenses=true" class="export">export csv</a>
									</div>
									<div class="col-sm-5">
									
										<div class="row onedate">
											<div class="col-sm">
												<br>
												<br>
												<input type="date" id="exepensesDate" class="form-control" placeholder="Enter date">
											</div>
										</div>
										<div class="row yearRow">
											<div class="col-sm">
												<br>
												<br>
												<input type="year" id="expensesYeardate" class="form-control" placeholder="Enter date">
											</div>
										</div>
										<div class="row twodate">
											<div class="col-sm-6">
												<br>
												<label>Date Start:</label>
												<input type="date" id="expensesDatestart" class="form-control" placeholder="Enter date">
											</div>
											<div class="col-sm-6">
												<br>
												<label>Date End:</label>
												<input type="date" id="expensesDateend" class="form-control" placeholder="Enter date">
											</div>
											
										</div>
										<br>
									</div>
									<div class="col-sm-3">
										<br>
										<button id="expensesFilter" class="btn btn-md btn-primary">Filter <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#search"/></svg></button>
										<a href="" class="btn btn-info clear">Clear</a>
									</div>
								</div>
								<?php
									$expenses = $model->getStoreExpenses(); 
									$etotal = 0;
								?>
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Cost</th>
											<th>Date Produced</th>
										</tr>
									</thead>
									<tbody id="expensesTbody">
										<?php foreach($expenses as $idx => $p): ?>
											<?php
												$etotal += $p['cost'];
											?>
		            						<tr>
												<td><?= $p['name']; ?></td>
												<td><?= $p['cost']; ?></td>
												<td><?= $p['date_produced']; ?></td>
											</tr>
		            					<?php endforeach ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<h2>Expenses Total: <span id="expensesTotal"><?= $etotal;?></span></h2>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
			</div>
		</div>
	</div>

	<!-- start tpl -->
	<script type="text/html" id="tpl">
		<tr>
			<td>[NAME]</td>
			<td>[QUANTITY]</td>
			<td>[DATE_PURCHASED]</td>
		</tr>
	</script>
	<script type="text/html" id="expensesTpl">
		<tr>
			<td>[NAME]</td>
			<td>[COST]</td>
			<td>[DATE_PRODUCED]</td>
		</tr>
	</script>
	<!-- end tpl -->
	<script src="./node_modules/highcharts/highcharts.js"></script>
	<script src="./node_modules/highcharts/modules/exporting.js"></script>
	<script src="./node_modules/highcharts/modules/export-data.js"></script>
	<script src="./node_modules/highcharts/modules/accessibility.js"></script>
	<?php include_once "./foot.php"; ?>
    <script src="./node_modules/chosen-js/chosen.jquery.min.js" ></script>
	<script type="text/javascript">
    	(function($){
    		$(document).ready(function(){
    			function loadChart(data, year){
    				Highcharts.chart('container', {
					    chart: {
					        type: 'column'
					    },
					    title: {
					        text: 'Monthly Sales Report'
					    },
				       subtitle: {
					        text: 'for the year:' + year
					    },
					    xAxis: {
					        categories: [
					            'Jan',
					            'Feb',
					            'Mar',
					            'Apr',
					            'May',
					            'Jun',
					            'Jul',
					            'Aug',
					            'Sep',
					            'Oct',
					            'Nov',
					            'Dec'
					        ],
					        crosshair: true
					    },
					    yAxis: {
					        min: 0,
					        title: {
					            text: 'Quantity'
					        }
					    },
					    tooltip: {
					        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
					        footerFormat: '</table>',
					        shared: true,
					        useHTML: true
					    },
					    plotOptions: {
					        column: {
					            pointPadding: 0.2,
					            borderWidth: 0
					        }
					    },
					    series: data
					});
    			}

    			$(".clear").on("click", function(e){
    				e.preventDefault();

    				$("#yeardate").val("");
    				$("#year").val("");
    				$("#datestart").val("");
    				$("#dateend").val("");
    				$("#date").val("");
    				$("#expensesYeardate").val("");
    				$("#expensesDatestart").val("");
    				$("#expensesDateend").val("");
    				$("#date").val("");
    				$("#exepensesDate").val("");
    				$("#products").val('').trigger("chosen:updated");

    				var tab = $(this).parents(".tab-pane");

    				tab.find(".btn-primary").trigger("click");
    			});

				$("#products").chosen({max_selected_options: 5});
				
				var d = new Date();

    			$.ajax({
    				url : "ajax.php",
    				data : { loadMonthlySalesChart : true , year : d.getFullYear()},
    				type : "post",
    				dataType : "json",
    				success : function(response){
    					loadChart(response, d.getFullYear());
    				}
    			});

				$(".twodate, .yearRow").hide();
    		

    			$(".filter").on("click", function(){
    				var me = $(this);

    				if(me.val() == "daterange"){
    					$(this).parents(".row").find(".onedate").hide();
    					$(this).parents(".row").find(".twodate").show();
    					$(this).parents(".row").find(".yearRow").hide();
    				} else if (me.val() == "day") {
    					$(this).parents(".row").find(".onedate").show();
    					$(this).parents(".row").find(".twodate").hide();
    					$(this).parents(".row").find(".yearRow").hide();
    				} else {
    					$(this).parents(".row").find(".onedate").hide();
    					$(this).parents(".row").find(".twodate").hide();
    					$(this).parents(".row").find(".yearRow").show();
    				}
    			});

    			$("#salesFilter").on("click", function(e){
    				e.preventDefault();

    				var filter = $(".filter:checked").val();
    				var date = $("#date").val();
    				var dateStart = $("#datestart").val();
    				var dateEnd = $("#dateend").val();
    				var yeardate = $("#yeardate").val();

    				$("#saleTbody").html("");
    				$("#salestotal").html("");

    				showPreloader();

    				$.ajax({
    					url  : "ajax.php",
    					data : { 
    						filterSale : true, 
    						filter : filter, 
    						date1 : date, 
    						date2: dateStart, 
    						date3 : dateEnd , 
    						year : yeardate
    					},
    					type : "post",
    					dataType : "json",
    					success : function(res){
    						var response = res.record;
    						console.log(res.expensesTotal);
    						var total = 0;
    						for(var i in response){
    							var tpl = $("#tpl").html();

    							tpl = tpl.replace("[NAME]", response[i].name).
    							replace("[QUANTITY]", response[i].qty).
    							replace("[DATE_PURCHASED]", response[i].date_purchased);
    							total += parseInt(response[i].revenue);

    							$("#saleTbody").append(tpl);
    						}

    						$("#salestotal").html(total);
    						$("#eeTotal").html(res.expensesTotal.total);
    						$("#NetTotal").html(total-res.expensesTotal.total);

    						hidePreloader();
    					},
    					error : function(){
		                  hidePreloader();
		                }
    				});	
    			});

    			$("#expensesFilter").on("click", function(e){
    				e.preventDefault();

    				var filter = $(this).parents(".row").find(".filter:checked").val();
    				var date = $("#exepensesDate").val();
    				var dateStart = $("#expensesDatestart").val();
    				var dateEnd = $("#expensesDateend").val();
    				var yeardate = $("#expensesYeardate").val();
    				var total = 0;

    				$("#expensesTbody").html("");

    				showPreloader();
    				$.ajax({
    					url  : "ajax.php",
    					data : { 
    						filterExpenses : true, 
    						filter : filter, 
    						date1 : date, 
    						date2: dateStart, 
    						date3 : dateEnd , 
    						year : yeardate
    					},
    					type : "post",
    					dataType : "json",
    					success : function(response){
    						for(var i in response){
    							var tpl = $("#expensesTpl").html();

    							tpl = tpl.replace("[NAME]", response[i].name).
    							replace("[COST]", response[i].cost).
    							replace("[DATE_PRODUCED]", response[i].date_produced);

    							total += parseFloat(response[i].cost);

    							$("#expensesTbody").append(tpl);
    						}

    						$("#expensesTotal").html(total);

    						hidePreloader();
    					},
    					error : function(){
		                  hidePreloader();
		                }
    				});	
    			});

    			$("#filter").on("click", function(){
    				var year = $("#year").val();
    				var products = $("#products").val();

    				// if(year == ""){
    				// 	alert("Year is required!");

    				// 	return;
    				// }

	    			$.ajax({
	    				url : "ajax.php",
	    				data : { loadMonthlyProductChartByYear : true, year: year, products : products},
	    				type : "post",
	    				dataType : "json",
	    				success : function(response){
	    					loadChart(response, year);
	    				}
	    			});
    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>