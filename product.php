<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/database.json";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/database.json";
}

$json = file_get_contents($dir);

$config = json_decode($json, true);
include_once("objects/DatabaseHandler.php");
include_once("objects/product.php");
$databaseHandler = new DatabaseHandler();

$tempProduct = $databaseHandler->getProduct($_GET['id']);
$product = new Product($tempProduct['id'], $tempProduct['name'], $tempProduct['cost'], $tempProduct['description'], $tempProduct['quantity'], $tempProduct['tags'], $tempProduct['type'], $tempProduct['section_name']);
if(isset($_COOKIE['accept-cookies'])){
    if(isset($_COOKIE["products"])){
        $productList = explode("|", $_COOKIE['products']);

        $setcookie = true;
        foreach(explode(",", $tempProduct['tags']) as $tag){
            $setcookie = true;
            foreach($productList as $cookieProduct){
                if($cookieProduct == $tag){
                    $setcookie = false;
                }
            }
            if($setcookie == true){
                array_push($productList, $tag);
            }
        }

        setrawcookie("products", implode("|", $productList), time() + (84600 * 365), "/");
    }else{
        $productList = array();
        foreach(explode(",", $tempProduct['tags']) as $tag){
            array_push($productList, $tag);
        }
        setrawcookie("products", implode("|", $productList), time() + (84600 * 365), "/");
    }
}
?>


<html class="no-js">
    <head>
        <?php
        echo '
                <title>'.$product->name.' - '. $config['site_name'] .'</title>
        ';
        ?>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/product.css' />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="js/vendor/foundation.js"></script>
        <link rel="stylesheet" href="css/toastr.min.css"/>

    </head>

    <body>
        <?php 
        if(!isset($_COOKIE['allow_cookie'])){
            include("widgets/cookie_request.php");
        }
        ?>
        <div class="container">
            <div class="header">
                <?php
                include("widgets/navigation.php");
                ?>
            </div>
            <div class="body">
                <?php include_once("widgets/productWidget.php");?>
            </div>
            <div class="grid-container full footer">
                <?php include_once("widgets/footer.php"); ?>
            </div>
        </div>
        <script>
            $(document).foundation();
        </script>
        <script src="js/custom-scripts/cookie.js"></script>
        <script src="js/custom-scripts/searchbar.js"></script>
        <script src="js/custom-scripts/product.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
    </body>
</html>