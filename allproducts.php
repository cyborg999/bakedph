<?php include_once "./head.php"; ?>
<body>
  <?php include_once "./spinner.php"; ?>
  <div class="container-fluid">
    <div class="row">
      <br>
      <div class="col-sm-2 sidenav">
        <?php  $active = "product";  include_once "./sidenav.php"; ?>
      </div>
      <div class="col-sm-10">
        <?php include_once "./dashboardnav.php"; ?>
        <?php
          $materials = $model->getAllMaterialInventory();
          // opd($materials);
          $store = $model->getStoreStockLimit();
          $products = array();
          $ids = array();

          if(isset($_GET['id'])){
            $products = $model->getAllProduction(true);
            $ids = explode("|", $_GET['id']);
          } else {
            $products = $model->getAllProduction();
          }
        ?>
        <h5>All Products</h5>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Batch #</th>
              <th scope="col">Product Name</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Unit</th>
              <th scope="col">Date Produced</th>
              <th scope="col">Expiry Date</th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <tbody>
            <style type="text/css">
              .advance {
                display: block;
              }
              .expired {
                color: red;
                font-weight: 700;
              }
               .newlyadded {
                background: #f3f5f9;
              }
            </style>
            <tr>
              <td colspan="6">
                <input type="text" class="form-control" id="searchName" placeholder="Name search..."/>
              </td>
              <td>
                 <a href="ajax.php?&export=true&allproducts=true">export csv</a>
               </td>
            </tr>
            <tr  id="search" class="advance_tr hidden">
              <td colspan="2">
                <small style="max-width: 100%;"><i>Set alert when the remaining stock is less than or equal to</i></small>
              </td>
              <td >
                <input type="text" class="form-control" id="stock" value="<?= ($store) ? $store['product_low'] : 20;?>">
              </td>
              <td colspan="2">
                <a href="" class="updateAlert btn btn-sm btn-primary">update</a>
              </td>
            </tr>
            <?php foreach($products as $idx => $product): ?>

            <tr class="result <?= (in_array($product['id'], $ids)) ? 'newlyadded' : ''; ?> <?=($product['qty'] <= $store['product_low']) ? 'lowstock' : ''; ?>" id="edit<?= $product['id']; ?>">
              <td class="editbatch"><?= $product['batchnumber']; ?></td>
              <td class="editname"><?= $product['name']; ?></td>
              <td class="editsrp"><?= $product['price']; ?></td>
              <td class="editqty"><span class="<?= $product['isExpired']; ?>"><?= $product['remaining_qty']; ?></span>/<?= $product['quantity']; ?></td>
              <td class="editqty"><?= $product['unit']; ?></td>
              <td class="editproduced"><?= $product['date_produced']; ?></td>
              <td class="editexpiry"><?= $product['date_expired']; ?></td>
          <!--     <td>
                <a href="" data-qty="<?= $product['quantity']; ?>" data-expiry="<?= $product['expiry_date']; ?>" data-srp="<?= $product['srp']; ?>" data-id="<?= $product['id']; ?>" data-name="<?= $product['name']; ?>"class="btn btn-sm btn-warning edit"  data-toggle="modal" data-target="#editProductModal" alt="Edit product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg> </a>
                <a href="" data-id="<?= $product['id']; ?>" class="btn btn-sm btn-danger delete" alt="Delete Product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
              </td> -->
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
    
  </div>

<!-- Modal -->
<div class="modal fade" id="editProductModal" data-id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
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
          <div class="col-sm">
            <h5>Product Information</h5>
            <form method="post" id="editform">
              <input type="hidden" name="editproduct" id="editid" value="">
              <div class="form-group">
                <label>Product Name:</label>
                <input type="text" readonly id="editname" required class="form-control" name="name" value="" placeholder="Product Name..."/>
              </div>
              <div class="form-group">
                <label>Price:</label>
                <input type="text" id="editprice" required class="form-control" name="price" placeholder="Price..."/>
              </div>
              <div class="form-group">
                <label>Quantity:</label>
                <input type="number" id="editqty" required class="form-control" name="qty" placeholder="Quantity..."/>

              </div>
              <div class="form-group">
                <label>Expiry Date:</label>
                <input type="date" id="editexpiry" required class="form-control" name="expiry" placeholder="Expiry Date..."/>
              </div>
              <input type="submit" class="btn btn-lg btn-success" value="Update">

            </form>
          </div>
        <!--   <div class="col-sm-7">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#raw" role="tab" aria-controls="home" aria-selected="true">Raw Materials</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="profile" aria-selected="false">Expenses</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="raw" role="raw" aria-labelledby="home-tab">
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
                      <td style="width: 200px;">
                        <style type="text/css">
                          .chosen-container-single .chosen-single,
                          .chosen-container {
                            width: 200px!important;
                          }
                        </style>
                        <select  id="materialName" class="form-control" >
                          <?php foreach($materials as $idx => $material): ?>
                            <?php if($idx == 0): ?>
                            <option selected>Select</option>
                            <?php endif ?>
                            <option data-price="<?= $material['price'];?>"  data-max="<?= $material['qty'];?>"  data-name="<?= $material['name'];?>" value="<?= $material['id'];?>"><?= $material['name'];?></option>
                          <?php endforeach ?>
                        </select>

                      </td>
                      <td>
                        <input type="text" id="materialSrp" readonly class="form-control" name="price" placeholder="SRP..." required />
                      </td>
                      <td>
                        <input type="number" id="materialQty" class="form-control" name="qty" placeholder="Quantity..." min="1" required/>
                      </td>
                      <td>
                        <button id="addMaterial" class="btn btn-sm btn-primary" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#plus"/></svg></button>
                      </td>
                    </tr>
                  </tfoot> 
                </table>
                <h4 >Total Material Cost/<small>product quantity</small> : P<span id="total">0.00</span></h4>
              </div>
              <div class="tab-pane fade " id="expenses" role="tabpanel" aria-labelledby="home-tab">
                  <table class="table table-hover table-sm" id="expensesTbl">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Cost</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style="width: 200px;">
                          <input type="text" class="form-control" id="expName" placeholder="name">

                        </td>
                        <td>
                          <input type="number" id="expCost" class="form-control" name="cost" placeholder="Cost..." min="1" required/>
                        </td>
                        <td>
                          <input type="date" id="dateProduced" class="form-control" name="date" placeholder="Date..."  required/>
                        </td>
                        <td>
                          <button id="addExpenses" class="btn btn-sm btn-primary" ><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#plus"/></svg></button>
                        </td>
                      </tr>
                    </tfoot> 
                  </table>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/html" id="productTPL">
      <tr class="result [LOWSTOCK]" id="edit[ID]">
          <td class="editname">[BATCH]</td>
          <td class="editname">[NAME]</td>
          <td class="editsrp">[PRICE]</td>
          <td class="editqty"><span class="[EXPIRED]">[REMAINING]</span>/[QUANTITY]</td>
          <td class="editqty">[UNIT]</td>
          <td class="editqty">[DATE_PRODUCED]</td>
          <td class="editqty">[EXPIRY_DATE]</td>
        </tr>
</script>
<script type="text/html" id="mats">
  <tr>
    <td>[NAME]</td>
    <td>[PRICE]</td>
    <td>[QTY]</td>
    <td>
      <button  class="btn btn-sm btn-danger deleteMaterial" data-mid="[MID]" data-id="[ID]" data-price="[PRICE]" data-qty="[QTY]"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></button>
    </td>
  </tr>
</script>
<script type="text/html" id="expensesTpl">
  <tr>
    <td>[NAME]</td>
    <td>[COST]</td>
    <td>[DATE]</td>
    <td>
      <button  class="btn btn-sm btn-danger deleteExpenses"  data-id="[ID]"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></button>
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
  <script src="./node_modules/chosen-js/chosen.jquery.min.js" ></script>
  <script type="text/javascript">
    (function($){
      $(document).ready(function(){
        function __listen(){
          // $(".preloader").addClass("hidden");
          
          $(".deleteMaterial").off().on("click", function(e){
            e.preventDefault();

            var me = $(this);
            var qty = me.data("qty");
            var price = me.data("price");
            var total = $("#total").html();


            $(".preloader").removeClass("hidden");

            $.ajax({
              url : "ajax.php",
              data : { deleteMaterial : true, qty : me.data("qty") ,id : me.data("mid")},
              type : "post",
              dataType : "json",
              success : function(response){
                $(".preloader").addClass("hidden");

                me.parents("tr").remove();

                $("#total").html(parseFloat(total) - (qty*price));
              }
            });

          });

          $(".deleteExpenses").off().on("click", function(e){
            e.preventDefault();

            var me = $(this);

            $(".preloader").removeClass("hidden");

            $.ajax({
              url : "ajax.php",
              data : { deleteExpenses : true, id : me.data("id")},
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
                $(".preloader").addClass("hidden");
                
              }
            });
          });

          $(".edit").off().on("click", function(e){
            e.preventDefault();
            
            var me = $(this);
            var data = me.data();

            $("#editname").attr("value", data.name);
            $("#editqty").val(data.qty);
            $("#editprice").attr("value", data.srp);
            $("#editid").attr("value", data.id);
            $("#addMaterial").data("id", data.id);
            $("#addExpenses").data("id", data.id);
            $("#editexpiry").attr("value", data.expiry);
            $(".msg").addClass("hidden");
            $("#material").find("tbody").html("");
            $("#total").html("");
            $("#expensesTbl tbody").html("");
            
            // //get expenses
            // $.ajax({
            //   url : "ajax.php",
            //   data : { getExpensesById : true, id : data.id},
            //   type : "post",
            //   dataType : 'json',
            //   success : function(response){
            //     console.log(response);
            //     for(var i in response){
            //       var tpl = $("#expensesTpl").html();
            //       tpl = tpl.replace("[NAME]", response[i].name).
            //         replace("[BATCH]", response[i].batchnumber).
            //         replace("[ID]", response[i].id).
            //         replace("[QUANTITY]", response[i].quantity).
            //         replace("[DATE_PRODUCED]", response[i].date_produced).
            //         replace("[EXPIRY_DATE]", response[i].date_expired).
            //         replace("[PRICE]", response[i].price);

            //       $("#expensesTbl tbody").append(tpl);
            //     }

            //     __listen();
            //     $(".preloader").addClass("hidden");

            //   }
            // });
            // //get materials
            // $.ajax({
            //   url : "ajax.php",
            //   data : { getMaterials : true, id : data.id},
            //   type : "post",
            //   dataType : 'json',
            //   success : function(response){
            //     var total = 0;

            //     for(var i in response){
            //       var tpl = $("#mats").html();

            //       tpl = tpl.replace("[NAME]", response[i].name).
            //         replace("[ID]", response[i].id).
            //         replace("[PRICE]", response[i].price).replace("[QTY]", response[i].qty).replace("[QTY]", response[i].qty).replace("[PRICE]", response[i].price).replace("[MID]", response[i].materialid);

            //       total += response[i].price * response[i].qty;

            //       $("#material tbody").append(tpl);
            //     }

            //     __listen();
            //     $("#total").html(total);
            //     $(".preloader").addClass("hidden");

            //   }
            // });
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

        function throttle(){
          setTimeout(function(){
            console.log('test');
          },1000);
        }

        $("#materialName").on("change", function(){
          var me = $(this);

          $("#materialSrp").val(me.find("option:selected").data("price"));
          $("#materialQty").attr("max", me.find("option:selected").data("max"));
          // $("#materialQty").attr("placeholder", me.find("option:selected").data("max"));
          $("#materialQty").val("");
        });

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
              , data : { searchAllProducts : true, txt : txt }
              , type : "post"
              , dataType : "json"
              , success : function(response){
                // productTPL
                console.log(response);
                for(var i in response){
                  console.log(response[i].name);
                  var tpl = $("#productTPL").html();

                  tpl = tpl.replace("[ID]", response[i].id).replace("[ID]", response[i].id).replace("[ID]", response[i].id).
                  replace("[NAME]", response[i].name).
                   replace("[BATCH]", response[i].batchnumber).
                    replace("[ID]", response[i].id).
                    replace("[UNIT]", response[i].unit).
                    replace("[QUANTITY]", response[i].quantity).
                     replace("[EXPIRED]", response[i].isExpired).
                    replace("[REMAINING]", response[i].remaining_qty).
                    replace("[DATE_PRODUCED]", response[i].date_produced).
                    replace("[EXPIRY_DATE]", response[i].date_expired).
                    replace("[PRICE]", response[i].price).
                  replace("[LOWSTOCK]", (response[i].qty <= $("#stock").val()) ? 'lowstock' : '').
                  replace("[NAME]", response[i].name)
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

        $("#materialName").chosen();
        $("#addMaterial").on("click", function(e){
          e.preventDefault();

          var material = $("#materialName option:selected").data();
          var srp = $("#materialSrp").val();
          var qty = $("#materialQty").val();
          var id = $(this).data("id");
          var max = $("#materialQty option:selected").data();

          if(qty == ""){
            alert("Please Input Quantity");
            
          } else if(qty > material.max) {
            alert("Not enough stocks");

          } else {
            $.ajax({
              url : "ajax.php",
              data : { 
                addMaterial : true, 
                materialId : $("#materialName").val(),
                id : id,
                qty : qty
              },
              type : "post",
              dataType : "json",
              success :  function(response){
                if(response.added){
                  var tpl = $("#mats").html();

                  tpl = tpl.replace("[NAME]", material.name).
                    replace("[ID]", response.id).
                    replace("[PRICE]", material.price).replace("[QTY]", qty).replace("[QTY]", qty).replace("[PRICE]", material.price).replace("[MID]", $("#materialName").val());

                  $("#material tbody").append(tpl);
                  var total = $("#total").html();

                  $("#total").html(parseFloat(total) + (qty*material.price));
                  __listen();
                } else {
                  alert("You already added this material to this product.");
                }
                
                $(".preloader").addClass("hidden");
                
              }
            });

          }
      
        });

        $(".advance").on("click", function(e){
          e.preventDefault();

          $(".advance_tr").toggleClass("hidden");
        });

        $(".updateAlert").on("click", function(e){
          e.preventDefault();

          showPreloader();
          $.ajax({
            url : "ajax.php",
            data : {updateStock :true, type :'product', val : $("#stock").val() },
            type : "post",
            dataType : "json",
            success : function(response){
              hidePreloader();
            }
          });
        });

        $("#filter").on("click", function(e){
          e.preventDefault();

          var qty = $("#searchQuantity").val();

          $(".result").remove();
          $(".preloader").removeClass("hidden");

           $.ajax({
              url : "ajax.php"
              , data : { searchProductByQuantity : true, qty : qty }
              , type : "post"
              , dataType : "json"
              , success : function(response){
                // productTPL
                console.log(response);
                for(var i in response){
                  console.log(response[i].name);
                  var tpl = $("#productTPL").html();

                  tpl = tpl.replace("[ID]", response[i].id).replace("[ID]", response[i].id).replace("[ID]", response[i].id).replace("[NAME]", response[i].name).
                  replace("[LOWSTOCK]", (response[i].qty <= $("#stock").val()) ? 'lowstock' : '').
                  replace("[NAME]", response[i].name)
                  .replace("[SRP]", response[i].srp).replace("[SRP]", response[i].srp).replace("[QTY]", response[i].qty).replace("[QTY]", response[i].qty);

                  $("#search").after(tpl);
                }
                
                __listen();
                setTimeout(function(){
                  $(".preloader").addClass("hidden");
                },200);


              }
            });
        });

        $("#addExpenses").on("click", function(e){
          e.preventDefault();

          var name = $("#expName").val();
          var cost = $("#expCost").val();
          var date = $("#dateProduced").val();
          var productId = $(this).data("id");

          $(".preloader").removeClass("hidden");

          $.ajax({
            url : "ajax.php",
            data : { 
              addExpenses : true, 
              name : name,
              date : date,
              id : productId,
              cost : cost
            },
            type : "post",
            dataType : "json",
            success :  function(response){

              if(response.added){
                var tpl = $("#expensesTpl").html();

                tpl = tpl.replace("[NAME]", name).
                  replace("[ID]", response.id).
                  replace("[DATE]", date).
                  replace("[COST]", cost);

                $("#expensesTbl tbody").append(tpl);

                __listen();
              } else {
                alert("You already added this material to this product.");
              }
              
              $(".preloader").addClass("hidden");
              
            }
          });
      
        });


      });

    })(jQuery);

  </script>
</body>
</html>