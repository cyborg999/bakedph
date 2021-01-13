<?php include_once "./head.php"; ?>
<body>
	<div class="container-fluid">
		<div class="row">
			<br>
			<div class="col-sm-2 sidenav">
				<?php $profile = $model->getUserProfile(); $active = "user"; include "./sidenav.php"; ?>
			</div>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm">
						<?php include "./dashboardnav.php"; ?>
					</div>
				</div>
				<?php  include_once "./error.php"; ?>
				<br>

				<style type="text/css">
					#logo {
							width: 100px;
							height: auto;
						}
						.banner {
							background: #eee;
							border-radius: 4px;
							min-height: 250px;
							position: relative;
							margin-bottom: 50px;
						}
						.store-logo-container {
							position: absolute;
							bottom: -20px;
							left: 20px;
							height: 150px;
							width: 150px;
							border-radius: 10px;
						}
						.store-logo {

						}
						#profilePreview {
							height: 200px;
							width: 200px;
						}
						#dropzone {
						padding: 30px 20px;
						margin: 20px auto;
						border: 5px dashed black;
						display: inline-block;
						width: 100%;
						position: relative;
						box-sizing: border-box;
						}
						.assets {
							background: #eee;
							padding: 10px 0;
						}
						.img {
							width: 100%;
							height: auto;
							display: block;
							margin: 0 auto;
							cursor: pointer;
						}
						.img:hover {
							width: 105%;
							box-shadow: 1px 1px 10px black;
						}
						.dz-image {
							float: left;
						}
						.img.active {
							border:2px solid yellow;
						}
						.dz-preview {
							float: left;
						}
						label {
							margin-top: 10px;
						}
				</style>
				<div class="row">
					<div class="col-sm">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Personal</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Store</a>
						  </li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane row fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
								<br>
								<div class="col-sm banner hidden">

								<!-- 	<form enctype="multipart/form-data" id="formProfileFrm" method="post">
										<input type="hidden" name="uploadpic">
										<input type="file" id="profile" name="profile" />
										<figure id="profilePreview"></figure>
									</form> -->
									<div class="store-logo-container">
										<?php if(file_exists("uploads/".$_SESSION['storeid'])): ?>
											<figure class="storelogo"></figure>
										<?php else: ?>
											<svg class="bi" width="150" height="150" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#image-fill"/></svg>
										<?php endif ?>
									</div>
								</div>
								<div class="col-sm">
									<?php include_once "./error.php"; ?>
									<form method="post" action="profile.php" enctype="multipart/form-data">
										<input type="hidden" name="updateUserInfo" value="true">
										<div class="form-group">
											<label>Profile Picture</label>
											<br>
											<img id="logo" src="<?= ($profile) ? $profile['profilePicture'] : '';?>">
											<br>
											<br>
											<input type="file" name="merchantProfilePicture" />
										</div>
											<br>
									  <div class="form-row">
								  	 	<div class="form-group col-md-12">
									      <label for="inputPassword4">Full Name</label>
									      <input type="text" class="form-control" id="inputPassword4" value="<?= isset($profile['fullname']) ? $profile['fullname'] : '';?>" name="fullname">
									    </div>
									  </div>
									  <div class="form-group">
									    <label for="inputAddress">Address</label>
									    <input type="text" class="form-control" id="inputAddress" value="<?= isset($profile['address']) ? $profile['address'] : '';?>" name="address" placeholder="1234 Main St">
									  </div>
									  <div class="form-row ">
									    <div class="form-group col-md-4 hidden">
									      <label for="inputCity">Birthday</label>
									      <input type="date" value="<?= isset($profile['bday']) ? $profile['bday'] : '';?>" name="birthday" class="form-control" id="inputCity">
									    </div>
									    <div class="form-group col-md-4">
									      <label for="inputState">Contact Number</label>
									      <input type="number"  class="form-control" id="inputState" value="<?= isset($profile['contact']) ? $profile['contact'] : '';?>" name="contact">
									    </div>
									    <div class="form-group col-md-4">
								       		<label for="inputEmail4">Email</label>
								      		<input type="email" name="email" class="form-control" value="<?= isset($profile['email']) ? $profile['email'] : '';?>" id="inputEmail4">
									    </div>
									  </div>
									  <button type="submit" class="btn btn-primary">Update</button>
									</form>
									  <br>
								</div>
							</div>

							<div class="tab-pane row fade" id="profile" role="tabpanel" aria-labelledby="home-tab">
								<br>
								<?php
									$store = $model->getUserStore();
								?>
								<form method="post">
									<input type="hidden"  name="updateBusiness" value="true">
									<div class="col-sm">
										<div class="form-group">
											<label>Business</label>
											<input type="text" readonly class="form-control" placeholder="Store Name..." name="store" value="<?= ($store) ? $store['name'] : '';?>">
										</div>
										<div class="form-group">
											<label>Description</label>
											<textarea class="form-control" name="description" placeholder="Description..."><?= ($store) ? $store['description'] : '';?></textarea>
										</div>
										<div class="form-group">
											<label>Business Address</label>
											<input type="text" class="form-control" placeholder="Address..." name="b_address" value="<?= ($store) ? $store['b_address'] : '';?>">
										</div>
										<div class="form-group">
											<label>DTI</label>
											<input type="text" class="form-control" placeholder="DTI..." name="dti" value="<?= ($store) ? $store['dti'] : '';?>">
										</div>
										<div class="form-group">
											<label>Email</label>
											<input type="email" class="form-control" placeholder="Email..." name="b_email" value="<?= ($store) ? $store['b_email'] : '';?>">
										</div>
										<div class="form-group">
											<label>Contact #</label>
											<input type="text" class="form-control" placeholder="Contact #..." name="b_contact" value="<?= ($store) ? $store['b_contact'] : '';?>">
										</div>
										<input type="submit" class="btn btn-primary" value="Update" name="">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				

			</div>
			
			
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$("#profile").on("change", function(){
					var preview = $(this).val();
					console.log("changed");
					console.log(preview);
					// $("#profilePreview").attr("src", preview);
					$("#formProfileFrm").trigger("submit");

				});

				$("#formProfileFrm").on("submit", function(e){
					var me = $(this);
					e.preventDefault();

					$.ajax({
						url : "ajax.php",
						data : me.serialize(),
						type : "post",
						dataType : "json",
						success : function(response){
						}
					});
				});

			});
		})(jQuery);
	</script>

</body>
</html>