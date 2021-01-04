<?php include_once "./headchosen.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./spinner.php"; ?>
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
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Chart</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Production Record</a>
						  </li>
						</ul>
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						  	
						  	<div class="form-row">
						  		<?php
						          $products = $model->getAllProducts();
						        ?>
								<div class="form-group col-sm-3">
									<label>Year
										<input type="number" class="form-control" placeholder="Year" id="year">
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
								<?php $monthlyData = $model->getMonthlyProductionReport(); ?>
								<div class="col-sm">
									<figure class="highcharts-figure">
									    <div id="container"></div>
									</figure>
								</div>
							</div>

						  </div>
						  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                						<a href="ajax.php?&export=true&production=true" class="export">export csv</a>
									</div>
									<div class="col-sm-5">
									
										<div class="row " id="onedate">
											<div class="col-sm">
												<br>
												<br>
												<input type="date" id="date" class="form-control" placeholder="Enter date">
											</div>
										</div>
										<div class="row " id="yearRow">
											<div class="col-sm">
												<br>
												<br>
												<input type="text" id="yeardate" class="form-control" placeholder="Enter date">
											</div>
										</div>
										<div class="row" id="twodate">
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
						  	<?php $production = $model->getAllProduction();
						  		// op($production);
						  	 ?>
						  	<table class="table table-hover">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Batch #</th>
										<th>SRP</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Date Produced</th>
									</tr>
								</thead>
								<tbody id="saleTbody">
								<?php foreach($production as $idx => $p): ?>
            						<tr>
										<td><?= $p['name']; ?></td>
										<td><?= $p['batchnumber']; ?></td>
										<td><?= $p['srp']; ?></td>
										<td><?= $p['quantity']; ?></td>
										<td><?= $p['srp'] * $p['quantity']; ?></td>
										<td><?= $p['date_produced']; ?></td>
									</tr>
            					<?php endforeach ?>
								</tbody>
							</table>
						  </div>
						</div>

					  

					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!-- start tpl -->
	<script type="text/html" id="tpl">
		<tr>
			<td>[NAME]</td>
			<td>[BATCH_NUMBER]</td>
			<td>[SRP]</td>
			<td>[QUANTITY]</td>
			<td>[AMOUNT]</td>
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
					        text: 'Monthly Production Report'
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

				$("#products").chosen({max_selected_options: 5});
				var d = new Date();
    			$.ajax({
    				url : "ajax.php",
    				data : { loadMonthlyProductChart : true, year : d.getFullYear()},
    				type : "post",
    				dataType : "json",
    				success : function(response){
    					var d = new Date();
    					loadChart(response, d.getFullYear());
    				}
    			});

    			$(".clear").on("click", function(e){
    				e.preventDefault();

    				$("#year").val("");
    				$("#date").val("");
    				$("#datestart").val("");
    				$("#yeardate").val("");

    				$("#products").val('').trigger("chosen:updated");

    				var tab = $(this).parents(".tab-pane");

    				tab.find(".btn-primary").trigger("click");
    			});

    			$("#twodate").hide();
				$("#yearRow").hide();

    			$(".filter").on("click", function(){
    				var me = $(this);

    				if(me.val() == "daterange"){
    					$("#onedate").hide();
    					$("#twodate").show();
    					$("#yearRow").hide();
    				} else if (me.val() == "day") {
    					$("#onedate").show();
    					$("#twodate").hide();
    					$("#yearRow").hide();
    				} else {
    					$("#onedate").hide();
    					$("#twodate").hide();
    					$("#yearRow").show();
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
    				$(".preloader").removeClass("hidden");

    				$.ajax({
    					url  : "ajax.php",
    					data : { 
    						filterProduction : true, 
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
    							var tpl = $("#tpl").html();

    							tpl = tpl.replace("[NAME]", response[i].name).
    							replace("[BATCH_NUMBER]", response[i].batchnumber).
    							replace("[DATE_PRODUCED]", response[i].date_produced).
    							replace("[QUANTITY]", response[i].quantity).
    							replace("[SRP]", response[i].srp).
    							replace("[AMOUNT]", response[i].srp * response[i].quantity).
    							replace("[DATE_PURCHASED]", response[i].date_purchased);
    							console.log(response[i]);

    							$("#saleTbody").append(tpl);
    						}

    						setTimeout(function(){
	    						$(".preloader").addClass("hidden");
    						},200);
    					}
    				});	
    			});

    			$("#filter").on("click", function(){
    				var year = $("#year").val();
    				var products = $("#products").val();

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