<?php include_once "./head.php"; ?>
<body>
  <?php include_once "./spinner.php"; ?>
  <div class="container-sm">
    <?php include_once "./dashboardnav.php"; ?>
    <div class="row">
      <br>
      <div class="col-sm-3">
        <?php include_once "./sidenav.php"; ?>
      </div>
      <div class="col-sm-9">
        <?php
          $products = $model->getAllProducts();
        ?>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">Product Name</th>
              <th scope="col">SRP</th>
              <th scope="col">Quantity</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($products as $idx => $product): ?>

            <tr>
              <td><?= $product['name']; ?></td>
              <td><?= $product['srp']; ?></td>
              <td><?= $product['qty']; ?></td>
              <td>
                <a href="" class="btn btn-sm btn-warning">edit</a>
                <a href="" data-id="<?= $product['id']; ?>" class="btn btn-sm btn-danger delete">delete</a>
              </td>
            </tr>
            <?php endforeach ?>
           
           
          </tbody>
        </table>

      </div>
    </div>
    
  </div>

  <?php include_once "./foot.php"; ?>
  <script type="text/javascript">
    (function($){
      $(document).ready(function(){
        function __listen(){
          $(".delete").off().on("click", function(e){
            e.preventDefault();

            var me = $(this);
            var id = me.data("id");

            $(".preloader").removeClass("hidden");
            $.ajax({
              url : "ajax.php",
              data : { deleteProduct: true, id :id},
              type : "post",
              dataType : "json",
              success : function(response){
                me.parents("tr").remove();

                $(".preloader").addClass("hidden");
              }
            });
          });
        }

        __listen();
      });


    })(jQuery);

  </script>
</body>
</html>