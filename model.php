<?php
session_start();

class Model {
	public $db;
	public $errors = array();
	public $success;

	public function __construct(){
		require_once "config.php";

		$this->db = $db;

		$this->signUpListener();
		$this->loginListener();
		$this->addStoreListener();
		$this->addSubscriptionListener();
		$this->getAllUnverifiedStores();
		$this->addProductListener();
		$this->deleteProductListener();
		$this->editproductListener();
		$this->editProductInventoryListener();
		$this->addMaterialListener();
		$this->getMaterialsListener();
		$this->deleteMaterialListener();
		$this->updateUserInfoListener();
		$this->uploadProfileListener();
		$this->searchProductListener();
		$this->addVendorListener();
		$this->deleteVendorListener();
		$this->editvendorListener();
		$this->searchVendorListener();
		$this->addProductionListener();
		$this->deleteProductionListener();
		$this->addSaleListener();
		$this->deleteSaleListener();
		$this->addPurchaseListener();
		$this->deletePurchaseListener();
		$this->addMaterialInventoryListener();
		$this->deleteMaterialInventoryListener();
		$this->editMaterialListener();
		$this->searchMaterialListener();
		$this->updatePurchaseTypeListener();
		$this->filterPurchaseListener();
		$this->exportPurchaseReportListener();
		$this->getMonthlyProductionReport();
		$this->getMonthlyProductionReportByYear();
		$this->getMonthlySalesReportListener();
		$this->loadMonthlyDataListener();
		$this->loadLineChartListener();
		$this->resetPasswordListener();
		$this->verifyUserListener();
		$this->dropZoneTest();
		$this->addSliderListener();
		$this->deleteSlideListener();
		$this->updateSliderStatus();
		$this->addLogoListener();
		$this->addPlanListener();
		$this->deletePlanListener();
		$this->activatePlanListener();
		$this->filterSaleListener();
		$this->filterProductionListener();
		$this->addExpensesListener();
		$this->deleteExpensesListener();
		$this->getAllExpensesListener();
		$this->seachProductByQuantityListener();
		$this->searchmaterialByQuantityListener();
		$this->updateStockListener();
		$this->searchProductLowListener();
		$this->exportListener();
		$this->filterExpensesListener();
		$this->updateTermsListener();
		$this->addPersonalListener();
		$this->searchExpiredProductsListener();
		$this->searchExpiredMaterialsListener();
		$this->addStoreExpensesListener();
		$this->addSalesReturnListener();
		$this->addPurchaseReturnListener();
		$this->updateSeenListener();
		$this->editAllmaterialsListener();
		$this->searchAllMaterialsListener();
		$this->searchAllProductsListener();
		$this->addSocialListener();
		$this->removeSocialListener();
		$this->viewUserListener();
		$this->updateBusinessListener();
		$this->loadUserChartListener();
		$this->loadSalesVsProductionListener();
		$this->expiredChecker();
		$this->addNewProductListener();
	}

	public function addNewProductListener(){
		if(isset($_POST['addNewProduct'])){
			$sql = "
				SELECT *
				FROM product
				WHERE name = '".$_POST['name']."'  AND storeid = '".$_SESSION['storeid']."'
				LIMIT 1
			";

			$exists = $this->db->query($sql)->fetch();
	
			if(!$exists){
				$sql = "
					INSERT INTO product(name,storeid)
					VALUES(?,?)
				";

				$this->db->prepare($sql)->execute(array($_POST['name'], $_SESSION['storeid']));

				$productId = $this->db->lastInsertId();

				if(isset($_POST['data'])){
					foreach($_POST['data'] as $idx => $d){
						$sql = "
							INSERT INTO material(materialId,qty,productid,unit)
							VALUES(?,?,?,?)
						";	

						$this->db->prepare($sql)->execute(array($d['id'],  $d['qty'], $productId, $d['unit']));
					}
				}
				
				

				// $data['added'] = true;
				// $data['id'] = $this->db->lastInsertId();

				$this->success = "You have sucesfully added this product.";

			} else {
				$this->errors[] = "You already have this product added before.";
			}

			die(json_encode(array("errors"=> $this->errors, "success" => $this->success)));
		}
	}

	public function loadUserChartListener(){
		if(isset($_POST['loadUserChart'])){
			$users = $this->getAllUsers();

			$this->loadAdminChart($users);
		}
	}

	public function loadAdminChart($records){
		$months = array(
			"Jan" => 0,
			"Feb" => 0,
			"Mar" => 0,
			"Apr" => 0,
			"May" => 0,
			"Jun" => 0,
			"Jul" => 0,
			"Aug" => 0,
			"Sep" => 0,
			"Oct" => 0,
			"Nov" => 0,
			"Dec" => 0
		);

		$data = array();
		$producedDate = date("Y-m-d");

		foreach($records as $idx => $r){
			$m = date_format($producedDate, "M");
			$y = date_format($producedDate, "Y");

			$data[$r['productid']]['name'] = $r['name'];
			@$data[$r['productid']][$m]['total'] += ($key) ? $r['qty'] : $r['quantity'];
		}

		// opd($data);
		$formatted = array();

		$counter = 0;

		foreach($data as $idx => $d){
			$formatted[$counter]['name'] = $d['name'];
			$formatted[$counter]['data'] = $months;

			foreach($months as $iidx => $m){
				if(array_key_exists($iidx, $d)){
					$formatted[$counter]['data'][$iidx] = $d[$iidx]['total'];
				}

			}

			$formatted[$counter]['data'] = array_values($formatted[$counter]['data']);

			$counter++;

		}

		die(json_encode($formatted));
	}

	public function updateBusinessListener(){
		if(isset($_POST['updateBusiness'])){
			$sql = "
				update store 
				set description = ?, b_address = ?, dti = ? , 
					b_email = ?, b_contact = ?
				where id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['description'], $_POST['b_address'], $_POST['dti'], $_POST['b_email'], $_POST['b_contact'], $_SESSION['storeid']));

			$this->success = "You have successfully updated this record";

			return $this;
		}
	}

	public function viewUserListener(){
		if(isset($_POST['viewUser'])){
			$sql = "
				select t1.*,t3.name as 'store', t3.b_email as 'storeemail', t3.b_contact as 'storecontact'
				from userinfo t1
				left join user t2
				on t1.userid = t2.id
				left join store t3
				on t1.userid = t3.userid
				where t1.userid = ".$_POST['id']."
				limit 1
			";

			$record = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

			die(json_encode($record));
		}
	}

	public function getAllSocialMedia(){
		$sql = "
			select *
			from social
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllSocial(){
		$sql = "
			select *
			from social
			where userid = ".$_SESSION['id']."
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function removeSocialListener(){
		if(isset($_POST['removeSocial'])){
    		$sql = "
    			delete from social
    			where id = ?
    		";

    		$this->db->prepare($sql)->execute(array($_POST['id']));

    		die(json_encode("deleted"));

		}
	}

	public function addSocialListener(){
		if(isset($_POST['addSocial'])){
    		$sql = "
    			insert into social(social,link,userid)
    			values(?,?,?)
    		";
    		$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['link'], $_SESSION['id']));

    		die(json_encode(array("id" => $this->db->lastInsertId())));
		}
	}

	public function updateSeenListener(){
		if(isset($_POST['updateSeen'])){
			$sql = "
				update notification
				set seen = 1
				where id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("updated")));
		}
	}

	public function getUnreadNotifications(){
		$sql = "
			select *
			from notification
			where storeid = ".$_SESSION['storeid']."
			and seen = 0
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getNotifications(){
		$sql = "
			select *
			from notification
			where storeid = ".$_SESSION['storeid']."
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function addNotification($title, $body){
		$sql = "
			insert into notification(title,body,storeid)
			values(?,?,?)
		";

		$this->db->prepare($sql)->execute(array($title, $body, $_SESSION['storeid']));


		return $this;
	}

	public function deductExpiredProduct($products){
		$data = array();

		foreach($products as $idx => $p){
			if($p['deducted'] == 0){
				//update deducted
				$sql = "
					update production
					set deducted = ?
					where id = ?
				";

				$this->db->prepare($sql)->execute(array(1, $p['id']));

				//deduct expired qty to inventory
				$this->updateProductInventory($p['productid'], $p['remaining_qty']);
			}
		}

		return $this;
	}

	public function deductExpiredMaterials($materials){
		$data = array();

		foreach($materials as $idx => $p){
			if($p['deducted'] == 0){
				//update deducted
				$sql = "
					update purchase
					set deducted = ?
					where id = ?
				";

				$this->db->prepare($sql)->execute(array(1, $p['id']));

				//deduct expired qty to inventory
				$this->updateMaterialInventory($p['materialid'], $p['remaining_qty']);
			}
		}

		return $this;
	}

	public function getLowStockProductNotification(&$notifications){
		$lowStockProducts = array();
		$products = $this->getAllProducts(true);
		$title = '<div class="mr-3">
                      <div class="icon-circle bg-warning">
                          <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                  </div>
                  <div>';


		if(count($products)){
			$title .= "Low Stock Alert: <b>".count($products) ." Product(s)</b> are currently low in stock.";
		}

		$title .=  '<!-- <div class="small text-gray-500">December 2, 2019</div> -->
              	</div>';

        $body = "<b>The following products are low in stock:</b> <ul>";

        foreach($products as $idx => $p){
        	$body .= "<li>".$p['name']."(".$p['qty'].")</li>";
        }

        $body .= "</ul>";

		if(count($products)){
			$notifications[] = $title;

			$this->addNotification($title, $body);
        }

		return $this;
	}

	public function getLowStockMaterialNotification(&$notifications){
		$lowStockProducts = array();
      	$products = $this->getAllMaterialInventory(true);
      	$title = '<div class="mr-3">
                      <div class="icon-circle bg-warning">
                          <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                  </div>
                  <div>';
                    
		if(count($products)){
			$title .= "Low Stock Alert: <b>".count($products) ." Material(s)</b> are currently low in stock.";
		}

		$title .=  '<!-- <div class="small text-gray-500">December 2, 2019</div> -->
              	</div>';

       $body = "<b>The following materials are low in stock:</b> <ul>";

        foreach($products as $idx => $p){
        	$body .= "<li>".$p['name']."(".$p['qty'].")</li>";
        }

        $body .= "</ul>";

		if(count($products)){
			$notifications[] = $title;

			$this->addNotification($title, $body);
        }

		return $this;
	}

	public function expiredChecker(){
		if(isset($_SESSION['storeid'])){
			$materials = $this->getExpiredMaterials();
			$products = $this->getExpiredProducts();

	        $this->deductExpiredProduct($products);
	        $this->deductExpiredMaterials($materials);

	        return $this;
		}
	}

	public function getExpiredMaterialNotification(&$notifications){
		$lowStockProducts = array();
      	$products = $this->getExpiredMaterials();
      	$title = '<div class="mr-3">
                      <div class="icon-circle bg-danger">
                          <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                  </div>
                  <div>';

        $this->deductExpiredMaterials($products);

		if(count($products)){
			$title .= "Expired Item Alert: <b>".count($products) ." Material(s)</b> are expired.";
		}

		$title .=  '<!-- <div class="small text-gray-500">December 2, 2019</div> -->
              	</div>';

        $body = "<b>The following materials are expired:</b> <ul>";

        foreach($products as $idx => $p){
        	$body .= "<li>".$p['name']."(".$p['expiry_date'].")</li>";
        }

        $body .= "</ul>";

		if(count($products)){
			$notifications[] = $title;

			$this->addNotification($title, $body);
        }

		return $this;
	}

	public function getExpiredProductNotification(&$notifications){
		$lowStockProducts = array();
      	$products = $this->getExpiredProducts();
      	$title = '<div class="mr-3">
                      <div class="icon-circle bg-danger">
                          <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                  </div>
                  <div>';
               //auto deduct expired products
        $this->deductExpiredProduct($products);

		if(count($products)){
			$title .= "Expired Item Alert: <b>".count($products) ." Product(s)</b> are expired.";
		}

		$title .=  '<!-- <div class="small text-gray-500">December 2, 2019</div> -->
              	</div>';

		$body = "<b>The following products are expired:</b> <ul>";

        foreach($products as $idx => $p){
        	$body .= "<li>".$p['name']."(".$p['date_expired'].")</li>";
        }

        $body .= "</ul>";

		if(count($products)){
			$notifications[] = $title;

			$this->addNotification($title, $body);
        }

		return $this;
	}

	public function checkSubscriptionDueDate(&$notifications){
		$expiration = $this->getSubscriptionExpiration();
		$date1 = date_create(date("Y-m-d"));
		$date2 = date_create($expiration);
		$diff = date_diff($date1,$date2);

		if($diff->days <= 10){
			$title = '<div class="mr-3">
                      <div class="icon-circle bg-warning">
                          <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                  </div>
                  <div>';

			$title .= "Subscription Alert: Your subscription will expire in <b>". $diff->days ." day(s)</b>.";

			$title .=  '<!-- <div class="small text-gray-500">December 2, 2019</div> -->
			  	</div>';

			$body = "<p>Your subscription will expire in".$dif->days." (".$expiration.")</p>";
			
			$this->addNotification($title, $body);

		  	$notifications[] = $title;
		}

		return $this;
	}

	public function getStoreCreditDeadlineNotifications(&$notifications){
		$purchaseOrders = $this->getPurchaseOrdersByType("credit");
		$total = 0;
		$body = "<b>The following Purchase Order's credit deadline are near:</b> <ul>";

		foreach($purchaseOrders as $idx => $p){
			$date1 = date_create(date("Y-m-d"));
			$date2 = date_create("2021-01-09");
			$date2 = date_create($p['credit_date']);
			$diff = date_diff($date1,$date2);

			if($diff->days <= 10){
        		$body .= "<li>".$p['materialname']."(".$p['credit_date'].")</li>";
				
				++$total;
			}
		}
        $body .= "</ul>";


		if($total){
			$title = '<div class="mr-3">
                      <div class="icon-circle bg-warning">
                          <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                  </div>
                  <div>';

			$title .= "Credit Payment Alert: <b>$total</b> Credit Payment(s) are near.";

			$title .=  '<!-- <div class="small text-gray-500">December 2, 2019</div> -->
			  	</div>';

			$this->addNotification($title, $body);

		  	$notifications[] = $title;
		}

		return $this;
	}

	public function getStoreNotifications(){
		//sa login, sa procure or sell
		$notifications = array();

		$this->getStoreCreditDeadlineNotifications($notifications);
		$this->checkSubscriptionDueDate($notifications);
		$this->getLowStockProductNotification($notifications);
		$this->getLowStockMaterialNotification($notifications);
		$this->getExpiredMaterialNotification($notifications);
		$this->getExpiredProductNotification($notifications);

		return $this;
	}

	public function addPurchaseReturnListener(){
		if(isset($_POST['addPurchaseReturn'])){
			foreach($_POST['data'] as $idx => $r){
				$sql = "
					insert into purchase_return(materialid,amount,date_purchased,qty,unit)
					values(?,?,?,?,?)
				";

				$this->db->prepare($sql)->execute(array($r[0],$r[2], $r[5],$r[3],$r[4]));
			}

			die(json_encode(array("added")));
		}
	}

	public function addSalesReturnListener(){
		if(isset($_POST['addSalesReturn'])){
			foreach($_POST['data'] as $idx => $r){
				$sql = "
					insert into sales_return(productid,amount,date_purchased,qty,unit)
					values(?,?,?,?,?)
				";

				$this->db->prepare($sql)->execute(array($r[0],$r[2], $r[5],$r[3],$r[4]));
			}

			die(json_encode(array("added")));
		}
	}

	public function updateTermsListener(){
		if(isset($_POST['updateTerms'])){
			if($_POST['updateTerms'] == "terms"){
				$sql = "
					update settings
					set terms = ?
					where userid = ? 
				";
				
				$this->db->prepare($sql)->execute(array($_POST['terms'], $_SESSION['id']));
			} elseif(isset($_POST['about'])) {
				$sql = "
					update settings
					set about = ?
					where userid = ? 
				";
				$this->db->prepare($sql)->execute(array($_POST['about'], $_SESSION['id']));
			} elseif(isset($_POST['overview'])) {
				$sql = "
					update settings
					set overview = ?
					where userid = ? 
				";
				$this->db->prepare($sql)->execute(array($_POST['overview'], $_SESSION['id']));
			} elseif(isset($_POST['contact'])) {
				$sql = "
					update settings
					set contact = ?
					where userid = ? 
				";
				$this->db->prepare($sql)->execute(array($_POST['contact'], $_SESSION['id']));
			} else {
				$sql = "
					update settings
					set privacy = ?
					where userid = ? 
				";
				$this->db->prepare($sql)->execute(array($_POST['privacy'], $_SESSION['id']));
			}

			$this->success = "You have succesfully update this record";

			return $this;
		}
	}

	public function getNextBatch(){
		$sql = "
			select id
			from production
			where storeid = ".$_SESSION['storeid']."
			order by id desc
			limit 1
		";

		$record = $this->db->query($sql)->fetch();

		return ($record) ? "Batch #" . ++$record['id'] : "Batch #1";
	}
	
	public function exportListener(){
		if(isset($_GET['export'])){
			if(isset($_GET['allmaterials'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=AllMaterials.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array("Name", "Price", "Quantity", "Unit", "Date Purchased", "Expiry Date"));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['price'],$r['qty'],$r['unit'], $r['date_purchased'],$r['expiry_date']);

					fputcsv($output, $data);
				}
			}
			if(isset($_GET['allproducts'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=AllProducts.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Batch #', 'Product Name', 'Price', "Quantity", "Date Produced", "Expiry Date"));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['batchnumber'],$r['name'],$r['price'],$r['quantity'], $r['date_produced'],$r['date_expired']);

					fputcsv($output, $data);
				}
			}
			if(isset($_GET['productexpired'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=ExpiredProducts.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Batch #', 'Product Name', 'Price', "Quantity", "Date Produced", "Expiry Date"));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['batchnumber'],$r['name'],$r['price'],$r['quantity'], $r['date_produced'],$r['date_expired']);

					fputcsv($output, $data);
				}
			}

			if(isset($_GET['sales'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=Sales.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array("Name", "Quantity", 'Price', "Unit", "Amount", "Date Purchased"));

				$records = $this->db->query($_SESSION['monthlySalesQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['qty'],$r['srp'],$r['unit'], $r['revenue'], $r['date_purchased']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['salesMonthly'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=Sales.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array("Name", "Quantity", 'Price', "Unit", "Amount", "Date Purchased"));
				
				$records = $this->db->query($_SESSION['lastSaleQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['qty'],$r['srp'],$r['unit'], $r['revenue'], $r['date_purchased']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['expenses'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=Expenses.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array("Description", "Cost", 'Date Produced'));

				$records = $this->db->query($_SESSION['lastExpensesQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['cost'], $r['date_produced']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['materialExpired'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=ExpiredMaterials.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Name', 'Price', 'Quantity', "Unit", "Date Purchased", "Expiry Date"));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['price'],$r['qty'],$r['unit'], $r['date_purchased'],$r['expiry_date']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['production'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=ProductionRecord.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Name', 'Batch #', 'SRP', "Quantity", "Unit", "Amount"));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['batchnumber'],$r['srp'],$r['quantity'], $r['unit'], $r['quantity'] * $r['srp']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['materialLow'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=Low_Stock_Materials.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Name', 'Price', 'Quantity', "Expiry Date"));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['price'],$r['qty'],$r['expiry_date']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['materials'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=MaterialInventory.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Name', 'Quantity', "Unit"));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['qty'],$r['unit']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['productLow'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=Low_Stock_Products.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Name', 'SRP', 'Quantity', 'Expiry Date'));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['price'],$r['qty'],$r['expiry_date']);
					fputcsv($output, $data);
				}
			}

			if(isset($_GET['products'])){
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=Products.csv');

				$output = fopen('php://output', 'w');


				fputcsv($output, array('Name', 'SRP', 'Quantity', 'Expiry Date'));

				$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();

				foreach($records as $idx => $r){
					$data = array($r['name'],$r['price'],$r['qty'],$r['expiry_date']);
					fputcsv($output, $data);
				}
			}
		}
	}

	public function updateStockListener(){
		if(isset($_POST['updateStock'])){
			$sql = "
				update store
				set material_low = ?
				where userid = ?
			";

			if($_POST['type'] == "product"){
				$sql = "
					update store
					set product_low = ?
					where userid = ?
				";
			}

			$this->db->prepare($sql)->execute(array($_POST['val'], $_SESSION['id']));

			die(json_encode(array("added")));
		}
	}

	public function searchAllMaterialsListener(){
		if(isset($_POST['searchAllMaterial'])) {
			$sql = "
				select t1.*,t2.name, t3.name as 'vendorname', t3.id as 'vendorid',if((date(CURRENT_DATE) >= date(t1.expiry_date)), 'expired' , '') as 'isExpired'
				from purchase t1
				left join material_inventory t2
				on t1.materialid = t2.id
				left join vendor t3
				on t1.vendorid = t3.id
				WHERE t1.storeid = ".$_SESSION['storeid']."
				AND  t2.name LIKE '%".$_POST['txt']."%'
				AND t1.storeid = '".$_SESSION['storeid']."'
				LIMIT 20
			";

			$_SESSION['lastQuery'] = $sql;

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function searchmaterialByQuantityListener(){
		if(isset($_POST['searchmaterialByQuantity'])) {

			$sql = "
				SELECT *
				FROM material_inventory 
				WHERE storeid = '".$_SESSION['storeid']."'
				AND qty <= ".$_POST['quantity']."
			";

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function seachProductByQuantityListener(){
		if(isset($_POST['searchProductByQuantity'])) {
			$sql = "
				SELECT *
				FROM product
				WHERE qty <= ".$_POST['qty']."
				AND storeid = '".$_SESSION['storeid']."'
			";

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function filterExpensesListener(){
		if(isset($_POST['filterExpenses'])){
			if($_POST['filter'] == "day"){
				$where = ($_POST['date1'] == "")  ? "" : " AND  t1.date_produced = '".$_POST['date1']."'";
				$sql = "
					SELECT t1.* 
					FROM expenses t1
					where t1.storeid = ".$_SESSION['storeid']."
					$where 
				";
			} elseif($_POST['filter'] == "daterange"){
				$where = ($_POST['date2'] == "")  ? "" : " AND t1.date_produced BETWEEN '".$_POST['date2']."' AND '".$_POST['date3']."'";
				$sql = "
					SELECT t1.* 
					FROM expenses t1
					where t1.storeid = ".$_SESSION['storeid']."
					$where
					 
				";
			} else {
				//year
				$where = ($_POST['year'] == "")  ? "" : " AND YEAR(t1.date_produced) = '".$_POST['year']."' ";
				$sql = "
					SELECT t1.* 
					FROM expenses t1
					where t1.storeid = ".$_SESSION['storeid']."
					$where
					 
				";
			}

			$_SESSION['lastExpensesQuery'] = $sql;

			$records = $this->db->query($sql)->fetchAll();

			die(json_encode($records));
		}
	}

	function getExpensesTotal(){
		if(isset($_POST['filter'])){
			if($_POST['filter'] == "day"){
				$where = ($_POST['date1'] == "")  ? "" : " AND  t1.date_produced = '".$_POST['date1']."'";
				$sql = "
					SELECT sum(t1.cost) as 'total'
					FROM expenses t1
					where t1.storeid = ".$_SESSION['storeid']."
					$where 
				";
			} elseif($_POST['filter'] == "daterange"){
				$where = ($_POST['date2'] == "")  ? "" : " AND t1.date_produced BETWEEN '".$_POST['date2']."' AND '".$_POST['date3']."'";
				$sql = "
					SELECT sum(t1.cost) as 'total'
					FROM expenses t1
					where t1.storeid = ".$_SESSION['storeid']."
					$where
					 
				";
			} else {
				//year
				$where = ($_POST['year'] == "")  ? "" : " AND YEAR(t1.date_produced) = '".$_POST['year']."' ";
				$sql = "
					SELECT sum(t1.cost) as 'total'
					FROM expenses t1
					where t1.storeid = ".$_SESSION['storeid']."
					$where
					 
				";
			}
		} else {
			$sql = "
				SELECT sum(t1.cost) as 'total'
				FROM expenses t1
				WHERE t1.storeid = ".$_SESSION['storeid']."
			";
		}

		return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
	}

	public function getStoreExpenses(){
		$sql = "
			SELECT t1.*
			FROM expenses t1
			WHERE t1.storeid = ".$_SESSION['storeid']."
		";
		
	
		$_SESSION['lastExpensesQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllExpenses($recordQuery = false){
		$sql = "
			SELECT t1.*
			FROM expenses t1
			LEFT JOIN product t2
			ON t1.productid = t2.id
			WHERE t2.storeid = ".$_SESSION['storeid']."
		";
		
	
		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllExpensesListener(){
		if(isset($_POST['getExpensesById'])){
			$sql = "
				SELECT *
				FROM expenses
				WHERE productid = ".$_POST['id']."
			";

			$record = $this->db->query($sql)->fetchAll();

			die(json_encode($record));
		}

	}

	public function deleteExpensesListener(){
		if(isset($_POST['deleteExpenses'])){
			$sql = "
				DELETE 
				FROM expenses
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("deleted")));
		}
	}

	public function getStoreSalesReturn(){
		$sql = "
			select t1.*,t2.name
			from sales t1
			left join product t2
			on t1.productid = t2.id
			where t1.storeid = ".$_SESSION['storeid']."
			group by t1.productid
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getStorePurchaseReturn(){
		$sql = "
			select t1.*,t2.name
			from purchase t1
			left join material_inventory t2
			on t1.materialid = t2.id
			where t1.storeid = ".$_SESSION['storeid']."
			group by t1.materialid
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function addStoreExpensesListener(){
		if(isset($_POST['addStoreExpenses'])){
			foreach($_POST['data'] as $idx => $d){
				$sql = "
					insert into expenses(name,cost,storeid,date_produced)
					values(?,?,?,?)
				";

				$this->db->prepare($sql)->execute(array($d[0], $d[1], $_SESSION['storeid'], $d[2]));
			}

			die(json_encode(array("added")));
		}
	}

	public function addExpensesListener(){
		if(isset($_POST['addExpenses'])){
			$data = array();

			if($this->findExpensesByProductIdandName($_POST['name'], $_POST['id'])){

				$data['added'] = false;
			} else {
				$sql = "
					INSERT INTO expenses(name,cost,productid,storeid,date_produced)
					VALUES(?,?,?,?,?)
				";	

				$this->db->prepare($sql)->execute(array($_POST['name'],  $_POST['cost'], $_POST['id'], $_SESSION['storeid'], $_POST['date']));

				$data['added'] = true;
				$data['id'] = $this->db->lastInsertId();
			}

			die(json_encode($data));
		}
	}

	public function findExpensesByProductIdandName($name, $id){
		$sql = "
			SELECT *
			FROM expenses
			WHERE id = ".$id."
			AND name = '".$name."'
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function filterProductionListener(){
		if(isset($_POST['filterProduction'])){
			if($_POST['filter'] == "day"){
				$sql = "
					SELECT t1.* , t2.name, t2.srp
					FROM production t1
					LEFT JOIN  product t2 
					ON t1.productid = t2.id
					WHERE t1.date_produced = '".$_POST['date1']."'
					AND t1.storeid = ".$_SESSION['storeid']."
				";
			} elseif($_POST['filter'] == "daterange"){
				$sql = "
					SELECT t1.* , t2.name, t2.srp
					FROM production t1
					LEFT JOIN  product t2 
					ON t1.productid = t2.id
					WHERE t1.date_produced BETWEEN '".$_POST['date2']."' AND '".$_POST['date3']."'
					AND t1.storeid = ".$_SESSION['storeid']."
				";
			} else {
				//year
				$and = ($_POST['year'] =="") ? "" : " AND YEAR(t1.date_produced) = '".$_POST['year']."'";
				$sql = "
					SELECT t1.* , t2.name, t2.srp
					FROM production t1
					LEFT JOIN  product t2 
					ON t1.productid = t2.id
					 
					WHERE t1.storeid = ".$_SESSION['storeid']."
					$and
				";
			}

			$_SESSION['lastQuery'] = $sql;

			$records = $this->db->query($sql)->fetchAll();

			die(json_encode($records));
		}
	}

	public function filterSaleListener(){
		if(isset($_POST['filterSale'])){
			if($_POST['filter'] == "day"){
				$where = ($_POST['date1'] == "")  ? "" : " AND t1.date_purchased = '".$_POST['date1']."'";

				$sql = "
					SELECT t1.*, t3.name ,t2.price as 'srp',t2.price * t1.qty as 'revenue'
					FROM sales t1
					LEFT JOIN production t2
					ON t1.productid = t2.productid
					left join product t3
					on t1.productid = t3.id
					where t1.storeid = ".$_SESSION['storeid']."
					$where
				";
			} elseif($_POST['filter'] == "daterange"){
				$where = ($_POST['date2'] == "")  ? "" : " AND t1.date_purchased BETWEEN '".$_POST['date2']."' AND '".$_POST['date3']."'";
				$sql = "
					SELECT t1.*, t3.name ,t2.price as 'srp',t2.price * t1.qty as 'revenue'
					FROM sales t1
					LEFT JOIN production t2
					ON t1.productid = t2.productid
					left join product t3
					on t1.productid = t3.id
					$where
				";
			} else {
				//year
				$where = ($_POST['year'] == "")  ? "" : " AND YEAR(t1.date_purchased) = '".$_POST['year']."' ";
				$sql = "
					SELECT t1.*, t3.name ,t2.price as 'srp',t2.price * t1.qty as 'revenue'
					FROM sales t1
					LEFT JOIN production t2
					ON t1.productid = t2.productid
					left join product t3
					on t1.productid = t3.id
					where t1.storeid = ".$_SESSION['storeid']."
					$where
				";
			}

			$_SESSION['lastSaleQuery'] = $sql;

			$expenses = $this->getExpensesTotal();
			$records = $this->db->query($sql)->fetchAll();

			die(json_encode(array("record" => $records, "expensesTotal" => $expenses)));
		}
	}

	public function activatePlanListener(){
		if(isset($_POST['activatePlan'])){
			$sql = "
				UPDATE subscription
				SET active = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['toggle'],$_POST['id']));

			die(json_encode(array("Updated")));
		}
	}

	public function deletePlanListener(){
		if(isset($_POST['deletePlan'])){
			$sql = "
				UPDATE subscription
				SET deleted = 1
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("Deleted")));
		}
	}

	public function getActiveSubscriptions(){
		$sql = "
			SELECT *
			FROM subscription
			WHERE deleted = 0
			AND active = 1
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllSubscription(){
		$sql = "
			SELECT *
			FROM subscription
			WHERE deleted = 0
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function addPlanListener(){
		if(isset($_POST['addPlan'])){
			$isTrial = (isset($_POST['isTrial'])) ? 1 : 0;

			$sql = "
				INSERT INTO subscription(duration,cost,title,caption, is_trial)
				VALUES(?,?,?,?,?)
			";

			$this->db->prepare($sql)->execute(array($_POST['planduration'],$_POST['planfee'],$_POST['title'],$_POST['plancaption'],$isTrial));

			header("Location:plan.php");
		}
	}

	public function checkAccess(){
		if(!$_SESSION['verified']){
			header("Location:activate.php");
		}
	}

	public function deleteSlideListener(){
		if(isset($_POST['deleteSlide'])){
			$sql = "
				DELETE FROM slides
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("Deleted")));
		}
	}

	public function updateSliderStatus(){
		if(isset($_POST['updateSlideStatus'])){
			$sql = "
				UPDATE slides
				SET status = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['status'], $_POST['id']));

			die(json_encode(array("updated")));
		}
	}

	public function getAllSlides($news = false){
		$sql = "
			SELECT *
			FROM slides
			WHERE type = '".(($news) ? "news" : "slider")."'
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllSlidesIdx($news = false, $idx = false){
		$sql = "
			SELECT *
			FROM slides
			WHERE type = '".(($news) ? "news" : "slider")."'
		";

		if($idx){
			$sql = "
				SELECT *
				FROM slides
				WHERE type = '".(($news) ? "news" : "slider")."'
				AND status = 1
		";

		}

		return $this->db->query($sql)->fetchAll();
	}

	public function addSliderListener(){
		if(isset($_POST['addSlider'])){
			$sql = "
				INSERT INTO slides(title,content,photo,type)
				VALUES(?,?,?,?)
			";

			$type = (isset($_POST['addNews'])) ? "news" : "slider";

			$this->db->prepare($sql)->execute(array($_POST['title'],$_POST['subtext'],$_POST['photo'], $type));

			die(json_encode(array("added")));
		}
	}

	public function getAdminAssets($type = false){
		$assets = array();
		$folder_name = 'uploads/admin/';
		$files = scandir('uploads/admin/');

		if($type == "logo"){
			$folder_name = 'uploads/logo/';
			$files = scandir('uploads/logo/');
		}

		if(false !== $files) {
		 foreach($files as $file) {
		  if('.' !=  $file && '..' != $file) {
		  	$assets[] = $folder_name.$file;
		  }
		 }
		}

		return $assets;
	}

	public function getLogo(){
		$sql = "
			SELECT logo
			FROM settings
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function getAdminSetting($public=false){
		$where = ($public) ? "" : "where userid = ".$_SESSION['id'];
		$sql = "
			SELECT *
			FROM settings
			$where
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function addLogoListener(){
		if(isset($_POST['addLogo'])){
			$sql = "
				SELECT *
				FROM settings
				WHERE userid = '".$_SESSION['id']."'
				LIMIT 1
			";
			$exists = $this->db->query($sql)->fetch();

			if($exists){
				//update
				$sql = "
					UPDATE settings
					SET logo = ?
					WHERE userid = ?
				";
			} else {
				//insert
				$sql = "
					INSERT INTO settings(logo,userid)
					VALUES(?,?)
				";
			}

			$this->db->prepare($sql)->execute(array($_POST['photo'], $_SESSION['id']));

			die(json_encode(array("added")));
		}
	}

	public function dropZoneTest(){

		if(isset($_POST['assetupload'])){
			if(isset($_FILES)){
				$folder_name = 'uploads/admin/';

				if(isset($_POST['logo'])){
					$folder_name = 'uploads/logo/';
				}
				if(!empty($_FILES)) {
				 $temp_file = $_FILES['file']['tmp_name'];
				 $ext = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
				 $location = $folder_name . $_FILES['file']['name'];

				 if(move_uploaded_file($temp_file, $location)){
				 	$_SESSION['lastUpload'] = $_FILES['file']['name'];
				 }
				}
			}
		}
	}

	public function verifyUserListener(){
		if(isset($_POST['verifyUser'])){
			$sql = "
				UPDATE user
				SET verified = ?
				WHERE id = ?
			";
			$verified = !$_POST['verify'];
			$this->db->prepare($sql)->execute(array($verified, $_POST['id']));

			die(json_encode(array("updted")));
		}
	}
	
	public function getAllUsers(){
		$sql = "
			SELECT t1.*,t2.email, t2.contact
			FROM user t1
			LEFT JOIN userinfo t2
			ON t1.id = t2.userid
			WHERE t1.usertype = 'basic'
		";	

		return $this->db->query($sql)->fetchAll();
	}

	public function resetPasswordListener(){
		if (isset($_POST['resetpassword'])) {
			$this->checkPassword();
			
			$profile = $this->getUserById($_SESSION['id']);

			if($profile['password'] != md5($_POST['oldpassword'])){
				$this->errors[] = "Incorrect Old Password";
			}

			if(count($this->errors) == 0){
				$sql = "
					UPDATE user
					SET password = ?
					WHERE id = ?
				";

				$this->db->prepare($sql)->execute(array(md5($_POST['password']), $_SESSION['id']));

				$this->success = "You have succesfully updated your password";
			}

			return $this;
		}
	}	

	public function loadLineChartListener(){
		if(isset($_POST['loadLineChart'])){
			$sales = $this->getAllSales();

			$this->loadChart($sales, "date_purchased");
		}
	}

	public function loadMonthlyDataListener(){
		if(isset($_POST['loadMonthlyData'])){
			$records = $this->getAllProductionByYearAndMonth();

			$this->loadPieChart($records);
		}
	}

	public function loadPieChart($records, $key = false){
		$data = array();

		foreach($records as $idx => $r){
			$producedDate = ($key) ? date_create($r[$key]) : date_create($r['date_produced']);
			$m = date_format($producedDate, "M");
			$y = date_format($producedDate, "Y");

			$data[$r['productid']]['name'] = $r['name'];
			@$data[$r['productid']]['total'] += ($key) ? $r['qty'] : $r['quantity'];
		}


		$formatted = array();

		foreach($data as $idx => $d){
			$formatted[] = array($d['name'], $d['total']);
		}
   // series: [{
   //      type: 'pie',
   //      name: 'Quantity',
   //      data: [
   //          ['Cheese Cake', 45.0],
   //          ['Fudgee Bar', 26.8]
   //      ]
   //  }]

		die(json_encode(array_values($formatted)));
	}
	
	public function exportPurchaseReportListener(){
		if(isset($_GET['purchase'])){
			// output headers so that the file is downloaded rather than displayed
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Purchase_Report.csv');

			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');

			// output the column headings
			if(isset($_GET['credit'])){
				fputcsv($output, array('Purchase Type', 'Material', 'Supplier', "Date Purchased", "Credit Date", "Quantity", "Unit"));

			} else {
				fputcsv($output, array('Purchase Type', 'Material', 'Supplier', "Date Purchased", "Quantity", "Unit"));

			}

			$records = $this->db->query($_SESSION['lastQuery'])->fetchAll();
			
			foreach($records as $idx => $r){
			if(isset($_GET['credit'])){
				$data = array($r['type'],$r['materialname'],$r['vendorname'],$r['date_purchased'],$r['credit_date'],$r['qty'],$r['unit']);
			} else {
				$data = array($r['type'],$r['materialname'],$r['vendorname'],$r['date_purchased'],$r['qty'],$r['unit']);
			}
				fputcsv($output, $data);
			}

		}
	}

	public function filterPurchaseListener(){
		if(isset($_POST['filterPurchase'])){
			$records = $this->getPurchaseOrdersByType($_POST['type']);

			die(json_encode($records));
		}
	}

	public function getProductionData(){
		$sql = "
			select year(date_produced) as 'year', month(date_produced) as 'month',sum(quantity) as 'count', 'production' as 'name'
			from production
			where storeid = ".$_SESSION['storeid']."
			 and year(date_produced) = year(CURRENT_DATE)
			group by year(date_produced), month(date_produced)
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getSalesChartData(){
		$sql = "
			select year(date_purchased) as 'year', month(date_purchased) as 'month',sum(qty) as 'count', 'sales' as 'name'
			from sales
			where storeid = ".$_SESSION['storeid']."
			 and year(date_purchased) = year(CURRENT_DATE)
			group by year(date_purchased), month(date_purchased)
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function loadSalesVsProductionListener(){
		if(isset($_POST['loadSalesVsProduction'])){
			$sales = $this->getSalesChartData();
			$production = $this->getProductionData();

			$record = array_merge($sales, $production);

			$months = array(
				"1" => 0,
				"2" => 0,
				"3" => 0,
				"4" => 0,
				"5" => 0,
				"6" => 0,
				"7" => 0,
				"8" => 0,
				"9" => 0,
				"10" => 0,
				"11" => 0,
				"12" => 0
			);

			$data = array();

			foreach($record as $idx => $r){
				$m = $r['month'];
				$y = $r['year'];

				$data[$r['name']]['name'] = $r['name'];
				@$data[$r['name']][$m]['total'] +=  $r['count'];
			}

			$formatted = array();

			$counter = 0;

			foreach($data as $idx => $d){
				$formatted[$counter]['name'] = $d['name'];
				$formatted[$counter]['data'] = $months;

				foreach($months as $iidx => $m){
					if(array_key_exists($iidx, $d)){
						$formatted[$counter]['data'][$iidx] = $d[$iidx]['total'];
					}

				}

				$formatted[$counter]['data'] = array_values($formatted[$counter]['data']);

				$counter++;

			}

			die(json_encode($formatted));
		}
	}

	public function loadSalesChart($records, $key = false){
		$months = array(
			"Jan" => 0,
			"Feb" => 0,
			"Mar" => 0,
			"Apr" => 0,
			"May" => 0,
			"Jun" => 0,
			"Jul" => 0,
			"Aug" => 0,
			"Sep" => 0,
			"Oct" => 0,
			"Nov" => 0,
			"Dec" => 0
		);

		$data = array();

		foreach($records as $idx => $r){
			$producedDate = date_create($r['date_purchased']);
			$m = date_format($producedDate, "M");
			$y = date_format($producedDate, "Y");

			$data[$r['productid']]['name'] = $r['name'];
			@$data[$r['productid']][$m]['total'] +=  $r['qty'];
		}

		$formatted = array();

		$counter = 0;

		foreach($data as $idx => $d){
			$formatted[$counter]['name'] = $d['name'];
			$formatted[$counter]['data'] = $months;

			foreach($months as $iidx => $m){
				if(array_key_exists($iidx, $d)){
					$formatted[$counter]['data'][$iidx] = $d[$iidx]['total'];
				}

			}

			$formatted[$counter]['data'] = array_values($formatted[$counter]['data']);

			$counter++;

		}

		die(json_encode($formatted));
	}

	public function loadChart($records, $key = false){
		$months = array(
			"Jan" => 0,
			"Feb" => 0,
			"Mar" => 0,
			"Apr" => 0,
			"May" => 0,
			"Jun" => 0,
			"Jul" => 0,
			"Aug" => 0,
			"Sep" => 0,
			"Oct" => 0,
			"Nov" => 0,
			"Dec" => 0
		);

		$data = array();

		foreach($records as $idx => $r){
			$producedDate = ($key) ? date_create($r[$key]) : date_create($r['date_produced']);
			$m = date_format($producedDate, "M");
			$y = date_format($producedDate, "Y");

			$data[$r['productid']]['name'] = $r['name'];
			@$data[$r['productid']][$m]['total'] += ($key) ? $r['qty'] : $r['quantity'];
		}

		$formatted = array();

		$counter = 0;

		foreach($data as $idx => $d){
			$formatted[$counter]['name'] = $d['name'];
			$formatted[$counter]['data'] = $months;

			foreach($months as $iidx => $m){
				if(array_key_exists($iidx, $d)){
					$formatted[$counter]['data'][$iidx] = $d[$iidx]['total'];
				}

			}

			$formatted[$counter]['data'] = array_values($formatted[$counter]['data']);

			$counter++;

		}

		die(json_encode($formatted));
	}

	public function getMonthlyProductionReport(){
		if(isset($_POST['loadMonthlyProductChart'])){
			if(isset($_POST['year'])){
				$this->loadChart($this->getAllProductionByYear($_POST['year']));
			} else {
				$this->loadChart($this->getAllProduction());	
			}
		}
	}

	public function getMonthlySalesReportListener(){
		if(isset($_POST['loadMonthlySalesChart'])){
			$this->loadSalesChart( $this->getAllSaleByYear($_POST['year']) );
			// $sales = $this->getAllSales();
			// $this->loadChart($sales, "date_purchased");
		}
	}

	public function getMonthlyProductionReportByYear(){
		if(isset($_POST['loadMonthlyProductChartByYear'])){
			$this->loadChart($this->getAllProductionByYear($_POST['year']));
		}
	}

	public function updatePurchaseTypeListener(){
		if(isset($_POST['updatePurchaseType'])){
			$sql = "
				UPDATE purchase
				SET type = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['type'],$_POST['id']));

			die(json_encode(array("updated")));
		}
	}

	public function getStoreUnitsOfMeasurement(){
		$id = $_SESSION['storeid'];

		$sql = "
			select distinct(unit)
			from material_inventory
			where storeid = $id
			AND unit !=''
		";

		return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addMaterialInventoryListener(){
		if(isset($_POST['addMaterialInventory'])){
			$exists = $this->checkifMaterialInventoryExists($_SESSION['storeid'], $_POST['name']);

			if($exists){
				$this->errors[] = "This material exists in this store already.";
			} else {
				$this->success = "You have succesfully added this material.";
				$sql = "
					INSERT INTO material_inventory(storeid,name)
					VALUES(?,?)
				";

				$this->db->prepare($sql)->execute(array($_SESSION['storeid'],$_POST['name']));

				return $this;
			}
		}
	}

	public function formateDateToBasic($date){
		$newDate = date_create($date);

		return date_format($newDate,"Y-m-d");
	}

	public function addPurchaseListener(){
		if(isset($_POST['addPurchase'])){
			$ids = array();

			foreach($_POST['data'] as $idx => $d){
				$sql = "
					INSERT INTO purchase(vendorid,materialid,type,qty,date_purchased,storeid,credit_date,expiry_date,unit,price, remaining_qty)
					VALUES(?,?,?,?,?,?,?,?,?,?, ?)
				";
				$datePurchashed = $this->formateDateToBasic($d[4]);
				$dateExpired = $this->formateDateToBasic($d[6]);

				$this->db->prepare($sql)->execute(array($d[0],$d[1],$d[2],$d[3],$datePurchashed, $_SESSION['storeid'], $d[5], $dateExpired, $d[7], $d[8],$d[3]));

				$ids[] = $this->db->lastInsertId();

				$this->updateMaterialInventory($d[1], $d[3], true);
			}
			
			die(json_encode(array("ids" => implode("|", $ids))));
			

			return $this;
		}
	}

	public function updatePurchaseInventory($materialId, $orderedQty){
		$sql = "
			select t1.*
			from purchase t1
			where t1.storeid = ".$_SESSION['storeid']."
			and t1.remaining_qty > 0
			and t1.materialid = ".$materialId."
		";

		$records = $this->db->query($sql)->fetchAll();

		$ordered = $orderedQty;

		foreach($records as $idx => $r){
			$remainingQty = $r['remaining_qty'];

			if($ordered > $remainingQty){
				$sql = "
					update purchase
					set remaining_qty =  ?
					where id = ?
				";
			
				$this->db->prepare($sql)->execute(array(0, $r['id']));
				
				$ordered = $ordered - $remainingQty;
			} else {
				$sql = "
					update purchase
					set remaining_qty = remaining_qty - ?
					where id = ?
				";
			
				$this->db->prepare($sql)->execute(array($ordered, $r['id']));
			
				break;
			}
		}

		return $this;
	}

	public function updateProductionInventory($productId, $orderedQty){
		$sql = "
			select t1.*
			from production t1
			where t1.storeid = ".$_SESSION['storeid']."
			and t1.remaining_qty > 0
			and t1.productid = ".$productId." 
			and date(t1.date_expired) > date(CURRENT_DATE) 
		";

		$records = $this->db->query($sql)->fetchAll();

		$ordered = $orderedQty;

		foreach($records as $idx => $r){
			$remainingQty = $r['remaining_qty'];

			if($ordered > $remainingQty){
				$sql = "
					update production
					set remaining_qty =  ?
					where id = ?
				";
			
				$this->db->prepare($sql)->execute(array(0, $r['id']));
				
				$ordered = $ordered - $remainingQty;
			} else {
				$sql = "
					update production
					set remaining_qty = remaining_qty - ?
					where id = ?
				";
			
				$this->db->prepare($sql)->execute(array($ordered, $r['id']));
			
				break;
			}
		}

		return $this;
	}

	public function addSaleListener(){
		if(isset($_POST['addSale'])){
			foreach($_POST['data'] as $idx => $d){
				$sql = "
					INSERT INTO sales(storeid,productid,qty,date_purchased)
					VALUES(?,?,?,?)
				";

				$this->db->prepare($sql)->execute(array($_SESSION['storeid'], $d[0], $d[1], $d[2]));

				$this->updateProductionInventory($d[0], $d[1]);
				$this->updateProductInventory($d[0], $d[1]);
			}
			
			die(json_encode(array("added")));
			return $this;

			

			return $this;
		}
	}

	public function deleteProductionListener(){
		if(isset($_POST['deleteProduction'])){
			$sql = "
				DELETE FROM production
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("deleted")));
		}
	}

	public function getAllProduction($priorityId = false){
		$orderby = ($priorityId) ? "ORDER BY t1.id DESC" : "";

		$sql = "
			SELECT t1.*, t2.name ,t1.price as 'srp', if((date(CURRENT_DATE) >= date(t1.date_expired)), 'expired' , '') as 'isExpired'
			FROM production t1
			LEFT JOIN product t2
			ON t1.productid = t2.id
			WHERE t1.storeid = ".$_SESSION['storeid']."
			$orderby
		";	

		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllSaleByYear($year){
		if($year == ""){
			$year = date("Y");
		}

		if(isset($_POST['products'])){
			$sql = "
				SELECT t1.*, t2.name 
				FROM sales t1
				LEFT JOIN product t2
				ON t1.productid = t2.id
				WHERE t1.storeid = ".$_SESSION['storeid']."
				AND YEAR(t1.date_purchased) = ".$year."
				AND t1.productid in(".implode(",", $_POST['products']).")
			";	

		} else {
			$sql = "
				SELECT t1.*, t2.name 
				FROM sales t1
				LEFT JOIN product t2
				ON t1.productid = t2.id
				WHERE t1.storeid = ".$_SESSION['storeid']."
				AND YEAR(t1.date_purchased) = ".$year."
			";	

		}

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllProductionByYearAndMonth(){
		$sql = "
			SELECT t1.*, t2.name 
			FROM production t1
			LEFT JOIN product t2
			ON t1.productid = t2.id
			WHERE t1.storeid = ".$_SESSION['storeid']."
			AND YEAR(t1.date_produced) = ".$_POST['year']."
			AND MONTH(t1.date_produced) = '".$_POST['month']."'
		";	

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllProductionByYear($year){
		if(isset($_POST['products'])){
			$and = ($year == "") ? "" : "AND YEAR(t1.date_produced) = ".$year."
			AND t1.productid in(".implode(",", $_POST['products']).")";
			$sql = "
			SELECT t1.*, t2.name 
			FROM production t1
			LEFT JOIN product t2
			ON t1.productid = t2.id
			WHERE t1.storeid = ".$_SESSION['storeid']."
			$and
		";	

		} else {
			$and = ($year == "") ? "AND YEAR(t1.date_produced) = year(CURRENT_DATE)" : "AND YEAR(t1.date_produced) = ".$year;
			$sql = "
				SELECT t1.*, t2.name 
				FROM production t1
				LEFT JOIN product t2
				ON t1.productid = t2.id
				WHERE t1.storeid = ".$_SESSION['storeid']."
				$and
			";	
		}

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllSales(){
		$sql = "
			SELECT t1.*, t3.name ,t2.price as 'srp',t2.price * t1.qty as 'revenue'
			FROM sales t1
			LEFT JOIN production t2
			ON t1.productid = t2.productid
			left join product t3
			on t1.productid = t3.id
			WHERE t1.storeid = ".$_SESSION['storeid']."
			ORDER BY t1.id desc
		";	

		$_SESSION['lastSaleQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getPurchaseOrdersByType($type){
		$sql = "
			SELECT t1.*, t2.name as 'vendorname', t3.name as 'materialname'
			FROM purchase t1
			LEFT JOIN vendor t2
			ON t1.vendorid = t2.id
			LEFT JOIN material_inventory t3
			ON t1.materialid = t3.id
			WHERE t1.storeid = ".$_SESSION['storeid']."
			AND t1.type = '".$type."'
		";	

		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getPurchaseOrders(){
		$sql = "
			SELECT t1.*, t2.name as 'vendorname', t3.name as 'materialname'
			FROM purchase t1
			LEFT JOIN vendor t2
			ON t1.vendorid = t2.id
			LEFT JOIN material_inventory t3
			ON t1.materialid = t3.id
			WHERE t1.storeid = ".$_SESSION['storeid']."
		";	
		
		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getProductById($id){
		// $sql = "
		// 	select *
		// 	from product
		// 	where id = ?
		// 	limit 1
		// ";

		// return $this->db->query($sql)->fetch();
	}

	public function getAllMaterialInventoryByMaterialId($id){
		$sql = "
			select t1.*
			from material_inventory t1
			left join material t2
			on t2.materialid = t1.id
			where t2.id = $id
			limit 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function addProductionListener(){
		if(isset($_POST['addProduction'])){
			$products = array();
			$ids = array();

			foreach($_POST['data'] as $idx => $d){
				$materials = $this->getAllMaterials($d[0]);

				@$products[$d[0]]['name'] = $d[6];
				@$products[$d[0]]['qty'] += $d[1];

				foreach($materials as $idx => $m){
					$inventory = $this->getAllMaterialInventoryByMaterialId($m['id']);

					@$products[$d[0]][$m['id']]['qty'] += $m['qty'];
					@$products[$d[0]][$m['id']]['name'] = $inventory['name'];
					@$products[$d[0]][$m['id']]['stock'] = $inventory['qty'];
				}
			}

			$msg = "<ul>";
			$failed = false;
			// op();
			// opd($products);
			foreach($products as $idx => $p){
				$msg .= "<li>". $p['name'] ."(".$p['qty'].")";
				$msg .= "<ol>";

				foreach($p as $idx2 => $pp){
					if(is_array($pp)){
						$neededQty = $pp['qty'] * $p['qty'];
						$isSufficient = "";

						if($neededQty > $pp['stock']){
							$isSufficient = "insufficient";
							$failed = true;
						} 

						$msg .= "<li class='". $isSufficient ."'>".$pp['name'] ." (<b>".$neededQty."</b>/".$pp['stock'].")</li>";
					}

				}
				$msg .= "</ol></li>";
			}

			if($failed){
				die(json_encode(array("added" => false, "msg" => $msg)));
			} 

			foreach($_POST['data'] as $idx => $d){
				$sql = "
					INSERT INTO production(productid,batchnumber,quantity,date_produced,storeid,unit,date_expired,price, remaining_qty, rejects)
					VALUES(?,?,?,?,?,?,?,?,?, ?)
				";
				
				$datePurchashed = $this->formateDateToBasic($d[3]);
				$dateExpired = $this->formateDateToBasic($d[5]);

				$this->db->prepare($sql)->execute(array($d[0],$d[2],$d[1],$datePurchashed,$_SESSION['storeid'], $d[4], $dateExpired, $d[7], $d[1], $d[8]));
				
				$ids[] = $this->db->lastInsertId();

				$this->updateProductInventory($d[0], $d[1], true);

				// update material qty
				$materials = $this->getMaterialById($d[0]);

				foreach($materials as $midx => $m){
					$this->updatePurchaseInventory($m['materialid'], ($m['qty']*$d[1]));
					$this->updateMaterialInventory($m['materialid'], ($m['qty']*$d[1]));
				}
			}
			
			die(json_encode(array("added" => true, "msg" => $msg, "ids" => implode("|", $ids))));
		}
	}


	public function updateProductInventory($id,$qty, $add = false){
		if($add){
			//delete material of product
			//purchase order
			$sql = "
				UPDATE product
				SET qty = qty + ?
				WHERE id = ?
			";
		} else {
			// add material to product
			$sql = "
				UPDATE product
				SET qty = qty - ?
				WHERE id = ?
			";
		}

		$this->db->prepare($sql)->execute(array($qty, $id));

		return $this;
	}

	public function addVendorListener(){
		if(isset($_POST['addVendor'])){
			$exists = $this->checkifVendorExists($_SESSION['storeid'], $_POST['name']);

			if($exists){
				$this->errors[] = "This vendor was added already to this store.";

			} else {
				$sql = "
					INSERT INTO vendor(name,address,contact,storeid)
					VALUES(?,?,?,?)
				";

				$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['address'], $_POST['contact'], $_SESSION['storeid']));
				$this->success = "You have succesfully added this vendor.";
			}

			return $this;
		}
	}

	public function checkifVendorExists($id, $name){
		$sql = "
			SELECT *
			FROM vendor
			WHERE name = '".$name."'
			AND storeid = ".$id."
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function checkifMaterialInventoryExists($id, $name){
		$sql = "
			SELECT *
			FROM material_inventory
			WHERE name = '".$name."'
			AND storeid = ".$id."
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function searchProductListener(){
		if(isset($_POST['searchProduct'])) {
			$sql = "
				SELECT *
				FROM product
				WHERE name LIKE '%".$_POST['txt']."%'
				AND storeid = '".$_SESSION['storeid']."'
				LIMIT 20
			";

			$_SESSION['lastQuery'] = $sql;

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function searchProductLowListener(){
		if(isset($_POST['searchProductLow'])) {
			$limit = $this->getStoreStockLimit();
			$productLow = $limit['product_low'];

			$sql = "
				SELECT *
				FROM product
				WHERE name LIKE '%".$_POST['txt']."%'
				AND storeid = '".$_SESSION['storeid']."'
				and qty <= $productLow
			";

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function searchExpiredMaterialsListener(){
		if(isset($_POST['searchExpiredMaterial'])) {
			$sql = "
				SELECT t1.*, t2.name, if((date(CURRENT_DATE) >= date(t1.expiry_date)), 'expired' , '') as 'isExpired'
				FROM purchase t1 
				left join material_inventory t2
				on t1.materialid = t2.id
				WHERE t1.storeid = '".$_SESSION['storeid']."'
				AND t1.expiry_date <= date(CURRENT_DATE())
				AND t2.name LIKE '%".$_POST['txt']."%'
			";

			$_SESSION['lastQuery'] = $sql;

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function searchMaterialListener(){
		if(isset($_POST['searchMaterial'])) {
			$and = "";

			if(isset($_POST['status'])){
				if($_POST['status'] == "expired"){
					$and = "AND expiry_date <= date(CURRENT_DATE())";
				} elseif($_POST['status'] == "lowstock"){
					$limit = $this->getStoreStockLimit();
					$materialLow = $limit['material_low'];

					$and = " AND qty <= $materialLow";
				}
			}

			$sql = "
				SELECT *
				FROM material_inventory
				WHERE name LIKE '%".$_POST['txt']."%'
				AND storeid = '".$_SESSION['storeid']."'
				$and
				LIMIT 20
			";

			$_SESSION['lastQuery'] = $sql;

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function searchVendorListener(){
		if(isset($_POST['searchVendor'])) {
			$sql = "
				SELECT *
				FROM vendor
				WHERE name LIKE '%".$_POST['txt']."%'
				LIMIT 20
			";

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function uploadProfileListener(){
		if(isset($_POST['profile'])){
			$target_dir = "uploads/";
			$imageFileType = strtolower(pathinfo($_FILES["profile"]["name"],PATHINFO_EXTENSION));
			$target_file = $target_dir . basename($_SESSION['storeid'].".".$imageFileType);
			$uploadOk = 1;

			opp();

			// // Check if image file is a actual image or fake image
			// if(isset($_POST["submit"])) {
			//   $check = getimagesize($_FILES["profile"]["tmp_name"]);
			//   if($check !== false) {
			//     echo "File is an image - " . $check["mime"] . ".";
			//     $uploadOk = 1;
			//   } else {
			//     echo "File is not an image.";
			//     $uploadOk = 0;
			//   }
			// }

			// // Check if file already exists
			// if (file_exists($target_file)) {
			//   echo "Sorry, file already exists.";
			//   $uploadOk = 0;
			// }

			// // Check file size
			// if ($_FILES["fileToUpload"]["size"] > 500000) {
			//   echo "Sorry, your file is too large.";
			//   $uploadOk = 0;
			// }

			// // Allow certain file formats
			// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			// && $imageFileType != "gif" ) {
			//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			//   $uploadOk = 0;
			// }

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			  // echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			  if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
			    // echo "The file ". htmlspecialchars( basename( $_FILES["profile"]["name"])). " has been uploaded.";
			  } else {
			    // echo "Sorry, there was an error uploading your file.";
			  }
			}
		}
	}

	public function getUserProfile(){
		$sql = "
			SELECT t1.*,t2.photo as 'profilePicture'
			FROM userinfo t1
			LEFT JOIN user t2
			ON t1.userid = t2.id
			WHERE t1.userid = ".$_SESSION['id']."
			LIMIT 1
		";	

		return $this->db->query($sql)->fetch();
	}

	public function getUserById($id){
		$sql = "
			SELECT *
			FROM user
			WHERE id = ".$id."
			LIMIT 1
		";	
		

		return $this->db->query($sql)->fetch();
	}

	public function updateUserProfile(){
		if(!isset($_FILES['merchantProfilePicture'])){
			return $this;
		}

		$files = $_FILES['merchantProfilePicture']['tmp_name'];

		if($files){

			//start
			$merchantPath = 'uploads/user/'.$_SESSION['storeid']."/profile/";
			
		
			if(!file_exists($merchantPath)){
				mkdir($merchantPath,0777,true);
			}

			$folder_name = $merchantPath;

			 $temp_file = $_FILES['merchantProfilePicture']['tmp_name'];
			 $ext = strtolower(pathinfo($_FILES["merchantProfilePicture"]["name"],PATHINFO_EXTENSION));
			 $newName = md5($_FILES['merchantProfilePicture']['name']) .".".$ext;
			 $location = $folder_name . $newName;

			 if(move_uploaded_file($temp_file, $location)){
			 	$sql = "
					UPDATE user
					SET photo = ?
					WHERE id = ?
				";


				$this->db->prepare($sql)->execute(array($location, $_SESSION['id']));
			}
		} 

		return $this;
	}

	public function updateUserInfoListener(){
		if(isset($_POST['updateUserInfo'])){
			$id = $_SESSION['id'];

			$this->updateUserProfile();

			$sql = "
				UPDATE userinfo
				SET fullname = ?, address = ?, contact = ?, email = ?, bday = ?
				where userid = $id
			";

			$this->db->prepare($sql)->execute(array($_POST['fullname'], $_POST['address'], $_POST['contact'], $_POST['email'], $_POST['birthday']));

			$this->success = "You have sucesfully updated your personal information.";

			return $this;
		}
	}


	public function deleteMaterialListener(){
		if(isset($_POST['deleteMaterial'])){
			$sql = "
				DELETE FROM material
				WHERE materialid = ".$_POST['id']."
			";

			$this->db->prepare($sql)->execute(array());

			// $this->updateMaterialInventory($_POST['id'], $_POST['qty'], true);

			die(json_encode(array("deleted")));
		}
	}

	public function deletePurchaseListener(){
		if(isset($_POST['deletePurchase'])){
			$sql = "
				DELETE FROM purchase
				WHERE id = ".$_POST['id']."
			";

			$this->db->prepare($sql)->execute(array());
			
			$this->updateMaterialInventory($_POST['materialid'], $_POST['qty']);

			die(json_encode(array("deleted")));
		}
	}

	public function getMaterialsListener(){
		if(isset($_POST['getMaterials'])){
			$records = $this->getMaterialById($_POST['id']);

			die(json_encode($records));
		}
	}

	public function getMaterialById($id){
		$sql = "
			SELECT t1.*, t2.name, t2.price
			FROM material t1
			LEFT JOIN material_inventory t2
			ON t1.materialid = t2.id
			WHERE t1.productid = ".$id."
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function addMaterialListener(){
		if(isset($_POST['addMaterial'])){
			$data = array();

			if($this->findMaterialByMateralIdAndProductId($_POST['materialId'], $_POST['id'])){

				$data['added'] = false;
			} else {
				$sql = "
					INSERT INTO material(materialId,qty,productid,unit)
					VALUES(?,?,?,?)
				";	

				$this->db->prepare($sql)->execute(array($_POST['materialId'],  $_POST['qty'], $_POST['id'], $_POST['unit']));

				$data['added'] = true;
				$data['id'] = $this->db->lastInsertId();

				// $this->updateMaterialInventory($_POST['materialId'], $_POST['qty']);
			}

			die(json_encode($data));
		}
	}

	public function updateMaterialInventory($id,$qty, $add = false){
		if($add){
			//delete material of product
			//purchase order
			$sql = "
				UPDATE material_inventory
				SET qty = qty + ?
				WHERE storeid = ?
				AND id = ?
			";
		} else {
			// add material to product
			$sql = "
				UPDATE material_inventory
				SET qty = qty - ?
				WHERE storeid = ?
				AND id = ?
			";
		}

		$this->db->prepare($sql)->execute(array($qty, $_SESSION['storeid'], $id));

		return $this;
	}

	public function findMaterialByMateralIdAndProductId($mid, $id){
		$sql = "
			SELECT *
			FROM material
			WHERE materialid = ".$mid."
			AND productid = ".$id."
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}
	
	public function editvendorListener(){
		if(isset($_POST['editvendor'])){
			$sql = "
				UPDATE vendor
				SET name = ?, contact = ?, address = ?
				WHERE id = ?
			";
			$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['contact'], $_POST['address'], $_POST['editvendor']));

			die(json_encode($_POST));
		}
	}

	public function editProductInventoryListener(){
		if(isset($_POST['editproduct2'])){
			$sql = "
				UPDATE product
				SET name = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['editproduct2']));

			die(json_encode($_POST));
		}
	}

	public function editproductListener(){
		if(isset($_POST['editproduct'])){
			$sql = "
				UPDATE product
				SET srp = ?, qty = ?, expiry_date = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['price'], $_POST['qty'], $_POST['expiry'], $_POST['editproduct']));

			die(json_encode($_POST));
		}
	}

	public function editAllmaterialsListener(){
		if(isset($_POST['editallmaterial'])){
			$qtyDifference = 0;

			if($_POST['oldqty'] > $_POST['qty']){
				$qtyDifference = $_POST['oldqty'] - $_POST['qty']; 

				$this->updateMaterialInventory($_POST['materialid'], $qtyDifference);
			} else {
				$qtyDifference = $_POST['qty'] - $_POST['oldqty']; 

				$this->updateMaterialInventory($_POST['materialid'], $qtyDifference,true);
			}

			$sql = "
				UPDATE purchase
				SET  price = ?, qty = ?,expiry_date = ?, date_purchased = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array( $_POST['price'], $_POST['qty'], $_POST['expiry_date'], $_POST['date_purchased'], $_POST['editallmaterial']));

			die(json_encode($_POST));
		}
	}

	public function editMaterialListener(){
		if(isset($_POST['editmaterial'])){
			$sql = "
				UPDATE material_inventory
				SET name = ?, unit = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['unit'], $_POST['editmaterial']));

			die(json_encode($_POST));
		}
	}

	public function deleteProductListener(){
		if(isset($_POST['deleteProduct'])){
			$sql = "
				DELETE from product
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("added")));
		}
	}


	public function deleteMaterialInventoryListener(){
		if(isset($_POST['deleteMaterialInventory'])){
			$sql = "
				DELETE from material_inventory
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));
			$this->deleteMaterialsById($_POST['id']);

			die(json_encode(array("added")));
		}
	}

	public function deleteMaterialsById($id){
		$sql = "
			DELETE FROM material
			WHERE materialid = ?
		";
		
		$this->db->prepare($sql)->execute(array($id));

		return $this;
	}

	public function deleteSaleListener(){
		if(isset($_POST['deleteSale'])){
			$sql = "
				DELETE from sales
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("added")));
		}
	}

	public function deleteVendorListener(){
		if(isset($_POST['deleteVendor'])){
			$sql = "
				DELETE from vendor
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['id']));

			die(json_encode(array("added")));
		}
	}

	public function searchAllProductsListener(){
		if(isset($_POST['searchAllProducts'])) {
			$sql = "
				SELECT t1.*,t2.name,if((date(CURRENT_DATE) >= date(t1.date_expired)), 'expired' , '') as 'isExpired'
				FROM production t1
				left join product t2
				on t1.productid = t2.id
				WHERE t1.storeid = '".$_SESSION['storeid']."'
				AND t2.name LIKE '%".$_POST['txt']."%'
			";

			$_SESSION['lastQuery'] = $sql;

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function searchExpiredProductsListener(){
		if(isset($_POST['searchProductExpired'])) {
			$sql = "
				SELECT t1.*,t2.name, if((date(CURRENT_DATE) >= date(t1.date_expired)), 'expired' , '') as 'isExpired'
				FROM production t1
				left join product t2
				on t1.productid = t2.id
				WHERE t1.storeid = '".$_SESSION['storeid']."'
				AND t1.date_expired <= date(CURRENT_DATE())
				AND t2.name LIKE '%".$_POST['txt']."%'
			";

			$_SESSION['lastQuery'] = $sql;

			$data = $this->db->query($sql)->fetchAll();

			die(json_encode($data));
		}
	}

	public function getExpiredProducts(){
		$sql = "
			SELECT t1.*,t2.name, if((date(CURRENT_DATE) >= date(t1.date_expired)), 'expired' , '') as 'isExpired'
			FROM production t1
			left join product t2
			on t1.productid = t2.id
			WHERE t1.storeid = '".$_SESSION['storeid']."'
			AND t1.date_expired <= date(CURRENT_DATE())
		";

		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getInstockProducts(){
		$sql = "
			SELECT *
			FROM product
			WHERE storeid = '".$_SESSION['storeid']."'
			AND qty > 0
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllProducts($lowStock = false){
		$sql = "
			SELECT *
			FROM product
			WHERE storeid = '".$_SESSION['storeid']."'
		";

		if($lowStock){
			$limit = $this->getStoreStockLimit();
			$productLow = $limit['product_low'];

			$sql = "
				SELECT *
				FROM product
				WHERE storeid = '".$_SESSION['storeid']."'
				AND qty <= $productLow
			";
		}

		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getExpiredMaterials(){
		$sql = "
			SELECT t1.*, t2.name, if((date(CURRENT_DATE) >= date(t1.expiry_date)), 'expired' , '') as 'isExpired'
			FROM purchase t1 
			left join material_inventory t2
			on t1.materialid = t2.id
			WHERE t1.storeid = '".$_SESSION['storeid']."'
			AND t1.expiry_date <= date(CURRENT_DATE())
		";

		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllMaterialInventory($lowStock = false){
		$sql = "
			SELECT *
			FROM material_inventory 
			WHERE storeid = '".$_SESSION['storeid']."'
		";

		if($lowStock){
			$limit = $this->getStoreStockLimit();
			$materialLow = $limit['material_low'];

			$sql = "
				SELECT *
				FROM material_inventory
				WHERE storeid = '".$_SESSION['storeid']."'
				AND qty <= $materialLow
			";
		}

		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllPurchase($priorityId = false){
		$orderby = ($priorityId) ? "ORDER BY t1.id DESC" : "";

		$sql = "
			select t1.*,t2.name, t3.name as 'vendorname', t3.id as 'vendorid',
			if((date(CURRENT_DATE) >= date(t1.expiry_date)), 'expired' , '') as 'isExpired'
			from purchase t1
			left join material_inventory t2
			on t1.materialid = t2.id
			left join vendor t3
			on t1.vendorid = t3.id
			WHERE t1.storeid = '".$_SESSION['storeid']."'
			$orderby
		";

		$_SESSION['lastQuery'] = $sql;

		return $this->db->query($sql)->fetchAll();

	}

	public function getAllMaterials($productId = false){
		$and = ($productId) ? " AND t2.id = $productId" : "";

		$sql = "
			SELECT t1.*
			FROM material t1
			LEFT JOIN product t2 
			ON t1.productid = t2.id
			WHERE t2.storeid = '".$_SESSION['storeid']."'
			$and
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getAllVendors(){
		$sql = "
			SELECT *
			FROM vendor
			WHERE storeid = '".$_SESSION['storeid']."'
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function getProductCount(){
		$sql = "
			SELECT count(id) as total
			FROM product
			WHERE storeid = '".$_SESSION['storeid']."'
		";

		$record =  $this->db->query($sql)->fetch();

		if($record){
			return $record['total'];
		} else {
			return 0;
		}
	}

	public function getVendorCount(){
		$sql = "
			SELECT count(id) as total
			FROM vendor
			WHERE storeid = '".$_SESSION['storeid']."'
		";

		$record =  $this->db->query($sql)->fetch();

		if($record){
			return $record['total'];
		} else {
			return 0;
		}
	}

	public function getMaterialCount(){
		$sql = "
			SELECT count(id) as total
			FROM material_inventory
			WHERE storeid = '".$_SESSION['storeid']."'
		";

		$record =  $this->db->query($sql)->fetch();

		if($record){
			return $record['total'];
		} else {
			return 0;
		}
	}

	//for easy deletion of records
	public function reset(){
		$sql = array();

		// $sql[] = "delete from store";
		// $sql[] = "delete from user where usertype!='admin'";
		$sql[] = "delete from product";
		$sql[] = "delete from payments";
		$sql[] = "delete from notification";
		$sql[] = "delete from production";
		$sql[] = "delete from material";
		$sql[] = "delete from purchase";
		$sql[] = "delete from production";
		$sql[] = "delete from sales";
		// $sql[] = "delete from subscription";
		$sql[] = "delete from material_inventory";
		// $sql[] = "delete from userinfo where userid!=36";

		foreach ($sql as $key => $s) {
			$this->db->query($s);
		}

	}

	public function addProductListener(){
		if(isset($_POST['addproduct'])){
			$sql = "
				SELECT *
				FROM product
				WHERE name = '".$_POST['name']."'  AND storeid = '".$_SESSION['storeid']."'
				LIMIT 1
			";

			$exists = $this->db->query($sql)->fetch();
	

			if(!$exists){
				$sql = "
					INSERT INTO product(name,storeid)
					VALUES(?,?)
				";

				$this->db->prepare($sql)->execute(array($_POST['name'], $_SESSION['storeid']));

				$this->success = "You have sucesfully added this product.";

			} else {
				$this->errors[] = "You already have this product added before.";
			}

			return $this;
		}
	}

	public function preventReaccessIfPayed(){
		$current = date('Y-m-d');
		$planEnd = $this->getSubscriptionExpiration();

		//redirect if d paexpire
		if(strtotime($current) < strtotime($planEnd)){
			header("Location:dashboard.php");

		} 
	}

	public function getSubscriptionExpiration(){
		$sql = "
			SELECT t1.duration, t3.captured_at
			FROM subscription t1
			LEFT JOIN store t2
			ON t1.id = t2.subscriptionid
			LEFT JOIN payments t3
			ON t3.payment_id = t2.last_payment_id
			WHERE t2.userid = ".$_SESSION['id']."
			LIMIT 1
		";

		$data = $this->db->query($sql)->fetch();

		return $effectiveDate = date('Y-m-d', strtotime("+".$data['duration']." months", strtotime($data['captured_at'])));
	}

	public function checkIfPayed(){
		$sql = "
			SELECT *
			FROM payments
			WHERE userid = ".$_SESSION['id']."
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
			$exists = $this->db->query($sql)->fetch();
	}

	public function showSuccessMessage(){
		return $this->success;
	}
	
	public function getStoreStockLimit(){
		$sql = "
			SELECT t1.material_low, t1.product_low
			FROM store t1
			WHERE t1.userid = ". $_SESSION['id']."
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function getUserStore(){
		$sql = "
			SELECT t1.*,t2.duration, t2.cost
			FROM store t1
			LEFT JOIN subscription t2
			ON t1.subscriptionid = t2.id
			WHERE t1.userid = ". $_SESSION['id']."
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();
	}

	public function getAllUnverifiedStores(){
		$sql = "
			SELECT t1.*
			FROM store t1
			LEFT JOIN user t2
			ON t1.userid = t2.id 
			WHERE  t2.verified = 0
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function addSubscriptionListener(){
		if(isset($_POST['plan'])){
			$this->addUser();
			$this->addStore();
			//d2
			$sql = "
				UPDATE store
				SET subscriptionid = ? 
				WHERE id = ? 
			";

			$this->db->prepare($sql)->execute(array($_POST['plan'], $_SESSION['laststoreid']));


			//wait for admin to verify this store

			$data = array(
				"added" => true
			);

			die(json_encode($data));
		}
	}

	public function addStoreListener(){
		if(isset($_POST['addstore'])){
			$sql = "
				SELECT *
				FROM store
				WHERE name = '".$_POST['name']."'
			";

			$exists = $this->db->query($sql)->fetch();

			if($exists){
				$this->errors[] = "Store name already exists.";

				$data = array(
					"errors" => $this->errors,
					"added" => false
				);

			} else {
				$_SESSION['setup']['store'] = $_POST['name'];
				$_SESSION['setup']['b_address'] = $_POST['adddress'];
				$_SESSION['setup']['dti'] = $_POST['dti'];
				$_SESSION['setup']['b_email'] = $_POST['email'];
				$_SESSION['setup']['b_contact'] = $_POST['contact'];

				$data = array("added" => true);
			}
			
			die(json_encode($data));
		}
	}

	public function addStore(){
		$sql = "
			INSERT INTO store(name,userid,b_address,dti,b_email,b_contact)
			VALUES(?,?,?,?,?,?)
		";

		$this->db->prepare($sql)->execute(array($_SESSION['setup']['store'], $_SESSION['lastinsertedid'],$_SESSION['setup']['b_address'],$_SESSION['setup']['dti'],$_SESSION['setup']['b_email'],$_SESSION['setup']['b_contact']));

		$_SESSION['laststoreid'] = $this->db->lastInsertId();

		return $this;
	}

	public function loginListener(){
		if(isset($_POST['login'])){
			$sql = "
				SELECT t1.*, t4.fullname, t2.id as 'storeId', t3.is_trial, t3.duration
				FROM user t1
				LEFT JOIN store t2
				ON t1.id = t2.userid
				left join subscription t3
				on t2.subscriptionid = t3.id
				left join userinfo t4 
				on t4.userid = t1.id
				WHERE username = '".$_POST['username']."'
				AND password = '".md5($_POST['password'])."'

				LIMIT 1
			";

			$exists = $this->db->query($sql)->fetch();

			if(! $exists){
				$this->errors[] = "Invalid Account";
			} else {
				//redirect to dashboard
				$_SESSION['id'] = $exists['id'];
				$_SESSION['username'] = $exists['username'];
				$_SESSION['name'] = $exists['fullname'];
				$_SESSION['storeid'] = $exists['storeId'];
				$_SESSION['usertype'] = $exists['usertype'];

				//check if trial
				if($exists['is_trial']){
					//check if expired
					$effectiveDate = date('Y-m-d', strtotime("+".$exists['duration']." months", strtotime($exists['date_created'])));
					$current = date('Y-m-d');

					if(strtotime($current) <= (strtotime($effectiveDate))){
						$_SESSION['verified'] = 1;
						$_SESSION['isTrial'] = 1;
						$_SESSION['trialEnd'] = $effectiveDate;
					}
				} else {
					$_SESSION['verified'] = $exists['verified'];
				}

				if($exists['usertype'] == "admin"){
					header("Location:users.php");
				} else {
					$this->getStoreNotifications();

					header("Location:dashboard.php");
				}
			}
			

			return $this;
		}
	}

	public function addPersonalListener(){
		if(isset($_POST['addPersonal'])){
			$_SESSION['setup']['p_fullname'] = $_POST['fullname'];
			$_SESSION['setup']['p_address'] = $_POST['address'];
			$_SESSION['setup']['p_contact'] = $_POST['contact'];
			$_SESSION['setup']['p_email'] = $_POST['email'];
			
			$data = array("added" => true);

			die(json_encode($data));
		}
	}

	public function signUpListener(){
		if(isset($_POST['signup'])){
			//authentication
			$this->checkPassword();
			$this->checkUsernameIfExists();

			if(!count($this->errors)){
				$_SESSION['setup']['username'] = $_POST['username'];
				$_SESSION['setup']['password'] = $_POST['password'];
				// $this->addUser();

				$data = array("added" => true);
			} else {
				$data = array(
					"errors" => $this->errors,
					"added" => false
				);
			}
			
			die(json_encode($data));
		}
	}

	public function addUserInfoById($id){
		$sql = "
			INSERT INTO userinfo(userid, fullname, address, contact, email)
			VALUES(?,?,?,?,?)
		";

		$this->db->prepare($sql)->execute(array($id , $_SESSION['setup']['p_fullname'], $_SESSION['setup']['p_address'], $_SESSION['setup']['p_contact'], $_SESSION['setup']['p_email']));

		return $this;
	}

	public function addUser(){
		$sql = "
			INSERT INTO user(username,password)
			VALUES(?,?)
		";
		$this->db->prepare($sql)->execute(array($_SESSION['setup']['username'], md5($_SESSION['setup']['password'])));
		
		$_SESSION['lastinsertedid'] = $this->db->lastInsertId();

		$this->addUserInfoById($this->db->lastInsertId());

		return $this;
	}	

	public function checkUsernameIfExists(){
		$sql = "
			SELECT *
			FROM user
			WHERE username = '".$_POST['username']."'
			LIMIT 1
		";
		$exists = $this->db->query($sql)->fetch();

		if($exists){
			$this->errors[] = "Username already exists";
		} 

		return $this;
	}

	public function checkPassword(){
		if(strlen($_POST['password']) <6){
			$this->errors[] = "Password is too short.";
		}

		if($_POST['password'] != $_POST['password1']){
			$this->errors[] = "Passwords doesn't matched";
		}

		return $this;
	}

	public function getErrors(){
		return $this->errors;
	}

}