<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['id']) ) { $aResult['error'] = 'No  arguments!'; }
if( !isset($aResult['error']) ) {
    $startTimeDate = $_POST['startTimeDate'];
    $startTime = $_POST['startTime'];
    $dateTime = date_create($startTimeDate.' '.$startTime);
    $date = $dateTime->format("Y-m-d H:m");
    $controller->saveTest($_POST['id'], $_POST['name'], $date, $_POST['time']);

}

echo json_encode($aResult);
