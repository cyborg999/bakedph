<?php
session_start();

class Model {
	public $db;
	public $errors = array();

	public function __construct(){
		require_once "config.php";

		$this->db = $db;

		$this->signUpListener();
		$this->loginListener();
		$this->addStoreListener();
		$this->addSubscriptionListener();
		$this->getAllUnverifiedStores();
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
				SELECT *
				FROM user
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

	public function addUser(){
		$sql = "
			INSERT INTO user(username,password)
			VALUES(?,?)
		";

		$this->db->prepare($sql)->execute(array($_POST['username'], md5($_POST['password'])));
		
		$_SESSION['lastinsertedid'] = $this->db->lastInsertId();

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