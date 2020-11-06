<?php include_once "./headchosen.php"; ?>
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
						</div>
					  </div>
					</div>
				</div>
				<div class="row">
					<?php
			          $monthlyData = $model->getMonthlyProductionReport();

			          // opd($monthlyData);

					?>
					<div class="col-sm">
						<figure class="highcharts-figure">
						    <div id="container"></div>
						</figure>
					</div>
				</div>
			</div>
		</div>
	</div>
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

				$("#products").chosen({max_selected_options: 5});

    			$.ajax({
    				url : "ajax.php",
    				data : { loadMonthlySalesChart : true},
    				type : "post",
    				dataType : "json",
    				success : function(response){
    					loadChart(response, "2020");
    				}
    			});

    			$("#filter").on("click", function(){
    				var year = $("#year").val();
    				var products = $("#products").val();

    				if(year == ""){
    					alert("Year is required!");

    					return;
    				}

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