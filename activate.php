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
					$store = $model->getUserStore();
					$amount = $store['cost'] * $store['duration'];
					$subscription = $model->getActiveSubscriptions();

					foreach($subscription as $idx => $sub): ?>
						<div class="col-sm-4 cardd">
							<div class="card mb-3 <?= ($sub['id'] == $store['subscriptionid']) ? 'border-success' : '';?>"   data-price="<?= $sub['cost'] * $sub['duration'];?>" style="max-width: 18rem;">
							  <div class="card-header"><?= $sub['title'];?></div>
							  <div class="card-body <?= ($sub['id'] == $store['subscriptionid']) ? 'text-success' : '';?>">
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
					 	#card-errors {
					 		margin-top: 10px;
					 		padding: 0;
					 	}
						button {
							background: #007bff;
							color: white;
							padding: 10px;
							border-radius: 5px;
							border: 0;
							font-weight: 700;
							margin-top: 10px;
						}
						.StripeElement {
						    box-sizing: border-box;
						   
						    height: 40px;
						   
						    padding: 10px 12px;
						   
						    border: 1px solid transparent;
						    border-radius: 4px;
						    background-color: white;
						   
						    box-shadow: 0 1px 3px 0 #e6ebf1;
						    -webkit-transition: box-shadow 150ms ease;
						    transition: box-shadow 150ms ease;
						}
						 
						.StripeElement--focus {
						    box-shadow: 0 1px 3px 0 #cfd7df;
						}
						 
						.StripeElement--invalid {
						    border-color: #fa755a;
						}
						 
						.StripeElement--webkit-autofill {
						    background-color: #fefde5 !important;
						}
						#amount {
							display: none;
						}
						.StripeElement,
						#payment-form {
							width: 100%;
						}
					</style>
					<script src="https://js.stripe.com/v3/"></script>
					<form action="charge.php" method="post" id="payment-form">
					    <div class="form-row">
					        <input type="text" name="amount" id="amount" placeholder="Enter Amount" value="<?= $amount;?>" />
					        <label for="card-element">Credit/Debit Card</label>
					        <div id="card-element">
					        <!-- A Stripe Element will be inserted here. -->
					        </div>
					 
					        <!-- Used to display form errors. -->
					        <div id="card-errors" class="alert alert-danger" role="alert"></div>
					    </div>
					    <button>Submit Payment</button>
					</form>
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

					$("#amount").val(price);
					console.log(price);
				});   
			});
		})(jQuery);
	</script>

</body>
</html>