<?php include "./head.php"; ?>
<body>
	<div class="container-sm">
	<?php include_once "./nav.php"; ?>

	<nav class="final" aria-label="breadcrumb">
		<ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="#" data-target=".signup" class="next enabled">Account</a></li>
		  <li class="breadcrumb-item"><a href="#" data-target=".store" class="next disabled store">Store</a></li>
		  <li class="breadcrumb-item"><a href="#" data-target=".personal" class="next disabled personal">Personal</a></li>
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
			min-height: 600px;
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
				<div class="err"></div>
				<input type="hidden" name="signup" value="true"/>
				<label>Username</label>
				<input type="text" value="<?= isset($_POST['username']) ? $_POST['username'] : '';?>" class="form-control" name="username" placeholder="Username..." required/>
				<label>Password</label>
				<input type="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '';?>" class="form-control" name="password" placeholder="Password..." required/>
				<label>Retype Password</label>
				<input type="password" value="<?= isset($_POST['password1']) ? $_POST['password1'] : '';?>" class="form-control" name="password1" placeholder="Password..." required/>
				<br>
				<br>
				<button class="btn btn-primary btn-lg float-right">Next <svg class="bi" width="30" height="30" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#chevron-compact-right"/></svg></button>
			</form>

			<br>
			<a href="" data-target=".store" class="disabled next hidden">Next</a>
		</div>






		<div class="store slide col-sm">
			<form method="post" class="form">
				<input type="hidden" name="addstore" value="true">
				<div class="row">
					<div class="form-group col-sm">
						<h5>Business Name</h5>
						<input type="text" class="form-control" name="name" value="" placeholder="Store Name..." required/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<h5>Details</h5>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<label>Address</label>
						<input type="text" required class="form-control" placeholder="Business Address..." name="adddress">
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-4">
						<label>DTI</label>
						<input type="text" required class="form-control" placeholder="DTI..." name="dti">
					</div>
					<div class="col-sm-4">
						<label>Email</label>
						<input type="email" required class="form-control" name="email">
					</div>
					<div class="col-sm-4">
						<label>Contact #</label>
						<input type="text" placeholder="Contact #..." class="form-control" name="contact" required>
					</div>
				</div>

				
				<br>
				<a href="" data-target=".signup" class="next enabled"><svg class="bi" width="50" height="50" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#chevron-compact-left"/></svg></a>

				<button class="btn btn-primary btn-lg float-right">Next <svg class="bi" width="30" height="30" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#chevron-compact-right"/></svg></button>
				<div class="err"></div>
			</form>
			<a href="" data-target=".personal" data-target="personal" class="disabled next hidden">Next</a>
		</div>

		<div class="personal slide col-sm">
			<h5>Personal Information</h5>
			<form method="post"  class="form">
				<input type="hidden" name="addPersonal" value="1">
				<div class="form-group">
			      <label for="inputPassword4">Full Name</label>
			      <input type="text" class="form-control" id="inputPassword4" value="" name="fullname" required>
			    </div>
			    <div class="form-group">
					<label for="inputAddress">Address</label>
					<input type="text" required class="form-control" id="inputAddress" value="" name="address" placeholder="1234 Main St">
				</div>
				<div class="form-row ">
					<div class="form-group col-sm">
						<label for="inputState">Contact Number</label>
						<input type="number" required  class="form-control" id="inputState" value="" name="contact">
					</div>
					<div class="form-group col-sm">
						<label for="inputEmail4">Email</label>
						<input type="email" name="email" class="form-control" required value="" id="inputEmail4">
					</div>
				</div>
				<br>
				<a href="" data-target=".store" class="next enabled"><svg class="bi" width="50" height="50" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#chevron-compact-left"/></svg></a>

				<button class="btn btn-primary btn-lg float-right">Next <svg class="bi" width="30" height="30" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#chevron-compact-right"/></svg></button>
				<div class="err"></div>
			</form>
			<a href="" data-target=".plan" data-target="store" class="disabled next hidden">Next</a>
	  	</div>

		<div class="plan slide  col-sm final">
			<h5>Choose Your Subscription Plan</h5>

			<div class="row">
				<?php 
				$subscription = $model->getActiveSubscriptions();

				foreach($subscription as $idx => $sub): ?>
					<div class="col-sm-3 cardd">
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
				<div class="col-sm">
					<a href="" data-target=".personal" class="next enabled"><svg class="bi" width="50" height="50" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#chevron-compact-left"/></svg></a>
					<label>
						<input type="checkbox" id="accept" name="">
						Accept <a href="termsc.php" target="_blank" class="terms">Terms & Conditions</a>
					</label>
					
					<a href="" id="purchase" class="btn btn-lg btn-secondary purchase float-right">Purchase</a>
				</div>
			</div>
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

				$("#accept").on("click", function(){
					var me = $(this);
					var val = me.is(":checked");
					console.log(val);

					if(val){
						$("#purchase").addClass("btn-success");
						$("#purchase").removeClass("btn-secondary");
					} else {
						$("#purchase").addClass("btn-secondary");
						$("#purchase").removeClass("btn-success");
					}
				});

				$(".purchase").on("click", function(e){
					e.preventDefault();
					var me = $(this);
					
					if(me.hasClass("btn-secondary")){
						return;
					}

					var plan = $(".border-success").data("plan");

					console.log(plan);
					if($(".border-success").length == 0){
						alert("Please select a subscription plan");

						return ;
					}

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
								var t = me.parents(".slide").find(".enabled");
								me.find(".err").first().html("");
								
								__listen();

								t.trigger("click");
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