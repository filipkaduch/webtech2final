<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['id']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    echo $_POST['content'];
    $controller->getTestQuestions($_POST['id']);

}

echo json_encode($aResult);
