<?php
header('Content-Type: application/json');

$aResult = array();

switch($_POST['functionname']){
    case "updateWidget":
        $json = file_get_contents("../../configs/front-page.json");

        $configs = json_decode($json, true);
        $loadList = $_POST['data'];
        $configs[0]['enabled-widgets'] = $loadList;
        $aResult['success'] = "true";
        file_put_contents("../../configs/front-page.json", json_encode($configs));
        echo json_encode($aResult);
        break;
    default:
        $aResult['error'] = "Function not defined";
        echo json_encode($aResult);
        break;
}
?>