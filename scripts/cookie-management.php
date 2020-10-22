<?php
include_once("../objects/DatabaseHandler.php");
$databaseHandler = new DatabaseHandler();
if(isset($_POST['cookie_set_request'])){
    if($_POST['cookie_set_request'] == "accept-cookies"){
        setcookie("accept-cookies", true, time() + (84600 * 365), "/");
    }else if($_POST['cookie_set_request'] == "deny-cookies"){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['accept-cookies'] = false;
    }
}
?>