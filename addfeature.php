<?php include_once "./admindropzonehead.php"; ?>
<body>
	<div class="container-sm">
		<?php include_once "./admindashboardnav.php"; ?>
		<div class="row">
			<style type="text/css">
				.dropzone {
					border: 2px dashed #eee;
					margin: 20px auto;
					display: inline-block;
					position: relative;
					box-sizing: border-box;
				}
				#dropzone p.caption {
					position: absolute;
					top: 20%;
					left: 0;
					opacity: .7;
					text-align: center;
					width: 100%;
				}
				.dz-image img {
					max-width: 100%;
				}
			</style>
			<br>
			<div class="col-sm-3">
				<?php  $active = "settings"; include "./adminsidenav.php"; 
					$assets = $model->getAdminAssets();
				?>
			</div>
			<div class="col-sm-9">
				
				<br>
				<h5>Add Feature</h5>
				<form  id="dropzone" action="ajax.php">
					<input type="hidden" name="assetupload" value="true">
					<p class="caption">Drop files here</p>
				</form>
				<style type="text/css">
				#dropzone {
					padding: 50px 20px;
					margin: 20px auto;
					border: 5px dashed #eee;
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
				</style>
				<div class="row assets">
					<?php foreach($assets as $idx => $a): ?>
					<div class="col-sm-2">
						<img class="img" src="<?= $a;?>">
					</div>
					<?php endforeach ?>
				</div>  
				<br> 
				<div class="row  ">
		          <div class="col-sm msg hidden"></div>
		        </div>
				<div class="row">
					<div class="col-sm">
						<form id="addSlider">
							<input type="hidden" name="addSlider" value="true">
							<div class="form-group">
								<label>Title</label>
								<input type="text"  id="title" required class="form-control" name="title" placeholder="Title...">
							</div>
							<div class="form-group">
								<label>Subtext</label>
								<textarea rows="10" class="form-control" name="subtext" id="subtext"></textarea>
							</div>
							<input type="submit" class="btn btn-lg btn-primary" value="Add">
						</form>
					</div>
				</div>	
			</div>

		</div>
	</div>
	<script type="text/html" id="tpl">
		<div class="col-sm-2">
			<img class="img active" src="./uploads/admin/[SRC]">
		</div>
	</script>
	<script type="text/html" id="success">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!!</strong> You have sucessfully added this product.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	</script>
	<?php include_once "./foot.php"; ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				function __listen() {
					$(".img").off().on("click", function(){
						var me = $(this);

						$(".img.active").removeClass("active");
						me.addClass("active");
					});
				}

				__listen();

				$("#addSlider").on("submit", function(e){
					e.preventDefault();

					var img = $(".img.active");

					if(img.length == 0){
						alert("Please select an image first.");
					} else {
						$.ajax({
							url : "ajax.php",
							data : {
								addSlider :true,
								addNews : true,
								photo : img.attr("src"),
								title : $("#title").val(),
								subtext : $("#subtext").val()
							},
							type : "post",
							dataType : "json",
							success : function(response){
				                $(".msg").append($("#success").html());
				                $(".msg").removeClass("hidden");
							}
						});
					}
				});

				var myDropzone = new Dropzone("#dropzone");

				myDropzone.on("complete", function(file) {
					$(file.previewElement).find(".dz-success-mark, .dz-error-mark,.dz-details").remove();

					var tpl = $("#tpl").html();

					tpl = tpl.replace("[SRC]", file.name);
					$(".img.active").removeClass("active");
					$(".assets").append(tpl);

					__listen();

					file.previewElement.addEventListener("click", function() {
						+myDropzone.removeFile(file);
					});
				});
			});
		})(jQuery);
	</script>

</body>
</html>