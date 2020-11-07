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