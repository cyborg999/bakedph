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
		$this->addMaterialListener();
		$this->getMaterialsListener();
		$this->deleteMaterialListener();
		$this->updateUserInfoListener();
	}	

	public function getUserProfile(){
		$sql = "
			SELECT *
			FROM userinfo
			WHERE userid = ".$_SESSION['id']."
			LIMIT 1
		";	
		

		return $this->db->query($sql)->fetch();
	}

	public function updateUserInfoListener(){
		if(isset($_POST['updateUserInfo'])){
			$sql = "
				UPDATE userinfo
				SET fullname = ?, address = ?, contact = ?, email = ?, bday = ?
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
				WHERE id = ".$_POST['id']."
			";

			$this->db->prepare($sql)->execute(array());

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
			SELECT *
			FROM material
			WHERE productid = ".$id."
		";

		return $this->db->query($sql)->fetchAll();
	}

	public function addMaterialListener(){
		if(isset($_POST['addMaterial'])){
			$data = array();

			if($this->findMaterialByNameAndProductId($_POST['name'], $_POST['id'])){

				$data['added'] = false;
			} else {
				$sql = "
					INSERT INTO material(name,price,qty,productid)
					VALUES(?,?,?,?)
				";	

				$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['srp'], $_POST['qty'], $_POST['id']));

				$data['added'] = true;
				$data['id'] = $this->db->lastInsertId();
			}

			die(json_encode($data));
		}
	}

	public function findMaterialByNameAndProductId($name, $id){
		$sql = "
			SELECT *
			FROM material
			WHERE name = '".$name."'
			AND productid = ".$id."
			LIMIT 1
		";

		return $this->db->query($sql)->fetch();


	}

	public function editproductListener(){
		if(isset($_POST['editproduct'])){
			$sql = "
				UPDATE product
				SET name = ?, srp = ?, qty = ?, expiry_date = ?
				WHERE id = ?
			";

			$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['price'], $_POST['qty'], $_POST['expiry'], $_POST['editproduct']));

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

	public function getAllProducts(){
		$sql = "
			SELECT *
			FROM product
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

	//for easy deletion of records
	public function reset(){
		$sql = array();
		$sql[] = "delete from store";
		$sql[] = "delete from user";
		$sql[] = "delete from product";
		$sql[] = "delete from material";
		$sql[] = "delete from userinfo";

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
					INSERT INTO product(name,srp,qty,expiry_date,storeid)
					VALUES(?,?,?,?,?)
				";

				$this->db->prepare($sql)->execute(array($_POST['name'], $_POST['price'],$_POST['qty'],$_POST['expiry'],$_SESSION['storeid']));

				$this->success = "You have sucesfully added this product.";

			} else {
				$this->errors[] = "You already have this product added before.";
			}

			return $this;
		}
	}

	public function showSuccessMessage(){
		return $this->success;
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
			$sql = "
				UPDATE store
				SET subscription = ? 
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
				$sql = "
					INSERT INTO store(name,userid)
					VALUES(?,?)
				";

				$this->db->prepare($sql)->execute(array($_POST['name'], $_SESSION['lastinsertedid']));

				$_SESSION['laststoreid'] = $this->db->lastInsertId();
				
				$data = array("added" => true);
			}
			
			die(json_encode($data));
		}
	}

	public function loginListener(){
		if(isset($_POST['login'])){
			$sql = "
				SELECT t1.*, t2.id as 'storeId'
				FROM user t1
				LEFT JOIN store t2
				ON t1.id = t2.userid
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
				$_SESSION['storeid'] = $exists['storeId'];

				header("Location:dashboard.php");
			}
			

			return $this;
		}
	}

	public function signUpListener(){
		if(isset($_POST['signup'])){

			//authentication
			$this->checkPassword();
			$this->checkUsernameIfExists();

			if(!count($this->errors)){
				$this->addUser();

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
			INSERT INTO userinfo(userid)
			VALUES(?)
		";

		$this->db->prepare($sql)->execute(array($id));

		return $this;
	}

	public function addUser(){
		$sql = "
			INSERT INTO user(username,password)
			VALUES(?,?)
		";

		$this->db->prepare($sql)->execute(array($_POST['username'], md5($_POST['password'])));
		
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