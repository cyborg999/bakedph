<?php include_once "./head.php"; ?> 
<body>
	<div class="container-sm">
		<?php include "./dashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php 
				$active = "user";   include_once "./sidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<br>
				<h3>Activate your account</h3>
				<div class="row">
					<?php 
					$subscription = $model->getActiveSubscriptions();

					foreach($subscription as $idx => $sub): ?>
						<div class="col-sm-4 cardd">
							<div class="card mb-3"   data-plan="<?= $sub['id'];?>" style="max-width: 18rem;">
							  <div class="card-header"><?= $sub['title'];?></div>
							  <div class="card-body">
							    <h5 class="card-title"><?= $sub['caption'];?></h5>
							    <p class="card-text"><?= $sub['cost'];?>/<small>Month</small></p>
							  </div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
				<div class="row">
					<style type="text/css">
						.card {
							cursor: pointer;
						}
						iframe#stripe {
							width: 100%;
							height: 100vh;
						}
					</style>
					<iframe id="stripe" src="stripe.php" frameborder="0"></iframe>
				</div>
			</div>
		</div>
	</div>
	<script src="./js/card.js"></script>

	<?php include_once "./foot.php"; ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
		         $(".card").on("click", function(){
					var me = $(this);
					var price = me.data("price");

					$(".border-success").find(".text-success").removeClass("text-success");
					$(".border-success").removeClass("border-success");

					me.addClass("border-success");
					me.find(".card-body").addClass("text-success");

					$("iframe#stripe").contents().find("#amount").val(price);
					console.log(price);
				});   
			});
		})(jQuery);
	</script>

</body>
</html>