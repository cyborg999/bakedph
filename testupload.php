
<?php
//index.php

?>
<!DOCTYPE html>
<html>
 <head>
  <title>How to Upload a File using Dropzone.js with PHP</title>

  <script src="./node_modules/dropzone/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="./node_modules/dropzone/dist/min/dropzone.min.css">
 </head>
 <body>
  <div class="container">
   <br />
   <h3 align="center">How to Upload a File using Dropzone.js with PHP</h3>
   <br />
   
   <form action="upload.php" class="dropzone" id="dropzoneFrom"></form>
   <br />
   <br />
   <div align="center">
    <button type="button" class="btn btn-info" id="submit-all">Upload</button>
   </div>
   <br />
   <br />
   <div id="preview"></div>
   <br />
   <br />
  </div>
  <?php include_once "./foot.php"; ?>

 </body>
</html>

<script>

$(document).ready(function(){
 
 Dropzone.options.dropzoneFrom = {
  autoProcessQueue: false,
  acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
  init: function(){
   this.on("complete", function(){
    if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
    {
     var _this = this;
     _this.removeAllFiles();
    }
    list_image();
   });
  },
 };

 // list_image();

 function list_image()
 {
  $.ajax({
   url:"upload.php",
   success:function(data){
    $('#preview').html(data);
   }
  });
 }

 $(document).on('click', '.remove_image', function(){
  var name = $(this).attr('id');
  $.ajax({
   url:"upload.php",
   method:"POST",
   data:{name:name},
   success:function(data)
   {
    list_image();
   }
  })
 });
 
});
</script>