<?php

	$db = "bakedph";
	$username = "root";
	$password = "";
	$host = "localhost";
	$charset = "utf8";

	$db = new PDO("mysql:host=$host;dbname=$db;charset=$charset;", $username, $password);

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