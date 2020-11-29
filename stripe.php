<!DOCTYPE html>
<html>
<head></head>
<body>
	<div class="container-sm">
		<div class="row">
			<br>
			<div class="col-sm-3">
			</div>
			<div class="col-sm-9">
				<style type="text/css">
				 	#card-errors {
				 		color: red;
				 		padding: 10px 0;
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
				</style>
				<script src="https://js.stripe.com/v3/"></script>
				<div class="form-row">
			        <input type="text" id="amount" name="amount" placeholder="Enter Amount" />
			        <label for="card-element">Credit or debit card </label>
			        <br>
			        <div id="card-element">
			        <!-- A Stripe Element will be inserted here. -->
			        </div>
			 
			        <!-- Used to display form errors. -->
			        <div id="card-errors" role="alert"></div>
			    </div>
			    <button>Submit Payment</button>
			</div>
		</div>
	</div>
	<script src="./js/card.js"></script>


</body>
</html>