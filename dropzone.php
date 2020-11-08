<!DOCTYPE html>

<meta charset="utf-8">
<title>Dropzone simple example</title>
<script src="./node_modules/dropzone/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="./node_modules/dropzone/dist/min/dropzone.min.css">

<!-- <form action="/upload-target" class="dropzone"></form> -->
<div class="dz-preview dz-file-preview">
  <div class="dz-details">
    <div class="dz-filename"><span data-dz-name></span></div>
    <div class="dz-size" data-dz-size></div>
    <img data-dz-thumbnail />
  </div>
  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
  <div class="dz-success-mark"><span>✔</span></div>
  <div class="dz-error-mark"><span>✘</span></div>
  <div class="dz-error-message"><span data-dz-errormessage></span></div>
</div>
<div id="test" class="dropzone-previews"></div>
<form enctype="multipart/form-data" id="dropzone" action="ajax.php" method="POST">
</form>
<style type="text/css">
	#test {
		width: 200px;
		height: 200px;
		background: orange;
	}
	form {
		width: 400px;
		height: 400px;
		border: 1px dashed black;
	}
</style>


	<?php include_once "./foot.php"; ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				var myDropzone = new Dropzone("#dropzone");

				myDropzone.on("addedfile", function(file) {
					console.log("addedfile", file);
				  file.previewElement.addEventListener("click", function() {
				    myDropzone.removeFile(file);
				  });
				});


			});
		})(jQuery);
	</script>