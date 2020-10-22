<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/database.json";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/database.json";
}

$json = file_get_contents($dir);

$config = json_decode($json, true);

$json = file_get_contents("configs/front-page.json");
$layout = json_decode($json, true);

include_once("scripts/drawCustomArea.php");
include_once("objects/DatabaseHandler.php");
$databaseHandler = new DatabaseHandler();
?>


<html class="no-js">
    <head>
        <?php
        echo '
                <title>Homepage - '. $config['site_name'] .'</title>
        ';
        ?>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/main.php' />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="js/vendor/foundation.js"></script>

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
                <?php
                if(sizeof($layout[0]["enabled-widgets"]) > 0){
                    foreach($layout[0]["enabled-widgets"] as $widget){
                        if($widget["type"] === "widget"){
                            if(file_exists("widgets/front-page/" . $widget["url"])){
                                include('widgets/front-page/' . $widget["url"]);
                                echo "<hr>";
                            }
                        }else if($widget["type"] === "text"){
                            echo "<div class='grid-container'>";
                            switch($widget['options']['header-size']){
                                case "Small":{
                                    echo "<h3 style='text-align:center'>Contact us</h3>";
                                    break;
                                }
                                case "Medium":{
                                    echo "<h2 style='text-align:center'>Contact us</h2>";
                                    break;
                                }
                                case "Large":{
                                    echo "<h1 style='text-align:center'>Contact us</h1>";
                                    break;
                                }
                            }
                            echo "<p style='text-align:center'>".$widget['options']['text']. "</p>";
                            echo "</div><hr>";
                        }
                    }
                }
                ?>
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
    </body>
</html>