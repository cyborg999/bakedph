<?php
require_once "vendor/autoload.php";
use Omnipay\Omnipay;

$db = "bakedph";
$username = "root";
$password = "";
$host = "localhost";
$charset = "utf8";

$db = new PDO("mysql:host=$host;dbname=$db;charset=$charset;", $username, $password);


 
  
// Connect with the database 
$stripeDB = new mysqli($host, $username, $password, $db);
   
if ($stripeDB->connect_errno) {
    die("Connect failed: ". $stripeDB->connect_error);
}
  
$gateway = Omnipay::create('Stripe');
$gateway->setApiKey('sk_test_51HsSJeJmfnsrzK571DnyysUarPcyEeRilLEVowF17n6MU5aJ5Vj9VBCaEEBm5bhuPPblYs2JjdAYanLq4iQI0dfz00VN23qHFc');

	function op($data){
		echo "<pre>";
		print_r($data);
	}

	function opd($data){
		op($data);
		die();
	}

	function opp(){
		echo "<pre>";
		print_r($_POST);
	}

	function oppd(){
		opp();
		die();
	}