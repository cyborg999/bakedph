	<div class="accordion" id="accordionExample">
				  <div class="card ">
				    <div class="card-header" id="headingOne">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseProfile" aria-expanded="true" aria-controls="collapseProfile">
				          <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#file-person-fill"/></svg> Profile
				        </button>
				      </h2>
				    </div>

				    <div id="collapseProfile" class="<?= ($active == "user") ? "show" : ""; ?> collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body">
				      	<ul class="list-group list-group-flush">
			      		 <li class="list-group-item">
			      		 	
			      		 	<div class="col-ssm"><svg class="bi" width="50" height="50" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#file-person-fill"/></svg></div>
				        <?= $_SESSION['username'] ?>
				        <br>
				        <small>
				        <a href="profile.php">edit profile</a>
				        <br>
				        <?php
				        $pending = $model->checkIfPayed();
						$expiration = $model->getSubscriptionExpiration();
				        ?>
				        <?php if(isset($_SESSION['trialEnd'])): ?>
					        <i>valid till <?= $_SESSION['trialEnd'];?></i>
					    <?php else: ?>
					    	<?php if(!$_SESSION['verified']): ?>
						        <?php if(!$pending): ?>
						        <a href="activate.php">verify account</a>
						        <?php endif ?>
						    <?php else: ?>
						        <i>valid till <?= $expiration;?></i>
					        <?php endif ?>
				        <?php endif ?>
				        </small>

			      		 </li>
					    
						</ul>
				      	
				      </div>
				    </div>
				  </div>
				    <div class="card ">
				    <div class="card-header" id="headingOne">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
				           <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#bell-fill"/></svg> Notifications
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
				          <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#clipboard-plus"/></svg> Suppliers
				        </button>
				      </h2>
				    </div>

				    <div id="collapseVendor" class="<?= ($active == "vendor") ? "show" : ""; ?> collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body">
				      	<ul class="list-group list-group-flush">
						  <li class="list-group-item">
						  	<a href="vendor.php" class="black">All Supplier <span class="badge badge-primary badge-pill"><?= $model->getVendorCount(); ?></span></a>
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
						  	<a href="materials.php" class="black">Material Inventory <span class="badge badge-primary badge-pill"><?= $model->getMaterialCount(); ?></span></a>
						  </li>
						   <li class="list-group-item">
						  	<?php
          						$materialLow = $model->getAllMaterialInventory(true);
          						$expiredCount = $model->getExpiredMaterials();
						  	?>
						  	<a href="material_low.php" class="black">Low In Stock <span class="badge badge-primary badge-pill"><?= count($materialLow) ?></span></a>
						  </li>
						  <li class="list-group-item">
						  	<?php
          						$materialLow = $model->getAllMaterialInventory(true);
						  	?>
						  	<a href="material_expired.php" class="black">Expired Materials <span class="badge badge-primary badge-pill"><?= count($expiredCount) ?></span></a>
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
						  	<a href="products.php" class="black">Product Inventory <span class="badge badge-primary badge-pill"><?= $model->getProductCount(); ?></span></a>
						  </li>
						  <li class="list-group-item">
						  	<?php
          						$productLow = $model->getAllProducts(true);
						  	?>
						  	<a href="product_low.php" class="black">Low In Stock <span class="badge badge-primary badge-pill"><?= count($productLow) ?></span></a>
						  </li>
						  <li class="list-group-item">
						  	<a href="product_expired.php" class="black">Expired Products <span class="badge badge-primary badge-pill"><?= count($model->getExpiredProducts()) ?></span></a>
						  </li>
						  <li class="list-group-item">
						  	<a href="addproduct.php" class="black">Add New</a>
						  </li>
						</ul>
				      </div>
				    </div>
				  </div>

				 <?php if(!$_SESSION['verified']): ?>
				<div class="card">
				    <div class="card-header" id="headingThreen">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left collapsed inactive" type="button" data-toggle="collapse" data-target="#none" aria-expanded="false" aria-controls="collapseThree">
				         <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#clipboard-data"/></svg>  Sales
				        </button>
				      </h2>
				    </div>
				  </div>
				  <div class="card">
				    <div class="card-header" id="headingThreen">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left collapsed inactive" type="button" data-toggle="collapse" data-target="#none" aria-expanded="false" aria-controls="collapseThree">
				         <svg class="bi" width="18" height="18" fill="currentColor"><use xlink:href="./node_modules/bootstrap-icons/bootstrap-icons.svg#clipboard-data"/></svg>  Reports
				        </button>
				      </h2>
				    </div>
				  </div>
				 <?php else: ?>
				 					  <div class="card">
				    <div class="card-header" id="headingTwo">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left collapsed " type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
				        <button class="btn btn-link btn-block text-left collapsed " type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
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
				 <?php endif ?>

				</div>

			<style type="text/css">
			.sidenav {
				min-height: 100vh;
				background: #1243d2;
			}
			.sidenav svg {
				color: #ececec;
			}
				.card .btn-block {
					color: black;
					color: white;
				}
				.accordion>.card>.card-header {
					background: #1243d2;
					border: none;
				}
				.accordion>.card {
					border: none;
				}
				.card-body {
					background: #1243d2;
				}
				.list-group-flush>.list-group-item {
					background: transparent;
				}
				.list-group-flush {
					background: white;
					border-radius: 10px;
				}
				.list-group-flush>.list-group-item {
					border: none;
					padding: 0 20px;
					font-size: 14px;
				}
				.list-group-flush {
					padding: 20px 0;
				}
				body {
					padding: 0;
				}
				.container,
				.container-fluid {
					padding: 0;
					position: relative;
					overflow: hidden;
					width: 100%;
					margin: 0;
					box-sizing: border-box;
				}
			</style>