<?php
include_once("../objects/DatabaseHandler.php");

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
    if($_POST['function'] == "login"){
        $databaseHandler->loginUser($_POST['user']);
    }
    if($_POST['function'] == "update"){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $currentUser = $databaseHandler->getUser($_SESSION['id']);

        if($databaseHandler->validatePassword($_SESSION['id'], $_POST['data']['password'])){
            if($_POST['data']['email'] != $currentUser['email']){
                if($databaseHandler->validateEmail($_POST['data']['email'])){
                    $parameters = array('first_name' => $_POST['data']['first_name'], 'last_name' => $_POST['data']['last_name'], 'other_name' => $_POST['data']['other_name'], 'telephone' => $_POST['data']['telephone'], 'email' => $_POST['data']['email'], 'address' => $_POST['data']['address'], 'postcode' => $_POST['data']['postcode'], 'town' => $_POST['data']['town'], 'dob' => $_POST['data']['dob'], 'id' => $_SESSION['id']);
                    $result = $databaseHandler->updateUser($parameters);
                    if($result == 1){
                        echo "true";
                    }else{
                        return;
                    }
                }else{
                    return;
                }
            }else{
                $parameters = array('first_name' => $_POST['data']['first_name'], 'last_name' => $_POST['data']['last_name'], 'other_name' => $_POST['data']['other_name'], 'telephone' => $_POST['data']['telephone'], 'address' => $_POST['data']['address'], 'postcode' => $_POST['data']['postcode'], 'town' => $_POST['data']['town'], 'dob' => $_POST['data']['dob'], 'id' => $_SESSION['id']);
                $result = $databaseHandler->updateUser($parameters);
                
                if($result == 1){
                    echo "true";
                }else{
                    return;
                }

            }
        }else{
            echo "incorrect-password";
        }
    }
    if($_POST['function'] == "changePassword"){
        $result = $databaseHandler->changePassword($_POST['currentPassword'], $_POST['newPassword']);
        echo $result;
    }
}
?>