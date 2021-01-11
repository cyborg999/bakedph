<?php include_once "./head.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./admindashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "footer";  include_once "./adminsidenav.php"; ?>
			</div> 
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm">
						<?php include_once "./error.php"; ?>
						<?php
							$settings = $model->getAdminSetting();
						?>
						<br>
						<h5>Overview</h5>
						<form method="post" action="">
							<input type="hidden" name="updateTerms" value="overview">
							<textarea class="form-control" rows="10" name="overview" placeholder="Overview"><?= ($settings) ? $settings['overview'] : ''; ?></textarea>
							<br>
							<input type="submit" class="btn btn-primary" value="Update" name="">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once "./foot.php"; ?>
		<script type="text/javascript">
    	(function($){
    	
    	})(jQuery);
    </script>
</body>
</html>