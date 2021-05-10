<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['id']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    $rows = $controller->savePaintQuestion($_POST['id'], $_POST['name'], $_POST['text'],$_POST['content']);
}

echo json_encode($rows);

