<?php include "./head.php"; ?>
<body>
	<div class="container-sm">
	<?php include_once "./nav.php"; ?>

	<nav class="final" aria-label="breadcrumb">
		<ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="#" data-target=".signup" class="next enabled">Account</a></li>
		  <li class="breadcrumb-item"><a href="#" data-target=".store" class="next disabled store">Store</a></li>
		  <li class="breadcrumb-item">
		  	<a href="" data-target=".plan" class="next disabled plan">Plan</a>
		  </li>
		</ol>
	</nav>
	<style type="text/css">
		.slider {
			position: relative;
		}
		.slider .slide {
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			min-height: 300px;
			z-index: 0;
			background: white;
		}
		.slide.active {
			z-index: 9;
		}
		a.disabled:hover,
		.disabled {
			color: gray;
			text-decoration: none;
		}
		.card {
			cursor: pointer;
		}
	</style>
	<div class="row slider final">
		<div class="signup slide col-sm active">
			<h4>Sign Up</h4>
			<form method="post"  class="form">
				<input type="hidden" name="signup" value="true"/>
				<label>Username
					<input type="text" value="<?= isset($_POST['username']) ? $_POST['username'] : '';?>" class="form-control" name="username" placeholder="Username..." required/>
				</label>
				<label>Password
					<input type="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '';?>" class="form-control" name="password" placeholder="Password..." required/>
				</label>
				<label>Retype Password
					<input type="password" value="<?= isset($_POST['password1']) ? $_POST['password1'] : '';?>" class="form-control" name="password1" placeholder="Password..." required/>
				</label>
				<br>
				<input type="submit" class="btn btn-primary btn-lg" value="Submit"/>
				<div class="err"></div>
			</form>
			<br>
			<hr>
			<a href="" data-target=".store" class="disabled next">Next</a>
		</div>


		<div class="store slide col-sm">
			<form method="post" class="form">
				<input type="hidden" name="addstore" value="true">
				<h4>Enter Store Name</h4>
				<input type="text" class="form-control" name="name" value="" placeholder="Store Name..." required/>
				<br>
				<input type="submit"  class="btn btn-primary btn-lg" value="submit"/>
				<div class="err"></div>
			</form>
			<a href="" data-target=".signup" class="next enabled">Previous</a>
			<a href="" data-target=".plan" data-target="store" class="disabled next">Next</a>
		</div>


		<div class="plan slide  col-sm final">
			<h5>Choose Your Subscription Plan</h5>

			<div class="row">
				<div class="col-sm">
					<div class="card mb-3" data-plan="3 Months" style="max-width: 18rem;">
					  <div class="card-header">Plan #1</div>
					  <div class="card-body">
					    <h5 class="card-title">3 Months</h5>
					    <p class="card-text">P600/<small>Month</small></p>
					  </div>
					</div>
				</div>
				<div class="col-sm">
					<div class="card border-success mb-3" data-plan="6 Months" style="max-width: 18rem;">
					  <div class="card-header">Plan #2</div>
					  <div class="card-body text-success">
					    <h5 class="card-title">6 Months</h5>
					    <p class="card-text">P550/<small>Month</small></p>
					  </div>
					</div>
				</div>
				<div class="col-sm">
					<div class="card mb-3" data-plan="1 Year" style="max-width: 18rem;">
					  <div class="card-header">Plan #3</div>
					  <div class="card-body">
					    <h5 class="card-title">1 Year Supply</h5>
					    <p class="card-text">P500/<small>Month</small></p>
					  </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm">
					<a href="" class="btn btn-lg btn-success purchase">Purchase</a>
				</div>
			</div>
			<a href="" data-target=".store" class="next enabled">Previous</a>
		</div>
	</div>	
	<div class="row">
		<div class="col-sm finish hidden">
		   	<div class="alert alert-success" role="alert">
		        <h4 class="alert-heading">Well done!</h4>
		        <p>You have succesfully registered a new store. </p>
		        <hr>
		        <p class="mb-0">Click <a href="login.php">here</a> to login.</p>
	      	</div>
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
	<script type="text/html" id="errors">

		<div class="alert alert-danger" style="margin-top: 5px;" role="alert">[MESSAGE]</div>
	</script>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				function __listen() {
					$(".enabled").off().on("click", function(e){
						e.preventDefault();

						let t = $(this).data("target");
						console.log(t);
						$(".slide").hide();
						$(".slide.active").removeClass("active");
						$(".breadcrumb").find(t).removeClass("disabled").addClass("enabled");
						$(t).addClass("active").show();
						
						__listen();
						
					});

					$(".disabled").off().on("click", function(e){
						e.preventDefault();
						e.stopPropagation();
					});
				}


				__listen();
				
				$(".purchase").on("click", function(e){
					e.preventDefault();

					var plan = $(".border-success").data("plan");

					console.log(plan);

					$.ajax({
						url : "ajax.php",
						data : { plan : plan},
						type : 'post',
						dataType : 'json',
						success : function(response){
							$(".finish").removeClass("hidden");
							$(".final").addClass("hidden");
						}
					});

				});

				$(".card").on("click", function(){
					var me = $(this);

					$(".border-success").find(".text-success").removeClass("text-success");
					$(".border-success").removeClass("border-success");

					me.addClass("border-success");
					me.find(".card-body").addClass("text-success");
				});

				$(".form").on("submit", function(e){
					e.preventDefault();

					var me = $(this);
					var data = me.serialize();

					$("#err").html();

					$.ajax({
						url : "ajax.php",
						data : data,
						type : "post",
						dataType : 'json',
						success : function(response){
							if(response.added){
								me.parents(".slide").find(".next").removeClass("disabled").addClass("enabled");
								me.find(".err").first().html("");
								
								__listen();
							} else {
								var errors = "";

								for(var i in response.errors){
									var tpl = $("#errors").html();
								console.log(response.errors[i]);

									errors = tpl.replace("[MESSAGE]", response.errors[i]);
								}

								me.find(".err").first().html(errors);
								me.parents(".slide").find(".next").removeClass("enabled").addClass("disabled");
							}
						}
					});
				});
			});

		})(jQuery);
	</script>
</body>
</html>