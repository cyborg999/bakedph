<?php include_once "./head.php"; ?> 
<body>
	<div class="container">
		<?php include "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm">
				<br>
				<div class="alert alert-success" role="alert">
			        <h4 class="alert-heading">Well done!</h4>
			        <p>Payment was successful! Please wait for the verification of your account by the moderator.</p>
			        <hr>
			        <p id="redirect">Redirecting in <span>3</span>.....</p>
  				</div>
			</div>
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				function timer(counter){
					setTimeout(function(){
			        	console.log(counter);
			        	$("#redirect span").html(counter);
			        	counter--;
			        	if(counter >= 1){
			        		timer(counter);
			        	} else {
			        		clearTimeout(timer);
			        		window.location = "dashboard.php";
			        	}



			        },1000);
				}
		        
		        timer(3);
			});
		})(jQuery);
	</script>
