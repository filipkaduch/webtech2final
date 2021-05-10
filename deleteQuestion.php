<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['questionId']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    $controller->deleteQuestion($_POST['questionId']);

}

echo json_encode($aResult);