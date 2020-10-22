<?php
include_once("../../objects/DatabaseHandler.php");

$databaseHandler = new DatabaseHandler();

if(isset($_POST['function'])){
    if($_POST['function'] == "updateStatus"){
        if($databaseHandler->updateTransactionStatus($_POST['id'], $_POST['status'])){
            echo "true";
        }else{
            echo "false";
        }
    }
}
?>