<?php include_once "./head.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./admindashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $profile = $model->getUserProfile(); $active = "user"; include "./adminsidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php  include_once "./error.php"; ?>
				<br>
				<h5>Change Password</h5>
				<form id="resetfrm" method="post" >
					<input type="hidden" name="resetpassword" value="true">
					<div class="form-group">
						<label>Old Password</label>
						<input type="password" value="<?= (isset($_POST['oldpassword'])) ? $_POST['oldpassword'] : '';?>" class="form-control" name="oldpassword" placeholder="Old Password..." required/>
					</div>
					<div class="form-group">
						<label>New Password</label>
						<input type="password" value="<?= (isset($_POST['password'])) ? $_POST['password'] : '';?>" class="form-control" name="password" placeholder="New Password..." required/>
					</div>
					<div class="form-group">
						<label>Retype Password</label>
						<input type="password" value="<?= (isset($_POST['password1'])) ? $_POST['password1'] : '';?>" class="form-control" name="password1" placeholder="Retype New Password..." required/>
					</div>
					<input type="submit" class="btn btn-primary btn-l" value="Update">
				</form>
			</div>
		</div>
	</div>

	<?php include_once "./foot.php"; ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){

			});
		})(jQuery);
	</script>

</body>
</html>