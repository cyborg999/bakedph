<?php include_once "./head.php"; ?>
<body>
	<div class="container-fluid">
		<?php include "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "user";   include_once "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<div class="jumbotron">
					<div class="row">
						
						<div class="col-sm">
							<figure class="highcharts-figure">
							    <div id="container"></div>
							</figure>
						</div>
						<div class="col-sm">
							<figure class="highcharts-figure">
							    <div id="line"></div>
							</figure>
						</div>
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
    			function loadLineChart(data, year){
					Highcharts.chart('line', {
					    chart: {
					        type: 'bar'
					    },
					    title: {
					        text: 'Monthly Product Sales'
					    },
					    subtitle: {
					        text: 'for the year: ' + year
					    },
					    xAxis: {
					        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
					        title: {
					            text: null
					        }
					    },
					    yAxis: {
					        min: 0,
					        title: {
					            text: 'Quantity',
					            align: 'high'
					        },
					        labels: {
					            overflow: 'justify'
					        }
					    },
					    tooltip: {
					        valueSuffix: ' millions'
					    },
					    plotOptions: {
					        bar: {
					            dataLabels: {
					                enabled: true
					            }
					        }
					    },
					    legend: {
					        layout: 'vertical',
					        align: 'right',
					        verticalAlign: 'top',
					        x: -40,
					        y: 80,
					        floating: true,
					        borderWidth: 1,
					        backgroundColor:
					            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
					        shadow: true
					    },
					    credits: {
					        enabled: false
					    },
					    series: data
					});

					
    			}

    			function loadPieChart(data){
    				Highcharts.chart('container', {
					    chart: {
					        type: 'pie',
					        options3d: {
					            enabled: true,
					            alpha: 45,
					            beta: 0
					        }
					    },
					    title: {
					        text: 'Current Month Production'
					    },
					    accessibility: {
					        point: {
					            valueSuffix: '%'
					        }
					    },
					    tooltip: {
					        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					    },
					    plotOptions: {
					        pie: {
					            allowPointSelect: true,
					            cursor: 'pointer',
					            depth: 35,
					            dataLabels: {
					                enabled: true,
					                format: '{point.name}'
					            }
					        }
					    },
					    series: [{
					        type: 'pie',
					        name: 'Quantity',
					        data: data
					    }]
					});
    			}
				

				const monthNames = ["January", "February", "March", "April", "May", "June",
				  "July", "August", "September", "October", "November", "December"
				];
				var d = new Date();
				var m = d.getMonth();
				var y = d.getFullYear();

    			$.ajax({
    				url : "ajax.php",
    				data : { loadMonthlyData : true, year : y, month : ++m},
    				type : "post",
    				dataType : "json",
    				success : function(response){
						loadPieChart(response);
    				}
    			});

    			$.ajax({
    				url : "ajax.php",
    				data : { loadLineChart : true, year : y, month : ++m},
    				type : "post",
    				dataType : "json",
    				success : function(response){
						loadLineChart(response, y);
    				}
    			});
    		});
    	})(jQuery);
    </script>
</body>
</html>