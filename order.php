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

if(isset($_SESSION['id']) && $_GET['id']){
    $total = 0;
    $data = $databaseHandler->getOrder($_SESSION['id'], $_GET['id'])[0];

    if(isset($data['coupon']) && $data['coupon'] != null){
        $coupon = $databaseHandler->getCoupon($data['coupon'])[0];
    }else{
        $coupon = null;
    }

    $productList = explode("|", $data['products']);
    $productArray = array();

    $productSql = "(";

    foreach($productList as $product){
        $productId = explode(",", $product)[0];
        $productSql .= ":id" . $productId . ",";
        $productArray[":id" . $productId] = $productId;
    }
    $productSql = substr($productSql, 0, -1);
    $productSql .= ")";

    $sql = "SELECT * FROM products WHERE id IN " . $productSql;

    $productResult = $databaseHandler->getProductsFromId($sql, $productArray);
}
else{
    header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . "/E-commerce-CMS/index.php");
}

?>


<html class="no-js">
    <head>
        <?php
        echo '
                <title>Order '. $_GET['id'] .' - '. $config['site_name'] . '</title>
        ';
        ?>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/checkout.css' />
        <link rel='stylesheet' type='text/css' href='css/order.css' />
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
                <?php
                if($_SESSION['id'] != $data['customer']){
                    header("Location: index.php");
                }
                ?>
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">
                        <div class="cell large-12">
                            <div class="card" style="margin-top:1rem;">
                                <div class="card-section primary-colour card-header">
                                    Order details:
                                </div>
                                <div class="card-section">
                                    Order details:
                                    <table class="unstriped">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Description</td>
                                                <td>Cost</td>
                                                <td>Quantity</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($productResult as $product){
                                                $quantity = 0;
                                                foreach($productList as $getQuantity){
                                                    $productQuantity = explode(",", $getQuantity);
                                                    if($product['id'] == $productQuantity[0]){
                                                        $quantity = $productQuantity[1];
                                                    }
                                                }

                                                echo '<tr class="table-row-padding">';
                                                echo '<td>'. $product['name'] .'</td>';
                                                echo '<td>'. $product['description'] .'</td>';
                                                if($coupon != null){
                                                    echo '<td>'. "£" . number_format($product['cost'], 2) .'<br> Discount cost: £'. number_format($product['cost'] - ($product['cost'] * ($coupon['amount'] / 100)), 2) .'</td>';
                                                }else{
                                                    echo '<td>'. "£" . number_format($product['cost'], 2) .'</td>';
                                                }
                                                $total += $product['cost'] * $quantity;
                                                echo '<td>'. $quantity .'</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-section">
                                    Shipping details: <br>
                                    <?php $shipping = $databaseHandler->getShippingCost($data['shipping_id']); ?>
                                    <?php 
                                    echo "Shipping type: " . $shipping['shipping_type'];
                                    echo "<br>Shipping cost: " . "£" . number_format($shipping['shipping_cost'], 2);
                                    ?>
                                </div>
                                <?php
                                if($coupon != null){
                                    echo'<div class="card-section">';
                                    echo "Coupon used: " . $coupon['code'];
                                    echo'</div>';
                                }
                                ?>
                                <div class="card-section">
                                    Order total: <?php  echo "£" . number_format($total + $shipping['shipping_cost'], 2);?>
                                    <br>
                                    After discount total: <?php  echo "£" . number_format(($total - ($total * ($coupon['amount'] / 100))) + $shipping['shipping_cost'], 2);?>
                                </div>
                                <div class="card-section">
                                    Status: <?php  echo $data['status']; ?>
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