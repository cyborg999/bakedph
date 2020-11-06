	<div class="accordion" id="accordionExample">
				  <div class="card ">
				    <div class="card-header" id="headingOne">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseProfile" aria-expanded="true" aria-controls="collapseProfile">
				          <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#file-person"/></svg> Profile
				        </button>
				      </h2>
				    </div>

				    <div id="collapseProfile" class="<?= ($active == "user") ? "show" : ""; ?> collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body">
				      	<div class="col-sm"><svg class="bi" width="50" height="50" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#file-person-fill"/></svg></div>
				        <?= $_SESSION['username'] ?>
				        <br>
				        <small>
				        <a href="profile.php">edit profile</a>
				        </small>
				      </div>
				    </div>
				  </div>
				    <div class="card hidden">
				    <div class="card-header" id="headingOne">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
				           <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#bell"/></svg> Notifications
				        </button>
				      </h2>
				    </div>

				    <div id="collapseZero" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body">
				        TODO 
				      </div>
				    </div>
				  </div>

				

				<div class="card">
				    <div class="card-header" id="headingOne">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseVendor" aria-expanded="true" aria-controls="collapseVendor">
				          <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#clipboard-plus"/></svg> Vendors
				        </button>
				      </h2>
				    </div>

				    <div id="collapseVendor" class="<?= ($active == "vendor") ? "show" : ""; ?> collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body">
				      	<ul class="list-group list-group-flush">
						  <li class="list-group-item">
						  	<a href="vendor.php" class="black">All Vendors <span class="badge badge-primary badge-pill"><?= $model->getVendorCount(); ?></span></a>
						  </li>
						  <li class="list-group-item">
						  	<a href="addvendor.php" class="black">Add New</a>
						  </li>
						</ul>
				      </div>
				    </div>
				  </div>


		  	  	<div class="card">
				    <div class="card-header" id="headingOne">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseMaterials" aria-expanded="true" aria-controls="collapseMaterials">
				          <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#clipboard-plus"/></svg> Materials
				        </button>
				      </h2>
				    </div>

				    <div id="collapseMaterials" class="<?= ($active == "material") ? "show" : ""; ?> collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body">
				      	<ul class="list-group list-group-flush">
						  <li class="list-group-item">
						  	<a href="materials.php" class="black">All Materials <span class="badge badge-primary badge-pill"><?= $model->getMaterialCount(); ?></span></a>
						  </li>
						  <li class="list-group-item">
						  	<a href="addmaterial.php" class="black">Add Material</a>
						  </li>
						</ul>
				      </div>
				    </div>
				  </div>

				  

			    <div class="card">
				    <div class="card-header" id="headingOne">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#clipboard-plus"/></svg> Products
				        </button>
				      </h2>
				    </div>

				    <div id="collapseOne" class="<?= ($active == "product") ? "show" : ""; ?> collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body">
				      	<ul class="list-group list-group-flush">
						  <li class="list-group-item">
						  	<a href="products.php" class="black">All Products <span class="badge badge-primary badge-pill"><?= $model->getProductCount(); ?></span></a>
						  </li>
						  <li class="list-group-item">
						  	<a href="addproduct.php" class="black">Add New</a>
						  </li>
						</ul>
				      </div>
				    </div>
				  </div>

				  <div class="card">
				    <div class="card-header" id="headingTwo">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				          <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#receipt"/></svg> Sales
				        </button>
				      </h2>
				    </div>
				    <div id="collapseTwo" class="<?= ($active == "sales") ? "show" : ""; ?> collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
				      <div class="card-body">
				      	<ul class="list-group list-group-flush">
				         <li class="list-group-item">
						  	<a href="production.php" class="black">Production</a>
						  </li>
						   <li class="list-group-item">
						  	<a href="addsale.php" class="black">Sales</a>
						  </li>
						     <li class="list-group-item">
						  	<a href="addpurchase.php" class="black">Purchase Order</a>
						  </li>
						</ul>
				      </div>
				    </div>
				  </div>
				  <div class="card">
				    <div class="card-header" id="headingThree">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				         <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#clipboard-data"/></svg>  Reports
				        </button>
				      </h2>
				    </div>
				    <div id="collapseThree" class="<?= ($active == "reports") ? "show" : ""; ?>  collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
				      <div class="card-body">
				      	<ul class="list-group list-group-flush">
			      		 <li class="list-group-item"><a href="monthly_production.php" class="black">Production</a> </li>
			      		  <li class="list-group-item"><a href="monthly_sales.php" class="black">Sales</a> </li>
					     <li class="list-group-item"><a href="production_report.php" class="black">Purchase Order</a> </li>
					    
						</ul>
				      </div>
				    </div>
				  </div>
				</div>