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
                <a href="" class="btn btn-sm btn-warning"  data-toggle="modal" data-target="#editProductModal">edit</a>
                <a href="" data-id="<?= $product['id']; ?>" class="btn btn-sm btn-danger delete">delete</a>
              </td>
            </tr>
            <?php endforeach ?>
           
           
          </tbody>
        </table>
      </div>
    </div>
    
  </div>

<!-- Modal -->
<div class="modal fade" id="editProductModal" data-id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <h5>Product Information</h5>
            <form method="post">
              <input type="hidden" name="addproduct" value="true">
              <div class="form-group">
                <label>Product Name:
                  <input type="text" required class="form-control" name="name" value="" placeholder="Product Name..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Price:
                  <input type="text" required class="form-control" name="price" placeholder="Price..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Quantity:
                  <input type="number" required class="form-control" name="qty" placeholder="Quantity..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Expiry Date:
                  <input type="date" required class="form-control" name="expiry" placeholder="Expiry Date..."/>
                </label>
              </div>
              <input type="submit" class="btn btn-lg btn-success" value="Update">
            </form>
          </div>


          <div class="col-sm-8">
            <h5>Raw Materials</h5>
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td colspan="2">Larry the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
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