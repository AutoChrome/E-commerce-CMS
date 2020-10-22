<?php
include_once("../../objects/DatabaseHandler.php");

$databaseHandler = new DatabaseHandler();

if(isset($_POST['function'])){
    if($_POST['function'] == "validate"){
        if(isset($_POST['email'])){
            if($databaseHandler->validateEmail($_POST['email']) == true){
                echo "true";
            }else{
                echo "false";
            }
        }
    }
    if($_POST['function'] == "create"){
        $databaseHandler->createUser($_POST['user']);
    }
    if($_POST['function'] == "promote"){
        $databaseHandler->promoteUser($_POST['id']);
    }
    if($_POST['function'] == "demote"){
        $databaseHandler->demoteUser($_POST['id']);
    }
    if($_POST['function'] == "ban"){
        $databaseHandler->banUser($_POST['id']);
    }
    if($_POST['function'] == "unban"){
        $databaseHandler->unbanUser($_POST['id']);
    }
}
?>