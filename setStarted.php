<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['userId']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    $currentTime = date("Y-m-d H:i:s");
    $controller->setStarted($_POST['userId'], $currentTime);

}

echo json_encode($aResult);
