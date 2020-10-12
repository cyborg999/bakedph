<?php include_once "./head.php"; ?>
<body>
  <?php include_once "./spinner.php"; ?>
  <div class="container-sm">
    <?php include_once "./dashboardnav.php"; ?>
    <div class="row">
      <br>
      <div class="col-sm-3">
        <?php  $active = "product";  include_once "./sidenav.php"; ?>
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

            <tr id="edit<?= $product['id']; ?>">
              <td class="editname"><?= $product['name']; ?></td>
              <td class="editsrp"><?= $product['srp']; ?></td>
              <td class="editqty"><?= $product['qty']; ?></td>
              <td>
                <a href="" data-qty="<?= $product['qty']; ?>" data-expiry="<?= $product['expiry_date']; ?>" data-srp="<?= $product['srp']; ?>" data-id="<?= $product['id']; ?>" data-name="<?= $product['name']; ?>"class="btn btn-sm btn-warning edit"  data-toggle="modal" data-target="#editProductModal" alt="Edit product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg> </a>
                <a href="" data-id="<?= $product['id']; ?>" class="btn btn-sm btn-danger delete" alt="Delete Product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
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
        <div class="row  ">
          <div class="col-sm msg hidden"></div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <h5>Product Information</h5>
            <form method="post" id="editform">
              <input type="hidden" name="editproduct" id="editid" value="">
              <div class="form-group">
                <label>Product Name:
                  <input type="text" id="editname" required class="form-control" name="name" value="" placeholder="Product Name..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Price:
                  <input type="text" id="editprice" required class="form-control" name="price" placeholder="Price..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Quantity:
                  <input type="number" id="editqty" required class="form-control" name="qty" placeholder="Quantity..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Expiry Date:
                  <input type="date" id="editexpiry" required class="form-control" name="expiry" placeholder="Expiry Date..."/>
                </label>
              </div>
              <input type="submit" class="btn btn-lg btn-success" value="Update">

            </form>
          </div>


          <div class="col-sm-8">
            <h5>Raw Materials</h5>
            <table class="table table-hover table-sm" id="material">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
              <tfoot>
                <tr>
                  <td>
                    <input type="text" id="materialName" class="form-control" name="name" placeholder="Name..."/>
                  </td>
                  <td>
                    <input type="text" id="materialSrp" class="form-control" name="price" placeholder="SRP..."/>
                  </td>
                  <td>
                    <input type="number" id="materialQty" class="form-control" name="qty" placeholder="Quantity..."/>
                  </td>
                  <td>
                    <button id="addMaterial" class="btn btn-sm btn-primary" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#plus"/></svg></button>
                  </td>
                </tr>
              </tfoot> 
            </table>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/html" id="mats">
  <tr>
    <td>[NAME]</td>
    <td>[PRICE]</td>
    <td>[QTY]</td>
    <td>
      <button  class="btn btn-sm btn-danger deleteMaterial" data-id="[ID]"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></button>
    </td>
  </tr>
</script>
<script type="text/html" id="success">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!!</strong> You have sucessfully updated this product.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
</script>
  <?php include_once "./foot.php"; ?>
  <script type="text/javascript">
    (function($){
      $(document).ready(function(){
        function __listen(){
          $(".preloader").addClass("hidden");
          
          $(".deleteMaterial").off().on("click", function(e){
            e.preventDefault();

            var me = $(this);

            $(".preloader").removeClass("hidden");

            $.ajax({
              url : "ajax.php",
              data : { deleteMaterial : true, id : me.data("id")},
              type : "post",
              dataType : "json",
              success : function(response){
                $(".preloader").addClass("hidden");

                me.parents("tr").remove();
              }
            });

          });

          $("#editform").on("submit", function(e){
            e.preventDefault();

            var me = $(this);

            $.ajax({
              url : "ajax.php",
              data : me.serialize(),
              type : "post",
              dataType : "json",
              success : function(response){
                var tr = $("#edit"+response.editproduct);

                tr.find(".editname").html(response.name);
                tr.find(".editexpiry").html(response.expiry);
                tr.find(".editsrp").html(response.price);
                tr.find(".editqty").html(response.qty);

                $(".msg").append($("#success").html());
                $(".msg").removeClass("hidden");
                
              }
            });
          });

          $(".edit").off().on("click", function(e){
            e.preventDefault();
            
            var me = $(this);
            var data = me.data();

            $("#editname").attr("value", data.name);
            $("#editqty").attr("value", data.qty);
            $("#editprice").attr("value", data.srp);
            $("#editid").attr("value", data.id);
            $("#addMaterial").data("id", data.id);
            $("#editexpiry").attr("value", data.expiry);
            $(".msg").addClass("hidden");
            $(".preloader").removeClass("hidden");

            //get materials
            $.ajax({
              url : "ajax.php",
              data : { getMaterials : true, id : data.id},
              type : "post",
              dataType : 'json',
              success : function(response){
                for(var i in response){
                  var tpl = $("#mats").html();

                  tpl = tpl.replace("[NAME]", response[i].name).
                    replace("[ID]", response[i].id).
                    replace("[PRICE]", response[i].price).replace("[QTY]", response[i].qty);

                  $("#material tbody").append(tpl);
                  $(".preloader").addClass("hidden");
                }

                __listen();

              }
            });
          });

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

        $("#addMaterial").on("click", function(e){
          e.preventDefault();

          var name = $("#materialName").val();
          var srp = $("#materialSrp").val();
          var qty = $("#materialQty").val();
          var id = $(this).data("id");
          
          $(".preloader").removeClass("hidden");

          $.ajax({
            url : "ajax.php",
            data : { 
              addMaterial : true, 
              name : name,
              srp : srp,
              id : id,
              qty : qty
            },
            type : "post",
            dataType : "json",
            success :  function(response){
              if(response.added){
                var tpl = $("#mats").html();

                tpl = tpl.replace("[NAME]", name).
                  replace("[ID]", response.id).
                  replace("[PRICE]", srp).replace("[QTY]", qty);

                $("#material tbody").append(tpl);
                $(".preloader").addClass("hidden");

                __listen();
              } else {
                alert("You already added this material to this product.");
              }
              
            }
          });
        });

      });

    })(jQuery);

  </script>
</body>
</html>