<?php
include_once "./model.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>BakedPH</title>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" >
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <br>
                <?php
                    $model = new Model();
                    $settings = $model->getAdminSetting(true);
                    echo $settings['terms'];
                ?>
            </div>
        </div>
    </div>
</body>
</html>