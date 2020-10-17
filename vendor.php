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
              <td class="editcontact"><?= $vendor['contact']; ?></td>
              <td class="editaddress"><?= $vendor['address']; ?></td>
              <td>
                <a href="" data-name="<?= $vendor['name']; ?>" data-contact="<?= $vendor['contact']; ?>" data-address="<?= $vendor['address']; ?>" data-id="<?= $vendor['id']; ?>" class="btn btn-sm btn-warning edit"  data-toggle="modal" data-target="#editProductModal" alt="Edit product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg> </a>
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
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Vendor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row  ">
          <div class="col-sm msg hidden"></div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <h5>Vendor Information</h5>
            <form method="post" id="editform">
              <input type="hidden" name="editvendor" id="editid" value="">
              <div class="form-group">
                <label>Vendor Name:
                  <input type="text" id="editname" required class="form-control" name="name" value="" placeholder="Vendor Name..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Contact #:
                  <input type="number" id="editcontact" required class="form-control" name="contact" placeholder="Contact..."/>
                </label>
              </div>
              <div class="form-group">
                <label>Address:
                  <input type="text" id="editaddress" required class="form-control" name="address" placeholder="Address..."/>
                </label>
              </div>
              <input type="submit" class="btn btn-lg btn-success" value="Update">

            </form>
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
          <td class="editcontact">[CONTACT]</td>
          <td class="editaddress">[ADDRESS]</td>
          <td>
            <a href="" data-contact="[CONTACT]" data-address="[ADDRESS]" data-id="[ID]" data-name="[NAME]" class="btn btn-sm btn-warning edit"  data-toggle="modal" data-target="#editProductModal" alt="Edit product"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#pencil"/></svg> </a>
            <a href="" data-id="[ID]"" class="btn btn-sm btn-danger delete" alt="Delete Vendor"><svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#trash"/></svg></a>
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
                var tr = $("#edit"+response.editvendor);

                tr.find(".editname").html(response.name);
                tr.find(".editcontact").html(response.expiry);
                tr.find(".editaddress").html(response.price);

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
            $("#editcontact").attr("value", data.contact);
            $("#editaddress").attr("value", data.address);
            $("#editid").attr("value", data.id);

            $(".msg").addClass("hidden");
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
              , data : { searchVendor : true, txt : txt }
              , type : "post"
              , dataType : "json"
              , success : function(response){
                // productTPL
                for(var i in response){
                  var tpl = $("#productTPL").html();

                  tpl = tpl.replace("[ID]", response[i].id).replace("[ID]", response[i].id).replace("[ID]", response[i].id).replace("[NAME]", response[i].name).replace("[NAME]", response[i].name)
                  .replace("[CONTACT]", response[i].contact).replace("[CONTACT]", response[i].contact).replace("[ADDRESS]", response[i].address).replace("[ADDRESS]", response[i].address);

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