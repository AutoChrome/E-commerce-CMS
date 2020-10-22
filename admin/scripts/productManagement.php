<?php
include_once("../../objects/DatabaseHandler.php");
include_once("../../objects/product.php");

$databaseHandler = new DatabaseHandler();
if(isset($_POST['function'])){
    if($_POST['function'] == "update"){
        $data = json_decode($_POST['data'], true);
        $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/img/products/" . $data['id'] . "/";
        if(isset($_FILES['image'])){
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            echo $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS";
            if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS")){
                $dir = $_SERVER['DOCUMENT_ROOT'] . "/img/products/" . $data['id'] . "/";
            }
            if(!file_exists($dir)){
                mkdir($dir);
            }
            move_uploaded_file($_FILES['image']["tmp_name"], $dir . "thumbnail." . $ext);
        }
        if(isset($_FILES['gallery'])){
            if(!file_exists($dir . "gallery")){
                mkdir($dir . "gallery");
            }
            for($i = 0; $i < sizeof($_FILES['gallery']['name']); $i++){
                move_uploaded_file($_FILES['gallery']['tmp_name'][$i], $dir . "gallery" . "/" . $_FILES['gallery']['name'][$i]);
            }
        }
        $databaseHandler->updateProduct($data);
    }
    if($_POST['function'] == "create"){
        $data = json_decode($_POST['data'], true);
        $id = $databaseHandler->createProduct($data);
        if($id > -1){
            $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/img/products/" . $id . "/";
            if(isset($_FILES['image'])){
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS")){
                    $dir = $_SERVER['DOCUMENT_ROOT'] . "/img/products/" . $id . "/";
                }
                if(!file_exists($dir)){
                    mkdir($dir);
                }
                move_uploaded_file($_FILES['image']["tmp_name"], $dir . "thumbnail." . $ext);
            }
            if(isset($_FILES['gallery'])){
                if(!file_exists($dir . "gallery")){
                    mkdir($dir . "gallery");
                }
                for($i = 0; $i < sizeof($_FILES['gallery']['name']); $i++){
                    move_uploaded_file($_FILES['gallery']['tmp_name'][$i], $dir . "gallery" . "/" . $_FILES['gallery']['name'][$i]);
                }
            }
            echo "true";
        }else{
            echo "false";
        }
    }
    if($_POST['function'] == "delete"){
        $idArray = array();

        $idArray['id'] = $_POST['id'];
        $databaseHandler->deleteProduct($idArray);
    }
    if($_POST['function'] == "deleteImage"){
        $image = $_POST['image'];
        $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/img/products/" . $_POST['id'] . "/gallery/";
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS")){
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/img/products/" . $_POST['id'] . "/gallery/";
        }
        if(unlink($dir . $image)){
            echo "true";
        }else{
            echo "false";
        }
    }
    
    if($_POST['function'] == "addCategory"){
        $databaseHandler->addCategory($_POST['category']);
    }
}
?>