<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['testId']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    $currentTime = date("Y-m-d H:i:s");
    $controller->setFinished($_POST['userId'], $currentTime);
    $controller->submitAnswers($_POST['userId'], $_POST['testId']);

}

echo json_encode($aResult);
