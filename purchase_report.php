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
				<br>
				<?php include_once "./error.php"; ?>
				<div class="row">
					<?php
			          $purchasedOrders = $model->getPurchaseOrders();


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
	<script type="text/javascript">
    	(function($){
    		$(document).ready(function(){
    			function loadChart(){
    				Highcharts.chart('container', {
					    chart: {
					        type: 'column'
					    },
					    title: {
					        text: 'Monthly Purchase'
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
					    series: [{
					        name: 'CheeseCake',
					        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

					    }, {
					        name: 'Fudgee Bar',
					        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

					    }]
					});
    			}

    			loadChart();
    		});
    	})(jQuery);
    </script>
</body>
</html>