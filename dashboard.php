<?php 
	include_once "./model.php";

	$model = new Model();
	$err = $model->getErrors();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
	<a href="logout.php">logout</a>
	<h2>Dashboard</h2>
</body>
</html>