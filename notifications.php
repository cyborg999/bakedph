<?php include_once "./head.php"; ?>
<body>
  <?php include_once "./spinner.php"; ?>
  <div class="container-fluid">
    <div class="row">
      <br>
      <div class="col-sm-2 sidenav">
        <?php  $active = "notification";  include_once "./sidenav.php"; ?>
      </div>
      <div class="col-sm-10">
        <?php
          $products = $model->getNotifications();
        ?>
        <div class="row">
          <div class="col-sm">
            <?php include "./dashboardnav.php"; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <h5>Notifications</h5>
            <style type="text/css">
              #notifs tr {
                cursor: pointer;
              }
              #notifs .mr-3 {
                float: left;
              }
              .body td {
                padding: 30px 10px 60px;
                border-bottom: 1px solid #eee;
              }
              .title td {
                font-weight: normal;
                background: white;
              }
              .notseen td {
                font-weight: 500;
                background: #eee;
              }
            </style>
            <table class="table" id="notifs">
              <tbody>
                <?php foreach($products as $idx => $p): ?>
                <tr data-id="<?= $p['id'];?>" class="title <?= ($p['seen']) ? '' : 'notseen';?>">
                  <td><?= $p['title']; ?></td>
                  <td><?= date_format(date_create($p['date_added']), "D-M-Y");?></td>
                </tr>
                <tr class="body hidden">
                  <td colspan="2">
                    <?= $p['body'];?>
                  </td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
       
      </div>
    </div>
    
  </div>



  <?php include_once "./foot.php"; ?>
  <script src="./node_modules/chosen-js/chosen.jquery.min.js" ></script>
  <script type="text/javascript">
    (function($){
      $(document).ready(function(){
       
        $(".title").on("click", function(){
          var me = $(this);
          var id = me.data("id");

          me.removeClass("notseen");
          me.next(".body").toggleClass("hidden");

          $.ajax({
            url  : "ajax.php",
            data : { updateSeen : true, id : id},
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