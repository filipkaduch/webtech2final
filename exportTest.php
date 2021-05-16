<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();
$id = htmlspecialchars($_GET["id"]);

if(isset($_GET["id"])){
    $controller->exportTest($id);
}
else {
    if (!isset($_POST['id'])) {
        $aResult['error'] = 'No  arguments!';
    }

    if (!isset($aResult['error'])) {
        $controller->exportTest($id);
    }
}
?>