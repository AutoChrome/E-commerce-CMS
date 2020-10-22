<?php
include("../objects/DatabaseHandler.php");
$databaseHandler = new DatabaseHandler();

print_r($databaseHandler->getCookieUser($_COOKIE['rememberme']));

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

print_r($_SESSION);
?>