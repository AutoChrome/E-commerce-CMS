<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/objects/DatabaseHandler.php";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/objects/DatabaseHandler.php";
}

include_once($dir);
//Product manager
function generateURL($field){
    parse_str($_SERVER['QUERY_STRING'], $queries);
    if(isset($_GET['sortBy']) && $_GET['sortBy'] === $field){
        if(isset($_GET['direction'])){
            switch($_GET['direction']){
                case "asc":
                    $queries['direction'] = "desc";
                    return "href=?" . http_build_query($queries);
                    break;
                case "desc":
                    unset($queries['direction']);
                    unset($queries['sortBy']);
                    return "href=?" . http_build_query($queries);
                    break;
                case "none":
                    $queries['direction'] = "asc";
                    return "href=?" . http_build_query($queries);
                    break;
            }
        }
    }
    $queries['sortBy'] = $field;
    $queries['direction'] = "asc";
    return "href=?" . http_build_query($queries);
}

function generateSpan($field){
    if(isset($_GET['direction']) && isset($_GET['sortBy'])){
        if($field == $_GET['sortBy']){
            switch($_GET['direction']){
                case "asc":
                    return "<span><i class='fas fa-sort-up'></i></span>";
                    break;
                case "desc":
                    return "<span><i class='fas fa-sort-down'></i></span>";
                    break;
            }
        }
    }
}

function removePageOptions($options){
    if (array_key_exists("page", $options)) {
        unset($options['page']);
    }
    if (array_key_exists("limit", $options)) {
        unset($options['limit']);
    }
    if (array_key_exists("sortBy", $options)) {
        unset($options['sortBy']);
    }
    if (array_key_exists("direction", $options)) {
        unset($options['direction']);
    }
    return $options;
}

//Settings

function update_ini_file($data){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/database.json";
    if(!file_exists($dir)){
        $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/database.json";
    }
    try{
        $handle = fopen($dir, "w");
        if(fwrite($handle, json_encode($data))){
            fclose($handle);
            echo "success";
        }else{
            echo "error";
        }
    }catch(Exception $e){
        echo "error";
    }
}
if(isset($_POST['function'])){
    switch($_POST['function']){
        case "update_ini_file": {
            update_ini_file($_POST['config']);
            break;
        }
        case "updateStripe":{
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/config.json";
            if(!file_exists($dir)){
                $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/config.json";
            }
            $json = file_get_contents($dir);

            $config = json_decode($json, true);

            $config[1]['stripe-publishable'] = $_POST['publishable-key'];
            $config[1]['stripe-secret'] = $_POST['secret-key'];
            try{
                $handle = fopen($dir, "w");
                if(fwrite($handle, json_encode(array_values($config)))){
                    fclose($handle);
                    echo "success";
                }else{
                    echo "error";
                }
            }catch(Exception $e){
                echo "error";
            }
            break;
        }
        case "deleteWidget":{
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/front-page.json";
            if(!file_exists($dir)){
                $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/front-page.json";
            }
            $json = file_get_contents($dir);

            $config = json_decode($json, true);

            unset($config[0]['enabled-widgets'][$_POST['id']]);

            $config[0]['enabled-widgets'] = array_values($config[0]['enabled-widgets']);


            try{
                $handle = fopen($dir, "w");
                if(fwrite($handle, json_encode(array_values($config)))){
                    fclose($handle);
                    echo "success";
                }else{
                    echo "error";
                }
            }catch(Exception $e){
                echo "error";
            }
            break;
        }
        case "addWidget":{
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/front-page.json";
            if(!file_exists($dir)){
                $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/front-page.json";
            }
            $json = file_get_contents($dir);

            $config = json_decode($json, true);
            array_push($config[0]['enabled-widgets'], array("type" => "widget", "url" => $_POST['url']));
            try{
                $handle = fopen($dir, "w");
                if(fwrite($handle, json_encode($config))){
                    fclose($handle);
                    echo "success";
                }else{
                    echo "error";
                }
            }catch(Exception $e){
                echo "error";
            }
            break;
        }
        case "addCustomArea":{
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/front-page.json";
            if(!file_exists($dir)){
                $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/front-page.json";
            }
            $json = file_get_contents($dir);

            $config = json_decode($json, true);

            $options = array("header-size" => $_POST['size'], "header" => $_POST['header'], "text" => $_POST['text'], "alignment" => "center");

            $textArea = array("type" => "text", "options" => $options);

            array_push($config[0]['enabled-widgets'], $textArea);

            try{
                $handle = fopen($dir, "w");
                if(fwrite($handle, json_encode($config))){
                    fclose($handle);
                    echo "success";
                }else{
                    echo "error";
                }
            }catch(Exception $e){
                echo "error";
            }
            break;
        }
        case "updateWidgetList":{
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/front-page.json";
            if(!file_exists($dir)){
                $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/front-page.json";
            }
            $json = file_get_contents($dir);

            $config = json_decode($json, true);
            $newConfig = $config;

            for($i = 0; $i < sizeof($config[0]['enabled-widgets']); $i++){
                $newConfig[0]['enabled-widgets'][$i] = $config[0]['enabled-widgets'][$_POST['list'][$i]];
            }
            
            try{
                $handle = fopen($dir, "w");
                if(fwrite($handle, json_encode($newConfig))){
                    fclose($handle);
                    echo "success";
                }else{
                    echo "error";
                }
            }catch(Exception $e){
                echo "error";
            }
            break;
        }
        case "updateColour":{
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/config.json";
            if(!file_exists($dir)){
                $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/config.json";
            }
            $json = file_get_contents($dir);

            $config = json_decode($json, true);
            $config[0]['primary-colour'] = $_POST['primary-colour'];
            $config[0]['secondary-colour'] = $_POST['secondary-colour'];
            $config[0]['button-colour'] = $_POST['button-colour'];
            $config[0]['button-hover-colour'] = $_POST['button-hover-colour'];
            try{
                $handle = fopen($dir, "w");
                if(fwrite($handle, json_encode($config))){
                    fclose($handle);
                    echo "success";
                }else{
                    echo "error";
                }
            }catch(Exception $e){
                echo "error";
            }
            break;
        }
    }
}
?>