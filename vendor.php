<?php include_once "./head.php"; ?>
<body>
  <?php include_once "./spinner.php"; ?>
  <div class="container-sm">
    <?php include_once "./dashboardnav.php"; ?>
    <div class="row">
      <br>
      <div class="col-sm-3">
        <?php  $active = "vendor";  include_once "./sidenav.php"; ?>
      </div>
      <div class="col-sm-9">
        <?php
          $vendors = $model->getAllVendors();
        ?>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">Vendor Name</th>
              <th scope="col">Contact #</th>
              <th scope="col">Address</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr id="search">
              <td colspan="4">
                <input type="text" class="form-control" id="searchName" placeholder="Name search..."/>
              </td>
            </tr>
            <?php foreach($vendors as $idx => $vendor): ?>

            <tr class="result" id="edit<?= $vendor['id']; ?>">
              <td class="editname"><?= $vendor['name']; ?></td>
              <td class="editsrp"><?= $vendor['contact']; ?></td>
              <td class="editqty"><?= $vendor['address']; ?></td>
              <td>
                <a href="" data-qty="<?= $vendor['qty']; ?>" data-expiry="<?= $vendor['expiry_date']; ?>" data-srp="<?= $vendor['srp']; ?>" data-id="<?= $vendor['id']; ?>" data-name="<?= $product['name']; ?>"class="btn btn-sm btn-warning edit"  data-toggle="modal" data-target="#editProductModal" alt="Edit product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg> </a>
                <a href="" data-id="<?= $vendor['id']; ?>" class="btn btn-sm btn-danger delete" alt="Delete Vendor"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
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

<script type="text/html" id="productTPL">
      <tr class="result" id="edit[ID]">
          <td class="editname">[NAME]</td>
          <td class="editsrp">[SRP]</td>
          <td class="editqty">[QTY]</td>
          <td>
            <a href="" data-qty="[QTY]" data-expiry="[EXPIRY]" data-srp="[SRP]" data-id="[ID]" data-name="[NAME]" class="btn btn-sm btn-warning edit"  data-toggle="modal" data-target="#editProductModal" alt="Edit product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg> </a>
            <a href="" data-id="[ID]"" class="btn btn-sm btn-danger delete" alt="Delete Product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
          </td>
        </tr>
</script>
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
                $(".preloader").addClass("hidden");
                
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
                }

                __listen();
                $(".preloader").addClass("hidden");

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
              data : { deleteVendor: true, id :id},
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

        function throttle(){
          setTimeout(function(){
            console.log('test');
          },1000);
        }

        const debounce = (func, wait) => {
          let timeout;

          return function executedFunction(...args) {
            const later = () => {
              clearTimeout(timeout);
              func(...args);
            };

            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
          };
        };

        var returnedFunction = debounce(function() {
          var txt = $("#searchName").val();

          $(".result").remove();
          $(".preloader").removeClass("hidden");

           $.ajax({
              url : "ajax.php"
              , data : { searchProduct : true, txt : txt }
              , type : "post"
              , dataType : "json"
              , success : function(response){
                // productTPL
                console.log(response);
                for(var i in response){
                  console.log(response[i].name);
                  var tpl = $("#productTPL").html();

                  tpl = tpl.replace("[ID]", response[i].id).replace("[ID]", response[i].id).replace("[ID]", response[i].id).replace("[NAME]", response[i].name).replace("[NAME]", response[i].name)
                  .replace("[SRP]", response[i].srp).replace("[SRP]", response[i].srp).replace("[QTY]", response[i].qty).replace("[QTY]", response[i].qty);

                  $("#search").after(tpl);
                }
                
                __listen();
                setTimeout(function(){
                  $(".preloader").addClass("hidden");
                },200);


              }
            });

        }, 250);

        window.addEventListener('resize', returnedFunction);

        $('#searchName').on("keyup", returnedFunction);
      });

    })(jQuery);

  </script>
</body>
</html>