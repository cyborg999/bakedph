<?php include "./head.php"; ?>
<body>
	<div class="container-sm">
	<?php include_once "./nav.php"; ?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="#">Account</a></li>
		  <li class="breadcrumb-item"><a href="#">Store</a></li>
		  <li class="breadcrumb-item active" aria-current="page">Plan</li>
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
	</style>
	<div class="row slider">
		<div class="signup slide ">
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
			<a href="" data-target=".store" data-target="store" class="disabled next">Next</a>
		</div>


		<div class="store slide">
			<form method="post" class="form">
				<input type="hidden" name="addstore" value="true">
				<label>Store Name:
					<input type="text" class="form-control" name="name" value="" placeholder="Store Name..." required/>
				</label>
				<input type="submit"  class="btn btn-primary btn-lg" value="submit"/>
				<div class="err"></div>
			</form>
			<a href="" data-target=".signup" class="next enabled">Previous</a>
			<a href="" data-target=".plan" data-target="store" class="disabled next">Next</a>
		</div>


		<div class="plan slide active">
			<h5>Choose Subscription Plan</h5>

			<form method="post"  class="form">
				<input type="submit" name="plan" value="3 Months">
				<input type="submit" name="plan" value="6 Months">
				<input type="submit" name="plan" value="1 Year">
				<div class="err"></div>
			</form>

			<a href="" data-target=".store" class="next enabled">Previous</a>
		</div>
	</div>	

	<?php include_once "./error.php"; ?>
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

						$(".slide").hide();
						$(".slide.active").removeClass("active");
						$(t).addClass("active").show();
					});

					$(".disabled").off().on("click", function(e){
						e.preventDefault();
						e.stopPropagation();
					});
				}


				__listen();
				

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
								

								console.log(response.final);
								// if(){

								// }
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