<?php
include_once("../../objects/DatabaseHandler.php");
include_once("../../objects/product.php");

$databaseHandler = new DatabaseHandler();

if(isset($_POST['function'])){
    if($_POST['function'] == "createCoupon"){
        if(strtotime($_POST['expiry']) > time()){
            $databaseHandler->createCoupon($_POST['code'], $_POST['description'], $_POST['discount'], $_POST['usages'], $_POST['expiry']);
        }else{
            echo "expired-coupon";
        }
    }else if($_POST['function'] == "updateCoupon"){
        if(strtotime($_POST['expiry']) > time()){
            $databaseHandler->updateCoupon($_POST['id'], $_POST['code'], $_POST['description'], $_POST['discount'], $_POST['usages'], $_POST['expiry']);
        }else{
            echo "expired-coupon";
        }
    }
}
?>