<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['testId']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    $controller->savePairQuestion($_POST['testId'], $_POST['name'], $_POST['text'],$_POST['content']);

}

echo json_encode($aResult);