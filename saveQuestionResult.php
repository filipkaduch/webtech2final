<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['testId']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    $jsonString = "{result:".$_POST['content']."}";
    $controller->saveAnswer($_POST['testId'], $_POST['userId'], $_POST['questionId'], $jsonString);

}

echo json_encode($aResult);