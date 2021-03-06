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

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['id'])){
    $data = $databaseHandler->getLatestOrder($_SESSION['id']);
    
    $ordernumber = $data[0]['id'];
}
else{
    header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . "/E-commerce-CMS/index.php");
}

?>


<html class="no-js">
    <head>
        <?php
        echo '
                <title>Checkout completed! - '. $config['site_name'] . '</title>
        ';
        ?>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/checkout.css' />
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
            <div class="body center">
                <div class="grid-container">
                    <div class="grid-x grid-padding-x align-middle">
                        <div class="cell large-6 large-offset-3 checkout">
                            <div class="card">
                                <div class="card-section card-header primary-colour">Order completed</div>
                                <div class="card-section">
                                    Your order is currently processing. 
                                    <br>
                                    <br>
                                    To review the current progress please go to your profile and view the order there or click on the link below.
                                    <br>
                                    <br>
                                    Order number: <a <?php echo 'href="order.php?id=' . $ordernumber . '"';?>>#<?php echo $ordernumber; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        <script src="js/toastr/toastr.min.js"></script>
    </body>
</html>